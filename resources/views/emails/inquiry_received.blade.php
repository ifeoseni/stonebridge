<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Private Inquiry - Stonebridge Advisory</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #050b14;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #e2e8f0;
            line-height: 1.6;
        }
        .container {
            max-width: 620px;
            margin: 40px auto;
            background-color: #0b1523;
            border: 1px solid #1e293b;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }
        .header {
            background-color: #070d17;
            padding: 32px 40px;
            border-bottom: 1px solid #1e2d42;
            text-align: center;
        }
        .header-tag {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c5a880;
            font-weight: 600;
            margin-bottom: 8px;
            display: inline-block;
        }
        .header-title {
            color: #ffffff;
            font-size: 22px;
            margin: 0;
            font-weight: 400;
            letter-spacing: 1px;
        }
        .body-content {
            padding: 36px 40px;
        }
        .confidential-badge {
            background-color: rgba(197, 168, 128, 0.12);
            border: 1px solid rgba(197, 168, 128, 0.3);
            color: #c5a880;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 24px;
        }
        .field-group {
            margin-bottom: 24px;
            border-bottom: 1px solid #162234;
            padding-bottom: 20px;
        }
        .field-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .field-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #8fa0b5;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .field-value {
            font-size: 15px;
            color: #f1f5f9;
            margin: 0;
            word-break: break-word;
        }
        .field-value a {
            color: #c5a880;
            text-decoration: none;
        }
        .field-value a:hover {
            text-decoration: underline;
        }
        .content-box {
            background-color: #08101b;
            border: 1px solid #1a273b;
            border-radius: 6px;
            padding: 16px 20px;
            font-size: 14px;
            color: #cbd5e1;
            white-space: pre-wrap;
            line-height: 1.7;
        }
        .btn-wrapper {
            margin-top: 32px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background-color: #c5a880;
            color: #070d17 !important;
            text-decoration: none;
            padding: 12px 28px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 4px;
        }
        .footer {
            background-color: #070d17;
            padding: 24px 40px;
            border-top: 1px solid #162234;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
        .footer p {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-tag">Stonebridge Advisory</div>
            <h1 class="header-title">Private Inquiry Notification</h1>
        </div>
        
        <div class="body-content">
            <div class="confidential-badge">
                Strictly Confidential
            </div>

            <p style="color: #94a3b8; font-size: 14px; margin-top: 0; margin-bottom: 24px;">
                A new prospective client inquiry has been submitted via the Stonebridge Advisory private inquiry portal.
            </p>

            <div class="field-group">
                <div class="field-label">Prospective Client</div>
                <div class="field-value"><strong>{{ $inquiry->full_name }}</strong></div>
            </div>

            <div class="field-group">
                <div class="field-label">Email Address</div>
                <div class="field-value">
                    <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>
                </div>
            </div>

            @if(!empty($inquiry->phone))
            <div class="field-group">
                <div class="field-label">Direct Phone</div>
                <div class="field-value">
                    <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
                </div>
            </div>
            @endif

            <div class="field-group">
                <div class="field-label">Circumstances Overview</div>
                <div class="field-value content-box">{{ $inquiry->circumstances }}</div>
            </div>

            @if(!empty($inquiry->motivation))
            <div class="field-group">
                <div class="field-label">Exploration Motivation</div>
                <div class="field-value content-box">{{ $inquiry->motivation }}</div>
            </div>
            @endif

            <div class="field-group">
                <div class="field-label">Timestamp (UTC)</div>
                <div class="field-value">{{ $inquiry->created_at ? $inquiry->created_at->toDayDateTimeString() : now()->toDayDateTimeString() }}</div>
            </div>

            <div class="btn-wrapper">
                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn">
                    View in Admin Portal
                </a>
            </div>
        </div>

        <div class="footer">
            <p>This message was automatically generated for Stonebridge Advisory leadership.</p>
            <p>&copy; {{ date('Y') }} Stonebridge Advisory. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
