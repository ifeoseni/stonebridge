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
        ]);

        if ($this->looksLikeSpam($request, $validated)) {
            Log::info('Private Inquiry submission rejected as spam.', [
                'ip' => $request->ip(),
                'honeypot_filled' => filled($validated['hp_note'] ?? null),
                'elapsed_seconds' => $this->secondsSinceRendered($validated),
            ]);

            // Respond as if it succeeded so automated senders don't adapt or retry.
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your inquiry has been received with strict confidentiality. Carl Malmsten will review it personally and respond in due course.',
                ]);
            }

            return back()->with('success', 'Your inquiry has been received with strict confidentiality.');
        }

        $inquiry = PrivateInquiry::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'circumstances' => $validated['circumstances'],
            'motivation' => $validated['motivation'] ?? null,
            'status' => 'new',
        ]);

        // Dispatch Email Notification to configured contact recipient
        try {
            $recipient = config('mail.contact_recipient', config('mail.from.address'));
            if (!empty($recipient)) {
                Mail::to($recipient)->send(new PrivateInquiryReceivedMail($inquiry));
            }
        } catch (\Throwable $e) {
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
            ]);
        }

        return back()->with('success', 'Your inquiry has been received with strict confidentiality.');
    }

    /**
     * Lightweight, dependency-free spam screen: honeypot, minimum fill time, and a link-flooding check.
     */
    private function looksLikeSpam(Request $request, array $validated): bool
    {
        // 1. Honeypot: a field real visitors never see or fill, but form-filling bots do.
        if (filled($validated['hp_note'] ?? null)) {
            return true;
        }

        // 2. Time trap: genuine visitors need at least a few seconds to read and type; bots submit instantly.
        $elapsed = $this->secondsSinceRendered($validated);
        if ($elapsed !== null && $elapsed < self::MIN_FILL_SECONDS) {
            return true;
        }

        // 3. Link flooding: free-text fields stuffed with multiple URLs are almost always spam.
        $freeText = ($validated['circumstances'] ?? '') . ' ' . ($validated['motivation'] ?? '');
        if (preg_match_all('#https?://|www\.#i', $freeText) >= 2) {
            return true;
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
