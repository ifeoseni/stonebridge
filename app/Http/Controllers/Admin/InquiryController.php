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

        if ($status && in_array($status, ['new', 'contacted', 'in_review', 'archived'])) {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(15);
        $counts = [
            'all' => PrivateInquiry::count(),
            'new' => PrivateInquiry::where('status', 'new')->count(),
            'contacted' => PrivateInquiry::where('status', 'contacted')->count(),
            'in_review' => PrivateInquiry::where('status', 'in_review')->count(),
            'archived' => PrivateInquiry::where('status', 'archived')->count(),
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
        $inquiry = PrivateInquiry::findOrFail($id);
        $inquiry->status = $request->input('status', $inquiry->status);
        $inquiry->admin_notes = $request->input('admin_notes', $inquiry->admin_notes);
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
