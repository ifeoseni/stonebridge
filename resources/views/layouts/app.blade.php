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

    </style>
    @yield('styles')
</head>
<body>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
