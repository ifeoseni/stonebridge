<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ============ Analytics: Google tag + Microsoft Clarity (production only) ============ --}}
    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-JJN5BF1NZV"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-JJN5BF1NZV');
        </script>
        <!-- Microsoft Clarity -->
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "ywaa82xecp");
        </script>
    @endproduction

    {{-- ============ Primary SEO (per-page overrides via seo_* sections) ============ --}}
    <title>@yield('seo_title', ($settings['brand_name'] ?? 'STONEBRIDGE ADVISORY') . ' — Confidential Advisory')</title>
    <meta name="description" content="@yield('seo_description', $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.')">
    <meta name="robots" content="@yield('seo_robots', 'index, follow')">
    <link rel="canonical" href="@yield('seo_canonical', url()->current())">

    {{-- ============ Open Graph ============ --}}
    <meta property="og:site_name" content="{{ $settings['brand_name'] ?? 'Stonebridge Advisory' }}">
    <meta property="og:type" content="@yield('seo_type', 'website')">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta property="og:title" content="@yield('seo_title', ($settings['brand_name'] ?? 'STONEBRIDGE ADVISORY') . ' — Confidential Advisory')">
    <meta property="og:description" content="@yield('seo_description', $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.')">
    <meta property="og:url" content="@yield('seo_canonical', url()->current())">
    <meta property="og:image" content="@yield('seo_image', url('/storage/uploads/bglgAapIf4r8BkW4LrFdMXuIOrdZ1EPssi2yvU8x.jpg'))">
    <meta property="og:image:secure_url" content="@yield('seo_image', url('/storage/uploads/bglgAapIf4r8BkW4LrFdMXuIOrdZ1EPssi2yvU8x.jpg'))">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:alt" content="@yield('seo_image_alt', 'Stonebridge Advisory — Confidential Advisory')">

    {{-- ============ Twitter Card ============ --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('seo_title', ($settings['brand_name'] ?? 'STONEBRIDGE ADVISORY') . ' — Confidential Advisory')">
    <meta name="twitter:description" content="@yield('seo_description', $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.')">
    <meta name="twitter:image" content="@yield('seo_image', url('/storage/uploads/bglgAapIf4r8BkW4LrFdMXuIOrdZ1EPssi2yvU8x.jpg'))">
    <meta name="twitter:image:alt" content="@yield('seo_image_alt', 'Stonebridge Advisory — Confidential Advisory')">

    <meta name="theme-color" content="#090c0f">

    {{-- ============ Icons ============ --}}
    <link rel="icon" href="{{ url('/favicon.ico') }}" sizes="any">

    <!-- Google Fonts: Cormorant Garamond & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- ============ Structured Data: Organization + WebSite ============ --}}
    {{-- NOTE: '@' . 'context' is concatenated so Blade never parses it as a directive. --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@' . 'context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => url('/') . '#organization',
                'name' => $settings['brand_name'] ?? 'Stonebridge Advisory',
                'url' => url('/'),
                'description' => $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.',
                'logo' => url('/favicon.ico'),
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'url' => url('/'),
                'name' => $settings['brand_name'] ?? 'Stonebridge Advisory',
                'publisher' => ['@id' => url('/') . '#organization'],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @yield('json_ld')

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

        /* Accessibility: skip link (visible on keyboard focus) */
        .skip-link {
            position: absolute;
            left: -9999px;
            top: 0;
            z-index: 100000;
            background: #bfa176;
            color: #171513;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 0 0 4px 0;
            text-decoration: none;
        }
        .skip-link:focus { left: 0; }

        /* Global toast (error / success redirects, e.g. unknown URLs) */
        .sb-toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            z-index: 100000;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            max-width: min(560px, calc(100vw - 40px));
            background: #14191f;
            color: #f5f3ef;
            border: 1px solid rgba(191, 161, 118, 0.45);
            border-left: 4px solid #bfa176;
            border-radius: 6px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.55);
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.55;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .sb-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); pointer-events: auto; }
        .sb-toast-error { border-left-color: #e5484d; }
        .sb-toast-success { border-left-color: #46a758; }
        .sb-toast-close {
            background: none;
            border: none;
            color: #a0a6ac;
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            padding: 0 0 0 4px;
        }
        .sb-toast-close:hover { color: #f5f3ef; }

    </style>
    @yield('styles')
</head>
<body>

    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Main Content -->
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Global toast: renders redirected error/success messages (e.g. unknown URL -> home) --}}
    @if(session('error') || session('success') || session('status'))
        <div id="sb-toast" class="sb-toast {{ session('error') ? 'sb-toast-error' : 'sb-toast-success' }}" role="alert" aria-live="polite">
            <span>{{ session('error') ?? session('success') ?? session('status') }}</span>
            <button type="button" class="sb-toast-close" aria-label="Dismiss notification" onclick="document.getElementById('sb-toast').classList.remove('show')">&times;</button>
        </div>
        <script>
            (function () {
                var toast = document.getElementById('sb-toast');
                if (!toast) return;
                requestAnimationFrame(function () { toast.classList.add('show'); });
                setTimeout(function () { toast.classList.remove('show'); }, 7000);
            })();
        </script>
    @endif

    @yield('scripts')
</body>
</html>
