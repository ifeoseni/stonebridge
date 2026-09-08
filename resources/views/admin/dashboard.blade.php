@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('admin_content')
    <h1 class="wp-heading-inline">Dashboard</h1>
    <hr class="wp-header-end" style="margin-bottom:20px; border:none;">

    <!-- Welcome Panel -->
    <div style="background:#fff; border:1px solid #c3c4c7; padding:24px; margin-bottom:24px; box-shadow:0 1px 1px rgba(0,0,0,0.04);">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <h2 style="font-size:21px; font-weight:400; color:#1d2327; margin-bottom:8px;">
                    Welcome to Stonebridge Advisory Content Manager
                </h2>
                <p style="color:#646970; font-size:14px; max-width:700px; line-height:1.6;">
                    Every section of your luxury one-page advisory website is fully customizable from this dashboard. Modify headlines, biography narratives, clientele criteria, retainer offerings, or confidential inquiry settings with instant live updates.
                </p>
            </div>
            <a href="{{ route('admin.customize') }}" class="button button-primary button-hero" style="font-size:14px; padding:6px 18px; height:auto;">
                Customize Your Site
            </a>
        </div>

        <div style="margin-top:24px; padding-top:20px; border-top:1px solid #f0f0f1; display:flex; gap:32px; flex-wrap:wrap;">
            <div>
                <strong style="display:block; margin-bottom:6px; color:#1d2327;">Quick Actions:</strong>
                <ul style="list-style:none; line-height:2;">
                    <li><a href="{{ route('admin.customize', ['tab' => 'hero']) }}" style="color:#2271b1; text-decoration:none;">&rarr; Edit Hero Headline & Stone Bridge Image</a></li>
                    <li><a href="{{ route('admin.customize', ['tab' => 'founder']) }}" style="color:#2271b1; text-decoration:none;">&rarr; Update Carl Malmsten Bio & Portrait</a></li>
                    <li><a href="{{ route('admin.customize', ['tab' => 'approach']) }}" style="color:#2271b1; text-decoration:none;">&rarr; Edit 5 Approach Pillars</a></li>
                </ul>
            </div>
            <div>
                <strong style="display:block; margin-bottom:6px; color:#1d2327;">Content Management:</strong>
                <ul style="list-style:none; line-height:2;">
                    <li><a href="{{ route('admin.customize', ['tab' => 'clientele']) }}" style="color:#2271b1; text-decoration:none;">&rarr; Manage Who We Serve Criteria ({{ $criteriaCount }})</a></li>
                    <li><a href="{{ route('admin.customize', ['tab' => 'retainer']) }}" style="color:#2271b1; text-decoration:none;">&rarr; Manage Retainer Offerings ({{ $retainersCount }})</a></li>
                    <li><a href="{{ route('admin.pages.index') }}" style="color:#2271b1; text-decoration:none;">&rarr; Manage Sub-Pages ({{ $subPagesCount }})</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-bottom:24px;">
        <div class="postbox" style="margin:0;">
            <div class="inside" style="padding:20px;">
                <span style="font-size:11px; text-transform:uppercase; color:#646970; font-weight:600; letter-spacing:0.05em;">New Inquiries</span>
                <div style="font-size:32px; font-weight:600; color:#d63638; margin:8px 0;">{{ $newInquiries }}</div>
                <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" style="color:#2271b1; font-size:12px; text-decoration:none;">View unread leads &rarr;</a>
            </div>
        </div>

        <div class="postbox" style="margin:0;">
            <div class="inside" style="padding:20px;">
                <span style="font-size:11px; text-transform:uppercase; color:#646970; font-weight:600; letter-spacing:0.05em;">Total Leads Received</span>
                <div style="font-size:32px; font-weight:600; color:#1d2327; margin:8px 0;">{{ $totalInquiries }}</div>
                <a href="{{ route('admin.inquiries.index') }}" style="color:#2271b1; font-size:12px; text-decoration:none;">All confidential records &rarr;</a>
            </div>
        </div>

        <div class="postbox" style="margin:0;">
            <div class="inside" style="padding:20px;">
                <span style="font-size:11px; text-transform:uppercase; color:#646970; font-weight:600; letter-spacing:0.05em;">Approach Pillars</span>
                <div style="font-size:32px; font-weight:600; color:#1d2327; margin:8px 0;">{{ $pillarsCount }}</div>
                <a href="{{ route('admin.customize', ['tab' => 'approach']) }}" style="color:#2271b1; font-size:12px; text-decoration:none;">Customize pillars &rarr;</a>
            </div>
        </div>

        <div class="postbox" style="margin:0;">
            <div class="inside" style="padding:20px;">
                <span style="font-size:11px; text-transform:uppercase; color:#646970; font-weight:600; letter-spacing:0.05em;">Published Sub-Pages</span>
                <div style="font-size:32px; font-weight:600; color:#1d2327; margin:8px 0;">{{ $subPagesCount }}</div>
                <a href="{{ route('admin.pages.index') }}" style="color:#2271b1; font-size:12px; text-decoration:none;">Manage documents &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries Postbox -->
    <div class="postbox">
        <div class="postbox-header">
            <h2>Recent Confidential Inquiries</h2>
            <a href="{{ route('admin.inquiries.index') }}" class="button">View All Inquiries</a>
        </div>
        <div class="inside" style="padding:0;">
            @if($recentInquiries->count() > 0)
                <table class="wp-list-table">
                    <thead>
                        <tr>
                            <th style="width:180px;">Inquirer Name</th>
                            <th style="width:200px;">Contact</th>
                            <th>Circumstances & Inquirer Context</th>
                            <th style="width:100px;">Status</th>
                            <th style="width:120px;">Received</th>
                            <th style="width:90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentInquiries as $inq)
                            <tr>
                                <td><strong>{{ $inq->full_name }}</strong></td>
                                <td>
                                    <div><a href="mailto:{{ $inq->email }}" style="color:#2271b1;">{{ $inq->email }}</a></div>
                                    @if($inq->phone)
                                        <div style="font-size:12px; color:#646970; margin-top:2px;">{{ $inq->phone }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="color:#2c3338; font-size:13px; line-height:1.6;">
                                        {{ $inq->circumstances }}
                                    </div>
                                    @if($inq->motivation)
                                        <div style="color:#646970; font-size:12px; margin-top:4px; font-style:italic;">
                                            Context: {{ $inq->motivation }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill status-{{ $inq->status }}">{{ ucfirst(str_replace('_', ' ', $inq->status)) }}</span>
                                </td>
                                <td>{{ $inq->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="button button-small">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding:24px; text-align:center; color:#646970;">
                    No private inquiries have been submitted yet.
                </div>
            @endif
        </div>
    </div>
@endsection
