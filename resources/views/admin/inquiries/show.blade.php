@extends('admin.layouts.admin')

@section('title', 'Inquiry Details')

@section('admin_content')
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.inquiries.index') }}" style="color:#2271b1; text-decoration:none;">&larr; Back to all inquiries</a>
    </div>

    <h1 class="wp-heading-inline">Confidential Inquiry &mdash; {{ $inquiry->full_name }}</h1>
    <span class="status-pill status-{{ $inquiry->status }}" style="margin-left:12px; font-size:12px;">
        {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
    </span>
    <hr class="wp-header-end" style="margin-bottom:20px; border:none;">

    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:24px;">
        <!-- Left: Inquiry Content -->
        <div class="postbox">
            <div class="postbox-header">
                <h2>Submission Details</h2>
            </div>
            <div class="inside" style="line-height:1.8;">
                <div style="margin-bottom:20px;">
                    <strong style="color:#1d2327; display:block; font-size:13px;">Full Name:</strong>
                    <span style="font-size:16px; font-weight:600;">{{ $inquiry->full_name }}</span>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div>
                        <strong style="color:#1d2327; display:block; font-size:13px;">Email Address:</strong>
                        <a href="mailto:{{ $inquiry->email }}" style="color:#2271b1; font-size:14px;">{{ $inquiry->email }}</a>
                    </div>
                    <div>
                        <strong style="color:#1d2327; display:block; font-size:13px;">Phone Number:</strong>
                        <span style="font-size:14px;">{{ $inquiry->phone ?? 'Not provided' }}</span>
                    </div>
                </div>

                <div style="margin-bottom:24px; background:#f9f9f9; padding:16px; border:1px solid #e5e5e5; border-radius:4px;">
                    <strong style="color:#1d2327; display:block; font-size:13px; margin-bottom:6px;">Circumstances Described:</strong>
                    <p style="font-size:14px; color:#2c3338; line-height:1.7; white-space:pre-wrap;">{{ $inquiry->circumstances }}</p>
                </div>

                @if($inquiry->motivation)
                    <div style="margin-bottom:24px; background:#f9f9f9; padding:16px; border:1px solid #e5e5e5; border-radius:4px;">
                        <strong style="color:#1d2327; display:block; font-size:13px; margin-bottom:6px;">Motivation / What Led to Stonebridge:</strong>
                        <p style="font-size:14px; color:#2c3338; line-height:1.7; white-space:pre-wrap;">{{ $inquiry->motivation }}</p>
                    </div>
                @endif

                <div style="font-size:12px; color:#8c8f94; border-top:1px solid #f0f0f1; padding-top:12px;">
                    Received on: {{ $inquiry->created_at->format('l, F j, Y \a\t g:i A') }} ({{ $inquiry->created_at->diffForHumans() }})
                </div>
            </div>
        </div>

        <!-- Right: Status & Notes -->
        <div class="postbox">
            <div class="postbox-header">
                <h2>Manage Status & Private Notes</h2>
            </div>
            <div class="inside">
                <form action="{{ route('admin.inquiries.update', $inquiry->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:16px;">
                        <label for="status" style="display:block; font-weight:600; margin-bottom:6px;">Inquiry Status:</label>
                        <select name="status" id="status" class="large-text" style="font-size:13px; padding:6px;">
                            <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New (Unread)</option>
                            <option value="in_review" {{ $inquiry->status === 'in_review' ? 'selected' : '' }}>In Review by Carl</option>
                            <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Contacted / Scheduled</option>
                            <option value="archived" {{ $inquiry->status === 'archived' ? 'selected' : '' }}>Archived / Closed</option>
                        </select>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label for="admin_notes" style="display:block; font-weight:600; margin-bottom:6px;">Confidential Internal Notes:</label>
                        <textarea name="admin_notes" id="admin_notes" rows="6" class="large-text" placeholder="Add private notes regarding referral origin, schedule, or discretion parameters...">{{ $inquiry->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="button button-primary" style="width:100%;">Update Record</button>
                </form>

                <div style="margin-top:20px; padding-top:16px; border-top:1px solid #f0f0f1; text-align:right;">
                    <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Permanently remove this confidential inquiry record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-danger button-small">Delete Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
