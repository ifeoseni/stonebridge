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
     * Store an incoming private inquiry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'circumstances' => 'required|string|min:10',
            'motivation' => 'nullable|string',
        ]);

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
}
