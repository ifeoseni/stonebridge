<?php

namespace App\Http\Controllers;

use App\Mail\PrivateInquiryReceivedMail;
use App\Models\PrivateInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    /**
     * Minimum number of seconds a genuine visitor needs to read the form and type an answer.
     * Bots that submit immediately after loading the page are rejected.
     */
    private const MIN_FILL_SECONDS = 3;

    /**
     * Store an incoming private inquiry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'circumstances' => 'required|string',
            'motivation' => 'nullable|string',
            'hp_note' => 'nullable|string',
            'form_rendered_at' => 'nullable|integer',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'full_name.max' => 'Full name must be under 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'That email address does not look valid — please check it.',
            'email.max' => 'Email address must be under 255 characters.',
            'phone.max' => 'Phone number must be under 50 characters.',
            'circumstances.required' => 'Please add a brief description of your circumstances.',
        ], [
            'full_name' => 'Full name',
            'email' => 'Email address',
            'phone' => 'Phone number',
            'circumstances' => 'Circumstances',
            'motivation' => 'Motivation',
        ]);

        // Too-fast submissions are almost always bots, but a real visitor testing
        // quickly would otherwise lose their message silently. Ask them to retry
        // instead of faking success — the second attempt will pass the timer.
        // (Submissions already flagged as spam/scam below skip the retry and
        // go straight to quarantine.)
        $elapsed = $this->secondsSinceRendered($validated);
        $spamReason = $this->spamReason($validated);
        if ($elapsed !== null && $elapsed < self::MIN_FILL_SECONDS && $spamReason === null) {
            Log::info('Private Inquiry submitted too quickly, asking to retry.', [
                'ip' => $request->ip(),
                'elapsed_seconds' => $elapsed,
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please take a moment to complete the form, then submit again.',
                    'errors' => ['form' => ['Please take a moment to complete the form, then submit again.']],
                ], 422);
            }

            return back()->withErrors(['form' => 'Please take a moment to complete the form, then submit again.'])->withInput();
        }

        if ($spamReason !== null) {
            Log::info('Private Inquiry submission flagged as spam.', [
                'ip' => $request->ip(),
                'spam_reason' => $spamReason,
                'elapsed_seconds' => $elapsed,
            ]);

            // Quarantine mode (default): keep the submission in the database
            // so it can be reviewed in the admin inbox — but NEVER send an
            // email notification for it. Flip INQUIRY_STORE_SPAM=false to
            // silently discard spam instead (nothing stored).
            if (config('inquiry.store_spam', true)) {
                try {
                    PrivateInquiry::create([
                        'full_name' => $validated['full_name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'] ?? null,
                        'circumstances' => $validated['circumstances'],
                        'motivation' => $validated['motivation'] ?? null,
                        'status' => 'new',
                        'is_spam' => true,
                        'spam_reason' => $spamReason,
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Failed to quarantine spam Private Inquiry: ' . $e->getMessage(), [
                        'exception' => $e,
                    ]);
                }
            }

            // Respond as if it succeeded so automated senders don't adapt or retry.
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your inquiry has been received with strict confidentiality. Carl Malmsten will review it personally and respond in due course.',
                ]);
            }

            return back()->with('success', 'Your inquiry has been received with strict confidentiality.');
        }

        try {
            $inquiry = PrivateInquiry::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'circumstances' => $validated['circumstances'],
                'motivation' => $validated['motivation'] ?? null,
                'status' => 'new',
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to save Private Inquiry: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'We could not save your inquiry. Please try again in a moment.',
                ], 500);
            }

            return back()->withErrors(['form' => 'We could not save your inquiry. Please try again.'])->withInput();
        }

        // Dispatch Email Notification to configured contact recipient.
        // The inquiry is already saved at this point; a mail failure must
        // never look like a form failure — it is only logged.
        $mailSent = true;
        try {
            $recipient = config('mail.contact_recipient', config('mail.from.address'));
            if (!empty($recipient)) {
                Mail::to($recipient)->send(new PrivateInquiryReceivedMail($inquiry));
            } else {
                $mailSent = false;
                Log::warning('Private Inquiry saved but no contact recipient configured.', [
                    'inquiry_id' => $inquiry->id,
                ]);
            }
        } catch (\Throwable $e) {
            $mailSent = false;
            Log::error('Failed to dispatch Private Inquiry email notification: ' . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
                'exception' => $e,
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your inquiry has been received with strict confidentiality. Carl Malmsten will review it personally and respond in due course.',
                'id' => $inquiry->id,
                'mail_sent' => $mailSent,
            ]);
        }

        return back()->with('success', 'Your inquiry has been received with strict confidentiality.');
    }

    /**
     * Definite spam/scam signals. Returns a short reason code for quarantine
     * (stored on the record, no email sent), or null when clean.
     *
     * Signals: honeypot filled, link flooding, and classic advance-fee /
     * phishing scam content (lottery, inheritance, wire transfers, ...).
     */
    private function spamReason(array $validated): ?string
    {
        // 1. Honeypot: a field real visitors never see or fill, but form-filling bots do.
        if (filled($validated['hp_note'] ?? null)) {
            return 'honeypot';
        }

        $freeText = ($validated['circumstances'] ?? '') . ' ' . ($validated['motivation'] ?? '');

        // 2. Link flooding: free-text fields stuffed with multiple URLs are almost always spam.
        if (preg_match_all('#https?://|www\.#i', $freeText) >= 2) {
            return 'link_flooding';
        }

        // 3. Scam content: classic fraud / phishing / money-mule markers.
        if ($this->containsScamMarkers($freeText)) {
            return 'scam_content';
        }

        return null;
    }

    /**
     * Classic scam markers. A single strong marker (lottery win, inheritance
     * payout, wire-transfer request, ...) quarantines immediately; weaker
     * money-lure terms need at least two hits to avoid false positives on
     * genuine family-office / portfolio inquiries.
     */
    private function containsScamMarkers(string $text): bool
    {
        $strong = [
            'lottery', 'lotto', 'inheritance', 'beneficiary fund', 'wire transfer',
            'western union', 'moneygram', 'gift card', 'double your money',
            'guaranteed returns', 'urgent payment', 'bank login', 'account password',
            'otp code', 'verification code', 'social security', 'claim your prize',
            'transfer fee', 'release fee', 'customs fee',
        ];

        $weak = [
            'crypto', 'bitcoin', 'btc', 'forex', 'trading signals',
            'investment opportunity', 'loan offer', 'prize', 'winner',
            'claim your', 'million dollars', 'offshore account', 'money transfer',
            'risk-free', 'risk free',
        ];

        $lower = mb_strtolower($text);

        foreach ($strong as $marker) {
            if (str_contains($lower, $marker)) {
                return true;
            }
        }

        $hits = 0;
        foreach ($weak as $marker) {
            if (str_contains($lower, $marker) && ++$hits >= 2) {
                return true;
            }
        }

        return false;
    }

    private function secondsSinceRendered(array $validated): ?int
    {
        $renderedAt = $validated['form_rendered_at'] ?? null;

        if (!$renderedAt) {
            return null;
        }

        return max(0, now()->timestamp - (int) $renderedAt);
    }
}
