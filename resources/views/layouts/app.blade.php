<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['brand_name'] ?? 'STONEBRIDGE ADVISORY' }} &mdash; Confidential Advisory</title>
    <meta name="description" content="{{ $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.' }}">

    <!-- Google Fonts: Cormorant Garamond & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <meta name="theme-color" id="metaThemeColor" content="#090c0f">

    <!-- Immediate Theme Initialization Script (prevents flash & synchronizes with device theme) -->
    <script>
        (function() {
            const hasMedia = window.matchMedia;
            const devicePrefersDark = hasMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const currentDeviceTheme = devicePrefersDark ? 'dark' : 'light';
            const lastDeviceTheme = localStorage.getItem('stonebridge_last_device_theme');
            let savedTheme = localStorage.getItem('stonebridge_theme');

            // If the user changed their device/phone OS theme setting, automatically sync to match the device
            if (lastDeviceTheme && lastDeviceTheme !== currentDeviceTheme) {
                savedTheme = currentDeviceTheme;
                localStorage.setItem('stonebridge_theme', currentDeviceTheme);
            } else if (!savedTheme) {
                if (hasMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
                    savedTheme = 'light';
                } else if (hasMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    savedTheme = 'dark';
                } else {
                    savedTheme = '{{ $settings["default_theme"] ?? "dark" }}';
                }
            }
            localStorage.setItem('stonebridge_last_device_theme', currentDeviceTheme);
            document.documentElement.setAttribute('data-theme', savedTheme);
            const metaTheme = document.getElementById('metaThemeColor');
            if (metaTheme) {
                metaTheme.setAttribute('content', savedTheme === 'light' ? '#fbf8f3' : '#090c0f');
            }
        })();
    </script>

    <style>
        :root {
            --bg-dark: #090c0f;
            --bg-dark-section: #0c0f13;
            --bg-approach: #0d1014;
            --bg-cream: #f4ede4;
            --bg-cream-card: #f4ede4;
            
            --gold-accent: #bfa176;
            --gold-btn: #bfa176;
            --gold-btn-hover: #cfb388;
            --gold-text: #bfa176;
            --gold-subtle: rgba(191, 161, 118, 0.15);

            --text-white: #f5f3ef;
            --text-light-muted: #a0a6ac;
            --text-dark: #231f1a;
            --text-dark-muted: #575148;
            --text-cream-italic: #9c8360;

            --border-dark: rgba(255, 255, 255, 0.08);
            --border-input: rgba(255, 255, 255, 0.18);
            --border-subtle: rgba(255, 255, 255, 0.06);

            --input-bg: #0f1317;
            --input-bg-focus: #14191f;
            --input-text: #f5f3ef;
            --input-placeholder: #8b9299;
            --input-label: #a0a7af;

            --header-logo-color: #ece8df;
            --modal-card-bg: #111417;

            --section-py: 100px;
            --section-px: 64px;

            --font-serif: 'Cormorant Garamond', Georgia, "Times New Roman", serif;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        @media (max-width: 1100px) {
            :root {
                --section-py: 90px;
                --section-px: 36px;
            }
        }
        @media (max-width: 900px) {
            :root {
                --section-py: 80px;
                --section-px: 32px;
            }
        }
        @media (max-width: 600px) {
            :root {
                --section-py: 72px;
                --section-px: 22px;
            }
        }

        [data-theme="light"] {
            --bg-dark: #fbf8f3;
            --bg-dark-section: #f4eee5;
            --bg-approach: #f5efe6;
            --bg-cream: #ede4d6;
            --bg-cream-card: #ffffff;
            
            --gold-accent: #9b794b;
            --gold-btn: #9b794b;
            --gold-btn-hover: #86663c;
            --gold-text: #9b794b;
            --gold-subtle: rgba(155, 121, 75, 0.12);

            --text-white: #1a1714;
            --text-light-muted: #675f56;
            --text-dark: #1a1714;
            --text-dark-muted: #5c554b;
            --text-cream-italic: #84673f;

            --border-dark: rgba(30, 24, 18, 0.1);
            --border-input: rgba(30, 24, 18, 0.22);
            --border-subtle: rgba(30, 24, 18, 0.08);

            --input-bg: #ffffff;
            --input-bg-focus: #fcfbfa;
            --input-text: #1d1916;
            --input-placeholder: #7c7469;
            --input-label: #5a5247;

            --header-logo-color: #1a1613;
            --modal-card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            background-color: var(--bg-dark);
            color: var(--text-white);
            font-family: var(--font-sans);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            position: relative;
        }

        /* Seamless Theme Color Flow Transitions */
        html, body,
        .site-header,
        .header-logo,
        .header-btn,
        .theme-toggle-btn,
        .modal-card,
        .modal-overlay,
        .modal-close,
        .header-docs-btn,
        .header-docs-menu,
        .header-docs-menu a {
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Typography */
        .serif { font-family: var(--font-serif); }
        .sans { font-family: var(--font-sans); }

        /* Navigation Header */
        .site-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            z-index: 100;
            padding: 36px 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-logo {
            font-family: var(--font-serif);
            font-size: 16px;
            letter-spacing: 0.25em;
            color: var(--header-logo-color);
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500;
            display: flex;
            flex-direction: column;
            line-height: 1.25;
            transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .header-logo span {
            font-size: 14px;
            letter-spacing: 0.3em;
        }
        [data-theme="light"] .header-logo {
            text-shadow:
                -1px -1px 0 #fff,
                1px -1px 0 #fff,
                -1px 1px 0 #fff,
                1px 1px 0 #fff,
                0 0 2px rgba(255, 255, 255, 0.9);
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header-btn {
            display: inline-block;
            background: transparent !important;
            color: var(--gold-accent) !important;
            font-family: var(--font-sans);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 10px 22px;
            text-decoration: none;
            border: 1px solid var(--gold-accent) !important;
            transition: all 0.25s ease;
        }
        .header-btn:hover {
            border-color: #dfc8a5 !important;
            color: #dfc8a5 !important;
            background: var(--gold-subtle) !important;
        }
        [data-theme="light"] .header-btn {
            color: #1a1613 !important;
            border-color: #1a1613 !important;
        }
        [data-theme="light"] .header-btn:hover {
            color: #ffffff !important;
            border-color: #1a1613 !important;
            background: #1a1613 !important;
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-dark);
            color: var(--text-light-muted);
            font-family: var(--font-sans);
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 500;
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            cursor: pointer;
            border-radius: 2px;
            transition: all 0.25s ease;
            flex-shrink: 0;
            box-sizing: border-box;
        }
        [data-theme="light"] .theme-toggle-btn {
            background: rgba(0, 0, 0, 0.04);
            color: #1a1613;
            border-color: rgba(26, 22, 19, 0.25);
        }
        .theme-toggle-btn:hover {
            color: var(--gold-accent);
            border-color: var(--gold-accent);
            background: var(--gold-subtle);
        }

        /* Sub-page Modal Drawer */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-card {
            background: #111417;
            border: 1px solid var(--gold-accent);
            max-width: 780px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            padding: 48px;
            position: relative;
            box-shadow: 0 25px 60px rgba(0,0,0,0.9);
        }
        .modal-close {
            position: absolute;
            top: 24px;
            right: 24px;
            background: none;
            border: none;
            color: var(--text-light-muted);
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
        }
        .modal-close:hover {
            color: var(--gold-accent);
        }

        /* Modal Markdown Content Typography */
        #modalContent p {
            margin-bottom: 18px;
            font-size: 15px;
            line-height: 1.85;
            color: #c5c8cc;
        }
        #modalContent h3 {
            font-family: var(--font-serif);
            font-size: 23px;
            font-weight: 400;
            color: #f7f4ed;
            margin-top: 28px;
            margin-bottom: 12px;
            letter-spacing: 0.02em;
        }
        #modalContent ul {
            list-style: none;
            margin: 16px 0 24px 0;
            padding-left: 0;
        }
        #modalContent ul li {
            position: relative;
            padding-left: 18px;
            margin-bottom: 10px;
            font-size: 14.5px;
            line-height: 1.65;
            color: #b5b9bf;
        }
        #modalContent ul li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--gold-accent);
            font-size: 13px;
        }
        #modalContent strong {
            color: #f5f3ef;
            font-weight: 600;
        }

        /* Discreet Header Document Navigation */
        .header-docs-dropdown {
            position: relative;
            display: inline-block;
        }
        .header-docs-btn {
            background: transparent;
            border: none;
            color: #9aa0a6;
            font-family: var(--font-sans);
            font-size: 10px;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            font-weight: 500;
            cursor: pointer;
            padding: 8px 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        [data-theme="light"] .header-docs-btn {
            color: #1a1613;
            text-shadow:
                -1px -1px 0 #fff,
                1px -1px 0 #fff,
                -1px 1px 0 #fff,
                1px 1px 0 #fff,
                0 0 2px rgba(255, 255, 255, 0.9);
        }
        .header-docs-btn:hover {
            color: var(--gold-accent);
        }
        .header-docs-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #111417;
            border: 1px solid rgba(191, 161, 118, 0.35);
            box-shadow: 0 12px 32px rgba(0,0,0,0.85);
            min-width: 280px;
            padding: 8px 0;
            display: none;
            z-index: 1000;
        }
        .header-docs-menu.active {
            display: block;
        }
        .header-docs-menu a {
            display: block;
            padding: 10px 18px;
            color: #c5c8cc;
            font-size: 12px;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: all 0.2s;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .header-docs-menu a:last-child {
            border-bottom: none;
        }
        .header-docs-menu a:hover {
            background: rgba(191, 161, 118, 0.1);
            color: var(--gold-accent);
            padding-left: 22px;
        }

        @media (max-width: 768px) {
            .site-header {
                padding: 16px 18px;
                gap: 8px;
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
                overflow: hidden;
            }
            .header-logo {
                font-size: 13px;
                letter-spacing: 0.16em;
                flex-shrink: 1;
                min-width: 0;
            }
            .header-logo span:last-child {
                font-size: 11px;
                letter-spacing: 0.2em;
            }
            .header-right {
                gap: 8px;
                flex-shrink: 0;
            }
            .theme-toggle-btn {
                padding: 0 !important;
                width: 34px !important;
                height: 34px !important;
                min-width: 34px !important;
                justify-content: center !important;
                border-radius: 3px;
                flex-shrink: 0;
            }
            .theme-toggle-btn .theme-toggle-label {
                display: none !important; /* Hide 'LIGHT'/'DARK' text on all mobile/tablet screens so button is a compact square icon, completely eliminating horizontal overflow */
            }
            .header-btn {
                padding: 8px 14px;
                font-size: 9.5px;
                letter-spacing: 0.12em;
                white-space: nowrap;
            }
            .modal-card { padding: 28px 20px; }
            .header-docs-dropdown { display: none; }
        }

        @media (max-width: 420px) {
            .site-header {
                padding: 14px 14px;
                gap: 6px;
            }
            .header-logo {
                font-size: 12px;
                letter-spacing: 0.12em;
            }
            .header-logo span:last-child {
                font-size: 10px;
                letter-spacing: 0.15em;
            }
            .header-right {
                gap: 6px;
            }
            .theme-toggle-btn {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
            }
            .header-btn {
                padding: 7px 11px;
                font-size: 9px;
                letter-spacing: 0.08em;
            }
        }

        @media (max-width: 340px) {
            .site-header {
                padding: 12px 10px;
                gap: 4px;
            }
            .header-logo {
                font-size: 11px;
                letter-spacing: 0.08em;
            }
            .header-btn {
                padding: 6px 8px;
                font-size: 8px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Minimalist Header (matching screenshot) -->
    <header class="site-header">
        <a href="{{ route('home') }}" class="header-logo">
            <span>STONEBRIDGE</span>
            <span>ADVISORY</span>
        </a>

        <div class="header-right">
            <!-- Theme Mode Switcher -->
            <button type="button" class="theme-toggle-btn" onclick="toggleTheme()" aria-label="Toggle Dark/Light Mode" id="themeToggleBtn">
                <svg class="theme-icon-moon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <svg class="theme-icon-sun" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                <span class="theme-toggle-label" id="themeToggleText">LIGHT</span>
            </button>

            @if(isset($subPages) && count($subPages) > 0)
                <div class="header-docs-dropdown">
                    <button type="button" class="header-docs-btn" onclick="toggleDocsMenu(event)">
                        <span>{{ $settings['header_docs_label'] ?? 'DOCUMENTS' }}</span>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="header-docs-menu" id="headerDocsMenu">
                        @foreach($subPages as $sp)
                            <a href="javascript:void(0)" onclick="openSubPage('{{ $sp->slug }}'); closeDocsMenu();">
                                {{ $sp->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <a href="{{ $settings['header_cta_link'] ?? '#private-inquiry' }}" class="header-btn">
                {{ $settings['header_cta_text'] ?? 'PRIVATE INQUIRY' }}
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Subpage Modal Viewer -->
    <div class="modal-overlay" id="subpageModal">
        <div class="modal-card">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <div style="font-size:11px; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold-accent); font-weight:600; margin-bottom:12px;">
                {{ $settings['modal_eyebrow'] ?? 'CONFIDENTIAL CHARTER' }}
            </div>
            <h2 class="serif" id="modalTitle" style="font-size:36px; font-weight:400; color:var(--text-white); margin-bottom:8px; line-height:1.2;"></h2>
            <p id="modalSubtitle" style="color:var(--gold-text); font-size:15px; margin-bottom:24px; font-style:italic; border-bottom:1px solid var(--border-dark); padding-bottom:16px;"></p>
            <div id="modalContent" style="font-size:15px; line-height:1.85;"></div>
            <div style="margin-top:36px; padding-top:20px; border-top:1px solid var(--border-dark); display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:11px; letter-spacing:0.2em; text-transform:uppercase; color:var(--text-light-muted);">{{ $settings['brand_name'] ?? 'STONEBRIDGE ADVISORY' }}</span>
                <button onclick="closeModal()" class="header-btn">{{ $settings['modal_close_label'] ?? 'Close Document' }}</button>
            </div>
        </div>
    </div>

    <script>
        function updateMetaThemeColor(theme) {
            const metaTheme = document.getElementById('metaThemeColor') || document.querySelector('meta[name="theme-color"]');
            if (metaTheme) {
                metaTheme.setAttribute('content', theme === 'light' ? '#fbf8f3' : '#090c0f');
            }
        }

        function applyTheme(newTheme, isManual = true) {
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('stonebridge_theme', newTheme);
            updateThemeUI(newTheme);
            updateMetaThemeColor(newTheme);
            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: newTheme, isManual: isManual } }));
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme, true);
        }

        function updateThemeUI(theme) {
            const moon = document.querySelector('.theme-icon-moon');
            const sun = document.querySelector('.theme-icon-sun');
            const label = document.getElementById('themeToggleText');
            const btn = document.getElementById('themeToggleBtn');
            if (theme === 'light') {
                if (moon) moon.style.display = 'none';
                if (sun) sun.style.display = 'block';
                if (label) label.innerText = 'DARK';
                if (btn) btn.setAttribute('title', 'Switch to Dark Theme');
            } else {
                if (moon) moon.style.display = 'block';
                if (sun) sun.style.display = 'none';
                if (label) label.innerText = 'LIGHT';
                if (btn) btn.setAttribute('title', 'Switch to Light Theme');
            }
        }

        // Active Device OS Theme Synchronization
        // When the user changes their mobile phone / device theme in phone settings,
        // the website immediately flows into that theme in real-time!
        if (window.matchMedia) {
            const darkMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            const handleDeviceThemeChange = function(e) {
                const newDeviceTheme = e.matches ? 'dark' : 'light';
                localStorage.setItem('stonebridge_last_device_theme', newDeviceTheme);
                applyTheme(newDeviceTheme, false);
            };
            if (darkMediaQuery.addEventListener) {
                darkMediaQuery.addEventListener('change', handleDeviceThemeChange);
            } else if (darkMediaQuery.addListener) {
                darkMediaQuery.addListener(handleDeviceThemeChange);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const theme = document.documentElement.getAttribute('data-theme') || 'dark';
            updateThemeUI(theme);
            updateMetaThemeColor(theme);
        });

        function openSubPage(slug) {
            fetch(`/api/page/${slug}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = data.title;
                    document.getElementById('modalSubtitle').innerText = data.subtitle || '';
                    document.getElementById('modalContent').innerHTML = data.content;
                    document.getElementById('subpageModal').classList.add('active');
                    document.body.style.overflow = 'hidden';
                })
                .catch(err => {
                    window.location.href = `/page/${slug}`;
                });
        }
        function closeModal() {
            document.getElementById('subpageModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        function toggleDocsMenu(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('headerDocsMenu');
            if (menu) menu.classList.toggle('active');
        }
        function closeDocsMenu() {
            const menu = document.getElementById('headerDocsMenu');
            if (menu) menu.classList.remove('active');
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.header-docs-dropdown')) {
                closeDocsMenu();
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
