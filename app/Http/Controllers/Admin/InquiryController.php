<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivateInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display all private client inquiries
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = PrivateInquiry::latest();

        if ($status === 'spam') {
            $query->where('is_spam', true);
        } else {
            // Quarantined spam lives in its own view — keep the workflow
            // buckets (All aside) free of it.
            $query->where('is_spam', false);

            if ($status && in_array($status, ['new', 'contacted', 'in_review', 'archived'])) {
                $query->where('status', $status);
            }
        }

        $inquiries = $query->paginate(15);
        $counts = [
            'all' => PrivateInquiry::count(),
            'new' => PrivateInquiry::where('is_spam', false)->where('status', 'new')->count(),
            'contacted' => PrivateInquiry::where('is_spam', false)->where('status', 'contacted')->count(),
            'in_review' => PrivateInquiry::where('is_spam', false)->where('status', 'in_review')->count(),
            'archived' => PrivateInquiry::where('is_spam', false)->where('status', 'archived')->count(),
            'spam' => PrivateInquiry::where('is_spam', true)->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts', 'status'));
    }

    /**
     * Show a single inquiry detail
     */
    public function show($id)
    {
        $inquiry = PrivateInquiry::findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Update inquiry status and admin notes
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:new,contacted,in_review,archived',
            'admin_notes' => 'nullable|string|max:5000',
            'is_spam' => 'sometimes|boolean',
        ]);

        $inquiry = PrivateInquiry::findOrFail($id);
        if (array_key_exists('status', $validated)) {
            $inquiry->status = $validated['status'];
        }
        if (array_key_exists('admin_notes', $validated)) {
            $inquiry->admin_notes = $validated['admin_notes'];
        }
        if (array_key_exists('is_spam', $validated)) {
            $inquiry->is_spam = (bool) $validated['is_spam'];
            if (! $inquiry->is_spam) {
                $inquiry->spam_reason = null;
            }
        }
        $inquiry->save();

        return redirect()->route('admin.inquiries.show', $inquiry->id)
            ->with('success', 'Inquiry record updated.');
    }

    /**
     * Delete an inquiry
     */
    public function destroy($id)
    {
        PrivateInquiry::destroy($id);
        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry removed.');
    }
}
