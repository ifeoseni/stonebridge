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

    <meta name="theme-color" content="#090c0f">

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
