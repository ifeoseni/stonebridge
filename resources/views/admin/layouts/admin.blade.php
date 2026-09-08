<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') &lsaquo; Stonebridge Advisory &mdash; WordPress</title>

    <!-- WordPress Admin Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dashicons/0.9.0/dashicons.min.css" integrity="sha512-4G1K2nL2WvC7D1QWnK8/t3D8+vY1p6yVb6M8w0j2V6z8+g9m4G8vY6nB0k1M6nB0=" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --wp-admin-bar: #1d2327;
            --wp-menu-bg: #1d2327;
            --wp-menu-active: #2271b1;
            --wp-menu-hover: #2c3338;
            --wp-content-bg: #f0f0f1;
            --wp-text: #2c3338;
            --wp-link: #2271b1;
            --wp-border: #c3c4c7;
            --wp-primary: #2271b1;
            --wp-primary-hover: #135e96;
            --stonebridge-gold: #c5a880;
            --stonebridge-gold-dark: #9a7d55;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--wp-content-bg);
            color: var(--wp-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-size: 13px;
            line-height: 1.4em;
        }

        /* Top Admin Bar */
        #wpadminbar {
            height: 32px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            min-width: 600px;
            z-index: 99999;
            background: var(--wp-admin-bar);
            color: #c3c4c7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px 0 10px;
            font-size: 13px;
        }
        .wpadminbar-left, .wpadminbar-right {
            display: flex;
            align-items: center;
            height: 100%;
        }
        .wp-bar-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #c3c4c7;
            text-decoration: none;
            padding: 0 10px;
            height: 32px;
            line-height: 32px;
            transition: background 0.15s;
        }
        .wp-bar-item:hover {
            background: var(--wp-menu-hover);
            color: #72aee6;
        }
        .wp-bar-badge {
            background: #d63638;
            color: #fff;
            border-radius: 10px;
            padding: 1px 7px;
            font-size: 10px;
            font-weight: 600;
        }

        /* Sidebar Menu */
        #adminmenumain {
            position: fixed;
            top: 32px;
            left: 0;
            bottom: 0;
            width: 170px;
            background: var(--wp-menu-bg);
            z-index: 9999;
            overflow-y: auto;
            border-right: 1px solid rgba(0,0,0,0.1);
        }
        .admin-menu-list {
            list-style: none;
            padding-top: 8px;
        }
        .admin-menu-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: #f0f0f1;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.15s;
        }
        .admin-menu-item a:hover {
            background: var(--wp-menu-hover);
            color: #72aee6;
        }
        .admin-menu-item.active a {
            background: var(--wp-menu-active);
            color: #fff;
            font-weight: 600;
        }
        .admin-menu-item svg {
            width: 18px;
            height: 18px;
            opacity: 0.8;
            flex-shrink: 0;
        }
        .admin-menu-item.active svg {
            opacity: 1;
        }

        /* Main Content Container */
        #wpcontent {
            margin-left: 170px;
            padding-top: 32px;
            min-height: 100vh;
        }
        .wrap {
            max-width: 1200px;
            margin: 20px 20px 40px 20px;
        }
        .wp-heading-inline {
            font-size: 23px;
            font-weight: 400;
            margin: 0 8px 16px 0;
            display: inline-block;
            line-height: 1.3;
        }

        /* WordPress Notices */
        .notice {
            background: #fff;
            border-left: 4px solid #fff;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.05);
            margin: 15px 0;
            padding: 12px 14px;
            font-size: 13px;
        }
        .notice-success {
            border-left-color: #00a32a;
        }
        .notice-warning {
            border-left-color: #dba617;
        }
        .notice-error {
            border-left-color: #d63638;
        }

        /* WordPress Postboxes (Cards) */
        .postbox {
            background: #fff;
            border: 1px solid var(--wp-border);
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            margin-bottom: 20px;
        }
        .postbox-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--wp-border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .postbox-header h2 {
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
            margin: 0;
        }
        .postbox .inside {
            padding: 18px 20px;
        }

        /* WordPress Buttons */
        .button {
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 12px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            background: #f6f7f7;
            border-color: #dcdcde;
            color: #2c3338;
            vertical-align: middle;
            transition: all 0.15s;
        }
        .button:hover {
            background: #f0f0f1;
            border-color: #0a4b78;
            color: #0a4b78;
        }
        .button-primary {
            background: var(--wp-primary);
            border-color: var(--wp-primary);
            color: #fff;
        }
        .button-primary:hover {
            background: var(--wp-primary-hover);
            border-color: var(--wp-primary-hover);
            color: #fff;
        }
        .button-gold {
            background: linear-gradient(135deg, #c7aa83 0%, #b39164 100%);
            border-color: #9a7d55;
            color: #0d0f12;
            font-weight: 600;
        }
        .button-gold:hover {
            background: #d8bc95;
            color: #000;
        }
        .button-danger {
            background: #fcf0f1;
            border-color: #d63638;
            color: #d63638;
        }
        .button-danger:hover {
            background: #d63638;
            color: #fff;
        }

        /* WordPress Forms & Inputs */
        .regular-text {
            width: 100%;
            max-width: 550px;
            padding: 8px 10px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .large-text {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            box-sizing: border-box;
        }
        textarea.large-text, textarea.regular-text, textarea {
            width: 100% !important;
            min-height: 75px;
            line-height: 1.6 !important;
            padding: 10px 12px !important;
            resize: vertical !important;
            box-sizing: border-box !important;
            font-family: inherit !important;
            font-size: 14px !important;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            display: block;
            white-space: pre-wrap;
            word-wrap: break-word;
            overflow-y: auto;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
            outline: 2px solid transparent;
        }
        .form-table {
            border-collapse: collapse;
            width: 100%;
        }
        .form-table tr {
            border-bottom: 1px solid #f0f0f1;
        }
        .form-table tr:last-child {
            border-bottom: none;
        }
        .form-table th {
            width: 220px;
            padding: 16px 10px 16px 0;
            text-align: left;
            vertical-align: top;
            font-weight: 600;
            font-size: 14px;
        }
        .form-table td {
            padding: 14px 10px;
            vertical-align: top;
        }
        .description {
            color: #646970;
            font-size: 12px;
            font-style: italic;
            margin-top: 6px;
            line-height: 1.4;
        }

        /* WordPress Nav Tabs */
        .nav-tab-wrapper {
            border-bottom: 1px solid #c3c4c7;
            margin-bottom: 20px;
            display: flex;
            gap: 4px;
        }
        .nav-tab {
            border: 1px solid #c3c4c7;
            border-bottom: none;
            background: #dcdcde;
            color: #50575e;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.3;
            text-decoration: none;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            transition: all 0.15s;
        }
        .nav-tab:hover {
            background: #fff;
            color: #1d2327;
        }
        .nav-tab-active {
            background: #fff;
            border-bottom: 1px solid #fff;
            color: #1d2327;
            margin-bottom: -1px;
        }

        /* WordPress Tables - Show full text without truncation */
        .wp-list-table {
            width: 100%;
            border: 1px solid var(--wp-border);
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            table-layout: auto;
        }
        .wp-list-table th, .wp-list-table td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            line-height: 1.6;
        }
        .wp-list-table th {
            font-weight: 600;
            background: #fafafa;
            color: #2c3338;
        }
        .wp-list-table tr:hover {
            background: #f9f9f9;
        }

        /* Badge Pills */
        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-new { background: #e7f5ea; color: #1b5e20; border: 1px solid #a5d6a7; }
        .status-contacted { background: #e3f2fd; color: #0d47a1; border: 1px solid #90caf9; }
        .status-in_review { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; }
        .status-archived { background: #f5f5f5; color: #616161; border: 1px solid #e0e0e0; }
    </style>
    @yield('admin_styles')
</head>
<body>

    <!-- WordPress Top Admin Bar -->
    <div id="wpadminbar">
        <div class="wpadminbar-left">
            <!-- WordPress Logo Icon -->
            <a href="{{ route('admin.dashboard') }}" class="wp-bar-item" title="Stonebridge Admin">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 1.25a8.75 8.75 0 1 1 0 17.5 8.75 8.75 0 0 1 0-17.5zm-5.46 8.97l2.84 8.27a8.71 8.71 0 0 1-4.14-4.87l1.3-3.4zm10.92 0l1.3 3.4a8.71 8.71 0 0 1-4.14 4.87l2.84-8.27zm-7.66.7l2.2 6.4 2.2-6.4-1.3-3.9h-1.8l-1.3 3.9z"/>
                </svg>
            </a>

            <!-- Site Name & Visit Site -->
            <a href="{{ route('admin.dashboard') }}" class="wp-bar-item">
                <strong>{{ $brandName ?? 'Stonebridge Advisory' }}</strong>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="wp-bar-item" title="View Frontend Website">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Visit Site</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="wp-bar-item" style="color:var(--stonebridge-gold); font-weight:600;" title="Live Preview">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span>Live Preview</span>
            </a>

            <!-- Customize Shortcut -->
            <a href="{{ route('admin.customize') }}" class="wp-bar-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <span>Customize</span>
            </a>

            <!-- Inquiries Counter -->
            @php
                $unreadInquiries = \App\Models\PrivateInquiry::where('status', 'new')->count();
            @endphp
            <a href="{{ route('admin.inquiries.index') }}" class="wp-bar-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <span>Inquiries</span>
                @if($unreadInquiries > 0)
                    <span class="wp-bar-badge">{{ $unreadInquiries }}</span>
                @endif
            </a>
        </div>

        <div class="wpadminbar-right">
            <a href="{{ route('admin.profile') }}" class="wp-bar-item" title="Edit Profile & Change Password">
                Howdy, <strong>{{ Auth::user()->name ?? 'Carl Malmsten' }}</strong>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="wp-bar-item" style="background:none; border:none; cursor:pointer;">
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- WordPress Left Sidebar Menu -->
    <div id="adminmenumain">
        <ul class="admin-menu-list">
            <!-- Dashboard -->
            <li class="admin-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Customize Website (Edit Every Section) -->
            <li class="admin-menu-item {{ request()->routeIs('admin.customize*') ? 'active' : '' }}">
                <a href="{{ route('admin.customize') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    <span>Customize Page</span>
                </a>
            </li>

            <!-- Private Inquiries Lead Inbox -->
            <li class="admin-menu-item {{ request()->routeIs('admin.inquiries*') ? 'active' : '' }}">
                <a href="{{ route('admin.inquiries.index') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>Inquiries</span>
                    @if($unreadInquiries > 0)
                        <span class="wp-bar-badge" style="margin-left:auto;">{{ $unreadInquiries }}</span>
                    @endif
                </a>
            </li>

            <!-- Pages -->
            <li class="admin-menu-item {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                <a href="{{ route('admin.pages.index') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Pages</span>
                </a>
            </li>

            <!-- Profile & Change Password -->
            <li class="admin-menu-item {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile & Password</span>
                </a>
            </li>

            <!-- Site Settings -->
            <li class="admin-menu-item {{ request()->fullUrlIs('*tab=footer*') ? 'active' : '' }}">
                <a href="{{ route('admin.customize', ['tab' => 'footer']) }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div id="wpcontent">
        <div class="wrap">
            @if(session('success'))
                <div class="notice notice-success">
                    <p><strong>{{ session('success') }}</strong></p>
                </div>
            @endif

            @if(session('error'))
                <div class="notice notice-error">
                    <p><strong>{{ session('error') }}</strong></p>
                </div>
            @endif

            @yield('admin_content')
        </div>
    </div>

    <!-- Global Dynamic Expandable Textareas Script -->
    <script>
        function autoResizeTextareas() {
            document.querySelectorAll('textarea').forEach(function(el) {
                el.style.boxSizing = 'border-box';
                // Reset height to calculate true scrollHeight without previous expansion
                el.style.height = 'auto';
                const paddingAndBorders = 12;
                const minHeight = 80;
                const newHeight = Math.max(el.scrollHeight + paddingAndBorders, minHeight);
                el.style.height = newHeight + 'px';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            autoResizeTextareas();

            // Expand as user types
            document.addEventListener('input', function(e) {
                if (e.target && e.target.tagName && e.target.tagName.toLowerCase() === 'textarea') {
                    e.target.style.height = 'auto';
                    e.target.style.height = (e.target.scrollHeight + 12) + 'px';
                }
            });

            // Re-adjust on window resize
            window.addEventListener('resize', autoResizeTextareas);
        });

        // Run again when all fonts, styles, and images finish loading
        window.addEventListener('load', function() {
            setTimeout(autoResizeTextareas, 50);
            setTimeout(autoResizeTextareas, 300);
        });
    </script>
    @yield('scripts')

</body>
</html>
