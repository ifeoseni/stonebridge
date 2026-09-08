@extends('admin.layouts.admin')

@section('title', 'Private Inquiries')

@section('admin_content')
    <h1 class="wp-heading-inline">Confidential Inquiries</h1>
    <hr class="wp-header-end" style="margin-bottom:16px; border:none;">

    <!-- Filter Views Link Bar (WordPress Standard) -->
    <ul class="subsubsub" style="list-style:none; margin:8px 0 16px; padding:0; display:flex; gap:12px; font-size:13px;">
        <li>
            <a href="{{ route('admin.inquiries.index') }}" class="{{ empty($status) ? 'current' : '' }}" style="{{ empty($status) ? 'font-weight:600; color:#000;' : 'color:#2271b1; text-decoration:none;' }}">
                All <span class="count">({{ $counts['all'] }})</span>
            </a> |
        </li>
        <li>
            <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="{{ $status === 'new' ? 'current' : '' }}" style="{{ $status === 'new' ? 'font-weight:600; color:#000;' : 'color:#2271b1; text-decoration:none;' }}">
                New <span class="count">({{ $counts['new'] }})</span>
            </a> |
        </li>
        <li>
            <a href="{{ route('admin.inquiries.index', ['status' => 'in_review']) }}" class="{{ $status === 'in_review' ? 'current' : '' }}" style="{{ $status === 'in_review' ? 'font-weight:600; color:#000;' : 'color:#2271b1; text-decoration:none;' }}">
                In Review <span class="count">({{ $counts['in_review'] }})</span>
            </a> |
        </li>
        <li>
            <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}" class="{{ $status === 'contacted' ? 'current' : '' }}" style="{{ $status === 'contacted' ? 'font-weight:600; color:#000;' : 'color:#2271b1; text-decoration:none;' }}">
                Contacted <span class="count">({{ $counts['contacted'] }})</span>
            </a> |
        </li>
        <li>
            <a href="{{ route('admin.inquiries.index', ['status' => 'archived']) }}" class="{{ $status === 'archived' ? 'current' : '' }}" style="{{ $status === 'archived' ? 'font-weight:600; color:#000;' : 'color:#2271b1; text-decoration:none;' }}">
                Archived <span class="count">({{ $counts['archived'] }})</span>
            </a>
        </li>
    </ul>

    <div class="postbox" style="margin-top:12px;">
        <div class="inside" style="padding:0;">
            @if($inquiries->count() > 0)
                <table class="wp-list-table">
                    <thead>
                        <tr>
                            <th style="width:200px;">Full Name</th>
                            <th style="width:220px;">Email</th>
                            <th style="width:140px;">Phone</th>
                            <th>Circumstances & Motivation</th>
                            <th style="width:110px;">Status</th>
                            <th style="width:140px;">Received</th>
                            <th style="width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inquiries as $inq)
                            <tr>
                                <td>
                                    <strong><a href="{{ route('admin.inquiries.show', $inq->id) }}" style="color:#2271b1; text-decoration:none;">{{ $inq->full_name }}</a></strong>
                                </td>
                                <td><a href="mailto:{{ $inq->email }}" style="color:#2271b1;">{{ $inq->email }}</a></td>
                                <td>{{ $inq->phone ?? '—' }}</td>
                                <td>
                                    <div style="color:#2c3338; font-size:13px; line-height:1.6; margin-bottom:8px;">
                                        <strong>Circumstances:</strong> {{ $inq->circumstances }}
                                    </div>
                                    @if($inq->motivation)
                                        <div style="color:#50575e; font-size:12px; line-height:1.5; border-top:1px dashed #e0e0e0; padding-top:6px; margin-top:6px;">
                                            <strong>Motivation:</strong> {{ $inq->motivation }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill status-{{ $inq->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $inq->status)) }}
                                    </span>
                                </td>
                                <td>{{ $inq->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div style="display:flex; gap:6px;">
                                        <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="button button-small">View</a>
                                        <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" onsubmit="return confirm('Permanently delete this inquiry record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button button-small button-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="padding:16px;">
                    {{ $inquiries->links() }}
                </div>
            @else
                <div style="padding:32px; text-align:center; color:#646970;">
                    No private inquiry records found in this view.
                </div>
            @endif
        </div>
    </div>
@endsection
