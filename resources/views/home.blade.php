@extends('layouts.app')

@section('styles')
<style>
    /* ==========================================================================
       THEME DYNAMIC VARIABLES & BACKGROUNDS
       ========================================================================== */
    :root {
        --hero-bg-image: url('{{ $settings["hero_image"] ?? "/images/hero-bridge-dark.jpg" }}');
    }
    [data-theme="light"] {
        --hero-bg-image: url('{{ $settings["hero_image_light"] ?? "/images/hero-bridge-light.jpg" }}');
    }

    /* Standardized Section Padding Across All Blocks */
    .section-standard-padding {
        padding-top: var(--section-py);
        padding-bottom: var(--section-py);
        padding-left: var(--section-px);
        padding-right: var(--section-px);
    }

    /* ==========================================================================
       SECTION 1: HERO (Atmospheric Stone Bridge & Minimalist Center Stage)
       ========================================================================== */
    .hero-wrap {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: var(--hero-bg-image);
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        padding: 160px var(--section-px) var(--section-py) var(--section-px);
        transition: background-image 0.5s ease-in-out;
    }
    .hero-vignette {
        position: absolute;
        inset: 0;
        /* Atmospheric twilight blue sky & soft charcoal vignette as requested */
        background: radial-gradient(
            ellipse at 50% 28%,
            rgba(26, 40, 62, 0.42) 0%,
            rgba(11, 16, 22, 0.76) 55%,
            rgba(8, 11, 15, 0.96) 100%
        );
        z-index: 1;
        transition: background 0.4s ease;
    }
    [data-theme="light"] .hero-vignette {
        background: radial-gradient(
            ellipse at 50% 28%,
            rgba(235, 242, 248, 0.3) 0%,
            rgba(251, 248, 243, 0.68) 55%,
            rgba(251, 248, 243, 0.96) 100%
        );
    }
    .hero-bottom-grad {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 160px;
        background: linear-gradient(to bottom, transparent, var(--bg-dark));
        z-index: 2;
        pointer-events: none;
    }
    .hero-inner {
        position: relative;
        z-index: 10;
        max-width: 680px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .hero-title {
        font-family: var(--font-serif);
        font-size: clamp(40px, 6.2vw, 68px);
        font-weight: 300;
        letter-spacing: 0.12em;
        line-height: 1.15;
        color: #f7f4ed;
        text-transform: uppercase;
        margin-bottom: 36px;
        text-shadow: 0 4px 28px rgba(0, 0, 0, 0.75);
    }
    [data-theme="light"] .hero-title {
        color: #211c17;
        text-shadow: 0 2px 24px rgba(255, 255, 255, 0.85);
    }
    .btn-hero-inquiry {
        display: inline-block;
        background: rgba(14, 18, 22, 0.45);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: var(--gold-accent) !important;
        font-family: var(--font-sans);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        padding: 14px 36px;
        text-decoration: none;
        border: 1px solid var(--gold-accent) !important;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }
    [data-theme="light"] .btn-hero-inquiry {
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    .btn-hero-inquiry:hover {
        background: var(--gold-btn) !important;
        color: #171513 !important;
        border-color: var(--gold-btn) !important;
        box-shadow: 0 6px 26px rgba(191, 161, 118, 0.4);
        transform: translateY(-1px);
    }

    /* Refined Architectural Accent Lines */
    .section-accent-line {
        width: 46px;
        height: 1.5px;
        display: block;
        margin: 12px 0 20px 0;
        border: none;
    }
    .section-accent-line.gold {
        background-color: var(--gold-accent);
    }
    .section-accent-line.bronze {
        background-color: #9c8360;
    }

    /* ==========================================================================
       SECTION 1.5: THE STONEBRIDGE MANDATE (Subtext Architectural Placement)
       ========================================================================== */
    .mandate-wrap {
        background-color: var(--bg-dark);
        border-bottom: 1px solid var(--border-subtle);
        text-align: center;
        display: flex;
        justify-content: center;
        padding: var(--section-py) var(--section-px);
        transition: background-color 0.3s ease;
    }
    .mandate-inner {
        max-width: 680px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .mandate-badge {
        font-family: var(--font-sans);
        font-size: 10.5px;
        letter-spacing: 0.25em;
        color: var(--gold-accent);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 14px;
    }
    .mandate-lead {
        font-family: var(--font-serif);
        font-size: 24px;
        line-height: 1.5;
        color: var(--text-white);
        font-weight: 400;
        margin-bottom: 16px;
    }
    .mandate-secondary {
        font-family: var(--font-sans);
        font-size: 14.5px;
        line-height: 1.75;
        color: var(--text-light-muted);
        font-weight: 300;
        max-width: 540px;
    }

    /* ==========================================================================
       SECTION 2: THE STONEBRIDGE APPROACH (5 Pillars)
       ========================================================================== */
    .approach-wrap {
        background-color: var(--bg-approach);
        padding: var(--section-py) var(--section-px);
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .approach-flex {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 0;
        align-items: start;
    }
    .approach-header-col {
        padding-right: 36px;
        border-right: 1px solid var(--border-dark);
    }
    .tag-gold {
        font-family: var(--font-sans);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--gold-accent);
        display: block;
        margin-bottom: 0;
    }
    .approach-heading {
        font-family: var(--font-serif);
        font-size: 34px;
        font-weight: 300;
        line-height: 1.25;
        color: var(--text-white);
    }
    .pillars-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0;
        padding-left: 0;
    }
    .pillar-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 0 16px;
        border-right: 1px solid var(--border-dark);
        min-width: 0;
    }
    .pillar-item:last-child {
        border-right: none;
        padding-right: 0;
    }
    .pillar-icon-box {
        width: 36px;
        height: 36px;
        margin-bottom: 14px;
        color: var(--gold-accent);
    }
    .pillar-icon-box svg {
        width: 100%;
        height: 100%;
        stroke-width: 1.3;
    }
    .pillar-name {
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.01em;
        color: var(--text-white);
        margin-bottom: 8px;
        white-space: nowrap;
    }
    .pillar-body {
        font-family: var(--font-sans);
        font-size: 12px;
        line-height: 1.6;
        color: var(--text-light-muted);
        font-weight: 300;
    }

    /* ==========================================================================
       SECTION 3: WHO STONEBRIDGE SERVES (Warm Cream Background)
       ========================================================================== */
    .serves-wrap {
        background-color: var(--bg-cream);
        color: var(--text-dark);
        padding: var(--section-py) var(--section-px);
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .serves-flex {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 60px;
        align-items: start;
    }
    .tag-bronze {
        font-family: var(--font-sans);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #9c8360;
        display: block;
        margin-bottom: 16px;
    }
    .serves-heading {
        font-family: var(--font-serif);
        font-size: 36px;
        font-weight: 400;
        line-height: 1.22;
        color: #201c17;
    }
    .criteria-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 40px;
        row-gap: 22px;
        align-items: start;
    }
    .criteria-col-left, .criteria-col-right {
        display: flex;
        flex-direction: column;
        gap: 22px;
        margin: 0;
        padding: 0;
    }
    .criterion-row {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .circle-check {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1.2px solid #b89c72;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 3px;
        color: #b89c72;
    }
    .circle-check svg {
        width: 9px;
        height: 9px;
    }
    .criterion-label {
        font-family: var(--font-serif);
        font-size: 18px;
        line-height: 1.35;
        color: #24201b;
        font-weight: 400;
    }
    .serves-disclaimer-row {
        margin-top: 28px;
    }
    .serves-disclaimer-col-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        width: 100%;
    }
    .serves-small-divider {
        width: 26px;
        height: 1px;
        background-color: rgba(40, 35, 30, 0.28);
        margin: 0 0 12px 0;
        display: block;
    }
    .serves-footer-note {
        text-align: left;
        font-family: var(--font-serif);
        font-style: italic;
        font-size: 13px;
        line-height: 1.45;
        color: #8c8275;
        max-width: 320px;
        margin: 0;
    }

    /* ==========================================================================
       SECTION 4: RETAINER RELATIONSHIPS
       ========================================================================== */
    .retainer-wrap {
        background-color: var(--bg-dark-section);
        display: grid;
        grid-template-columns: 48% 52%;
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .retainer-content-side {
        padding: var(--section-py) var(--section-px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .retainer-heading {
        font-family: var(--font-serif);
        font-size: 34px;
        font-weight: 300;
        line-height: 1.25;
        color: var(--text-white);
        margin-bottom: 28px;
    }
    .retainer-sub-intro {
        font-family: var(--font-sans);
        font-size: 11px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--gold-accent);
        margin-bottom: 20px;
        font-weight: 500;
    }
    .retainer-offerings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }
    .retainer-ul {
        list-style: none;
        padding-left: 0;
    }
    .retainer-ul li {
        font-family: var(--font-sans);
        font-size: 13.5px;
        color: var(--text-light-muted);
        margin-bottom: 12px;
        position: relative;
        padding-left: 16px;
        line-height: 1.5;
        font-weight: 300;
    }
    .retainer-ul li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: var(--gold-accent);
        font-size: 13px;
        top: -1px;
    }
    .retainer-fee-note {
        font-family: var(--font-serif);
        font-size: 14.5px;
        line-height: 1.55;
        color: var(--gold-accent);
        font-style: italic;
        margin-top: 24px;
        max-width: 380px;
    }
    .retainer-photo-side {
        position: relative;
        background: #000;
        min-height: 480px;
    }
    .retainer-photo-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ==========================================================================
       SECTION 5: CARL MALMSTEN (Founder Portrait & Narrative)
       ========================================================================== */
    .founder-wrap {
        display: grid;
        grid-template-columns: 44% 56%;
        background-color: var(--bg-cream);
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .founder-photo-half {
        position: relative;
        background-color: #000;
        min-height: 480px;
    }
    .founder-photo-half img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        filter: grayscale(100%);
    }
    .founder-card-half {
        background-color: var(--bg-cream);
        color: var(--text-dark);
        padding: var(--section-py) var(--section-px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .founder-name-heading {
        font-family: var(--font-serif);
        font-size: 40px;
        font-weight: 400;
        line-height: 1.18;
        color: #201c17;
        margin-bottom: 24px;
    }
    .founder-narrative {
        font-family: var(--font-sans);
        font-size: 14.5px;
        line-height: 1.8;
        color: #443e37;
        margin-bottom: 18px;
        font-weight: 300;
    }
    .founder-narrative:last-child {
        margin-bottom: 0;
    }

    /* ==========================================================================
       SECTION 6: PRIVATE INQUIRY (High Contrast Floating Labels)
       ========================================================================== */
    .inquiry-wrap {
        background-color: var(--bg-dark);
        padding: var(--section-py) var(--section-px);
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .inquiry-flex {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 64px;
        align-items: start;
    }
    .inquiry-heading {
        font-family: var(--font-serif);
        font-size: 36px;
        font-weight: 300;
        line-height: 1.22;
        color: var(--text-white);
        margin-bottom: 22px;
    }
    .inquiry-text {
        font-family: var(--font-sans);
        font-size: 14px;
        line-height: 1.75;
        color: var(--text-light-muted);
        margin-bottom: 16px;
        font-weight: 300;
    }

    /* Modern Floating Label Form Controls */
    .inquiry-form-wrapper {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .inquiry-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }
    .form-floating-group {
        position: relative;
        width: 100%;
    }
    .floating-input {
        width: 100%;
        height: 52px;
        padding: 20px 14px 6px 14px;
        background-color: var(--input-bg);
        border: 1px solid var(--border-input);
        color: var(--input-text);
        font-family: var(--font-sans);
        font-size: 13.5px;
        outline: none;
        border-radius: 2px;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .floating-label {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--input-label);
        font-family: var(--font-sans);
        font-size: 13px;
        pointer-events: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 400;
        letter-spacing: 0.02em;
    }
    .floating-input:focus,
    .floating-input:not(:placeholder-shown) {
        background-color: var(--input-bg-focus);
        border-color: var(--gold-accent);
        box-shadow: 0 0 0 2px var(--gold-subtle);
    }
    .floating-input:focus ~ .floating-label,
    .floating-input:not(:placeholder-shown) ~ .floating-label {
        top: 13px;
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--gold-accent);
    }

    .inquiry-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
    }
    .lock-notice {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-light-muted);
    }
    .lock-notice svg {
        color: var(--gold-accent);
    }
    .btn-form-submit {
        display: inline-block;
        background: var(--gold-btn);
        color: #171513;
        font-family: var(--font-sans);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 13px 28px;
        text-decoration: none;
        border: 1px solid var(--gold-accent);
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .btn-form-submit:hover {
        background: var(--gold-btn-hover);
        color: #000;
        box-shadow: 0 4px 16px var(--gold-subtle);
    }
    .alert-inquiry {
        padding: 14px;
        border: 1px solid var(--gold-accent);
        background: var(--gold-subtle);
        color: var(--gold-text);
        font-size: 13.5px;
        margin-bottom: 16px;
        display: none;
        border-radius: 2px;
    }

    /* ==========================================================================
       SECTION 7: FOOTER
       ========================================================================== */
    .footer-wrap {
        background-color: var(--bg-dark-section);
        padding: 40px 64px;
        font-size: 12px;
        color: var(--text-light-muted);
        transition: background-color 0.3s ease;
    }
    .footer-content {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        align-items: center;
        width: 100%;
    }
    .footer-logo {
        font-family: var(--font-serif);
        font-size: 13px;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--text-white);
        text-align: left;
    }
    .footer-tagline-text {
        color: var(--gold-accent) !important;
        font-size: 12.5px;
        letter-spacing: 0.04em;
        font-style: italic;
        text-align: center;
    }
    .footer-right-links {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 16px;
        color: var(--text-light-muted);
        font-size: 11.5px;
        text-align: right;
    }

    /* ==========================================================================
       RESPONSIVE DESIGN (Precise Mobile Layout Balance)
       ========================================================================== */
    @media (max-width: 1100px) {
        .approach-header-col { border-right: none; padding-right: 0; margin-bottom: 32px; }
        .approach-flex { grid-template-columns: 1fr; gap: 32px; }
        .pillars-row { grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .pillar-item { padding: 14px; border-right: none; border-bottom: 1px solid var(--border-dark); }
        .hero-wrap, .mandate-wrap, .approach-wrap, .serves-wrap, .retainer-content-side, .founder-card-half, .inquiry-wrap, .footer-wrap {
            padding-left: 36px;
            padding-right: 36px;
        }
    }
    @media (max-width: 900px) {
        .hero-wrap { padding-top: 140px; }
        .approach-flex { grid-template-columns: 1fr; gap: 32px; }
        .pillars-row { grid-template-columns: repeat(2, 1fr); }
        .serves-flex { grid-template-columns: 1fr; gap: 32px; }
        .criteria-2col {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }
        .criteria-col-left, .criteria-col-right {
            display: contents;
        }
        .serves-disclaimer-row { margin-top: 24px; }
        .serves-disclaimer-col-left { align-items: center; text-align: center; }
        .serves-small-divider { margin: 0 auto 12px auto; }
        .serves-footer-note { text-align: center; margin: 0 auto; }
        .retainer-wrap { grid-template-columns: 1fr; }
        .retainer-photo-side { min-height: 320px; order: 1; }
        .retainer-content-side { order: 2; padding: var(--section-py) var(--section-px); }
        .founder-wrap { grid-template-columns: 1fr; }
        .founder-photo-half { min-height: 380px; }
        .founder-card-half { padding: var(--section-py) var(--section-px); }
        .inquiry-flex { grid-template-columns: 1fr; gap: 36px; }
        .inquiry-row-3 { grid-template-columns: 1fr; }
        .footer-content { flex-direction: column; gap: 16px; text-align: center; }
        .footer-logo, .footer-tagline-text, .footer-right-links { text-align: center; justify-content: center; }
    }
    @media (max-width: 768px) {
        /* Mobile Stacked Retainer Offerings - Clean Vertical List avoiding short line wraps */
        .retainer-offerings-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .retainer-ul li {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 14px;
            padding-left: 20px;
        }
        .mandate-lead {
            font-size: 20px;
        }
    }
    @media (max-width: 600px) {
        .hero-title { font-size: 38px; letter-spacing: 0.08em; }
        .pillars-row { grid-template-columns: 1fr; }
        .hero-wrap, .mandate-wrap, .approach-wrap, .serves-wrap, .retainer-content-side, .founder-card-half, .inquiry-wrap, .footer-wrap {
            padding-left: 22px;
            padding-right: 22px;
        }
        .inquiry-footer-row { flex-direction: column-reverse; gap: 18px; align-items: stretch; text-align: center; }
        .btn-form-submit { width: 100%; text-align: center; }
    }
</style>
@endsection

@section('content')

    <!-- =========================================================================
         1. HERO SECTION (Minimalist Monumental Stone Bridge)
         ========================================================================= -->
    <section class="hero-wrap" id="hero">
        <div class="hero-vignette"></div>
        <div class="hero-bottom-grad"></div>

        <div class="hero-inner">
            <h1 class="hero-title">{!! nl2br(e($settings['hero_title'] ?? "STONEBRIDGE\nADVISORY")) !!}</h1>

            <div>
                <a href="{{ $settings['hero_cta_link'] ?? '#private-inquiry' }}" class="btn-hero-inquiry">
                    {{ $settings['hero_cta_text'] ?? 'PRIVATE INQUIRY' }}
                </a>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         1.5. THE STONEBRIDGE MANDATE & INVITATION (Subtext Architectural Band)
         ========================================================================= -->
    <section class="mandate-wrap" id="mandate">
        <div class="mandate-inner">
            <span class="mandate-badge">
                {{ $settings['hero_badge'] ?? 'BY REFERRAL AND LIMITED INVITATION.' }}
            </span>
            <div class="section-accent-line gold" style="margin:0 auto 24px auto;"></div>

            <p class="mandate-lead">
                {{ $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.' }}
            </p>
            <p class="mandate-secondary">
                {{ $settings['hero_lead_2'] ?? 'Supporting those whose circumstances call for continuity, discretion, and thoughtful guidance.' }}
            </p>
        </div>
    </section>

    <!-- =========================================================================
         2. THE STONEBRIDGE APPROACH
         ========================================================================= -->
    <section class="approach-wrap" id="approach">
        <div class="approach-flex">
            <div class="approach-header-col">
                <span class="tag-gold">{{ $settings['approach_tag'] ?? 'THE STONEBRIDGE APPROACH' }}</span>
                <div class="section-accent-line gold"></div>
                <h2 class="approach-heading">{{ $settings['approach_headline'] ?? 'Meaningful work develops through continuity.' }}</h2>
            </div>

            <div class="pillars-row">
                @foreach($pillars as $pillar)
                    <div class="pillar-item">
                        <div class="pillar-icon-box">
                            {!! $pillar->icon_svg !!}
                        </div>
                        <h3 class="pillar-name">{{ $pillar->title }}</h3>
                        <p class="pillar-body">{{ $pillar->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. WHO STONEBRIDGE SERVES (Warm Cream Card)
         ========================================================================= -->
    <section class="serves-wrap" id="who-we-serve">
        <div class="serves-flex">
            <div>
                <span class="tag-bronze">{{ $settings['clientele_tag'] ?? 'WHO STONEBRIDGE SERVES' }}</span>
                <div class="section-accent-line bronze"></div>
                <h2 class="serves-heading">{{ $settings['clientele_headline'] ?? 'Stonebridge may be appropriate for individuals who:' }}</h2>
            </div>

            <div>
                <div class="criteria-2col">
                    <div class="criteria-col-left">
                        @foreach($criteria->slice(0, 4) as $c)
                            <div class="criterion-row">
                                <div class="circle-check">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3.5 8 6.5 11 12.5 5"></polyline>
                                    </svg>
                                </div>
                                <div class="criterion-label">{{ $c->text }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="criteria-col-right">
                        @foreach($criteria->slice(4) as $c)
                            <div class="criterion-row">
                                <div class="circle-check">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3.5 8 6.5 11 12.5 5"></polyline>
                                    </svg>
                                </div>
                                <div class="criterion-label">{{ $c->text }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="serves-disclaimer-row">
                    <div class="serves-disclaimer-col-left">
                        <div class="serves-small-divider"></div>
                        <div class="serves-footer-note">
                            {{ $settings['clientele_disclaimer'] ?? 'Stonebridge is not intended as emergency, crisis, or acute psychiatric care.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         4. RETAINER RELATIONSHIPS (Balanced List Stack on Mobile)
         ========================================================================= -->
    <section class="retainer-wrap" id="retainers">
        <div class="retainer-content-side">
            <span class="tag-gold">{{ $settings['retainer_tag'] ?? 'RETAINER RELATIONSHIPS' }}</span>
            <div class="section-accent-line gold"></div>
            <h2 class="retainer-heading">{{ $settings['retainer_headline'] ?? 'Stonebridge operates through a limited number of ongoing advisory relationships.' }}</h2>

            <div class="retainer-sub-intro">{{ $settings['retainer_intro'] ?? 'Engagements may include:' }}</div>

            <div class="retainer-offerings-grid">
                <ul class="retainer-ul">
                    @foreach($retainerLeft as $item)
                        <li>{{ $item->title }}</li>
                    @endforeach
                </ul>
                <ul class="retainer-ul">
                    @foreach($retainerRight as $item)
                        <li>{{ $item->title }}</li>
                    @endforeach
                </ul>
            </div>

            <p class="retainer-fee-note">
                {!! nl2br(e($settings['retainer_note'] ?? "Investment and availability are discussed\nprivately during the inquiry process.")) !!}
            </p>
        </div>

        <div class="retainer-photo-side">
            <img src="{{ $settings['retainer_image'] ?? '/images/retainer-interior.jpg' }}" alt="Stonebridge Sanctuary Interior">
        </div>
    </section>

    <!-- =========================================================================
         5. CARL MALMSTEN
         ========================================================================= -->
    <section class="founder-wrap" id="carl-malmsten">
        <div class="founder-photo-half">
            <img src="{{ $settings['founder_image'] ?? '/images/carl-malmsten.jpg' }}" alt="Carl Malmsten Portrait">
        </div>

        <div class="founder-card-half">
            <span class="tag-bronze">{{ $settings['founder_tag'] ?? 'CARL MALMSTEN' }}</span>
            <div class="section-accent-line bronze"></div>
            <h2 class="founder-name-heading">{{ $settings['founder_headline'] ?? 'Experience. Perspective. Discretion.' }}</h2>

            <p class="founder-narrative">{{ $settings['founder_p1'] ?? 'Carl Malmsten brings decades of experience supporting individuals, couples, and families through complexity and transition.' }}</p>
            <p class="founder-narrative">{{ $settings['founder_p2'] ?? 'His work is characterized by warmth, practical wisdom, and a commitment to developing enduring relationships capable of adapting thoughtfully to the realities of a full and demanding life.' }}</p>
            <p class="founder-narrative">{{ $settings['founder_p3'] ?? 'Stonebridge Advisory represents an evolution of this work for a limited number of individuals seeking a more integrated and personalized framework of support.' }}</p>
        </div>
    </section>

    <!-- =========================================================================
         6. PRIVATE INQUIRY (High Contrast Floating Labels)
         ========================================================================= -->
    <section class="inquiry-wrap" id="private-inquiry">
        <div class="inquiry-flex">
            <div>
                <span class="tag-gold">{{ $settings['inquiry_tag'] ?? 'PRIVATE INQUIRY' }}</span>
                <div class="section-accent-line gold"></div>
                <h2 class="inquiry-heading">{{ $settings['inquiry_headline'] ?? 'A private conversation begins here.' }}</h2>
                <p class="inquiry-text">{{ $settings['inquiry_p1'] ?? 'Because Stonebridge maintains a limited number of relationships, inquiries are reviewed personally.' }}</p>
                <p class="inquiry-text">{{ $settings['inquiry_p2'] ?? 'Please share a brief overview of your circumstances and what led you to explore this type of relationship.' }}</p>
            </div>

            <div>
                <div id="inquiryAlert" class="alert-inquiry"></div>

                <form id="inquiryForm" class="inquiry-form-wrapper" method="POST" action="{{ route('inquiry.store') }}">
                    @csrf

                    <div class="inquiry-row-3">
                        <div class="form-floating-group">
                            <input type="text" name="full_name" id="inq_full_name" class="floating-input" placeholder=" " required>
                            <label for="inq_full_name" class="floating-label">{{ $settings['inquiry_placeholder_name'] ?? 'Full Name' }}</label>
                        </div>
                        <div class="form-floating-group">
                            <input type="email" name="email" id="inq_email" class="floating-input" placeholder=" " required>
                            <label for="inq_email" class="floating-label">{{ $settings['inquiry_placeholder_email'] ?? 'Email Address' }}</label>
                        </div>
                        <div class="form-floating-group">
                            <input type="tel" name="phone" id="inq_phone" class="floating-input" placeholder=" ">
                            <label for="inq_phone" class="floating-label">{{ $settings['inquiry_placeholder_phone'] ?? 'Phone Number' }}</label>
                        </div>
                    </div>

                    <div class="form-floating-group">
                        <input type="text" name="circumstances" id="inq_circumstances" class="floating-input" placeholder=" " required>
                        <label for="inq_circumstances" class="floating-label">{{ $settings['inquiry_placeholder_circumstances'] ?? 'Brief description of your circumstances' }}</label>
                    </div>

                    <div class="form-floating-group">
                        <input type="text" name="motivation" id="inq_motivation" class="floating-input" placeholder=" ">
                        <label for="inq_motivation" class="floating-label">{{ $settings['inquiry_placeholder_motivation'] ?? 'What led you to explore this type of relationship?' }}</label>
                    </div>

                    <div class="inquiry-footer-row">
                        <div class="lock-notice">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>{{ $settings['inquiry_disclaimer'] ?? 'All inquiries are confidential.' }}</span>
                        </div>

                        <button type="submit" class="btn-form-submit" id="submitBtn">
                            {{ $settings['inquiry_btn_text'] ?? 'PRIVATE INQUIRY' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         7. FOOTER
         ========================================================================= -->
    <footer class="footer-wrap">
        <div class="footer-content">
            <div class="footer-logo">{{ $settings['footer_brand'] ?? 'STONEBRIDGE ADVISORY' }}</div>
            <div class="footer-tagline-text">{{ $settings['footer_tagline'] ?? 'Confidential. Personalized. Enduring.' }}</div>
            <div class="footer-right-links">
                <span>{{ $settings['footer_copyright'] ?? '© Stonebridge Advisory. All rights reserved.' }}</span>
            </div>
        </div>
    </footer>

@endsection

@section('scripts')
<script>
    const form = document.getElementById('inquiryForm');
    const alertBox = document.getElementById('inquiryAlert');
    const btn = document.getElementById('submitBtn');
    const inquiryText = {
        sending: {{ Illuminate\Support\Js::from($settings['inquiry_sending_label'] ?? 'TRANSMITTING...') }},
        validationError: {{ Illuminate\Support\Js::from($settings['inquiry_validation_error'] ?? 'Please check required fields.') }},
        fallbackSuccess: {{ Illuminate\Support\Js::from($settings['inquiry_fallback_success'] ?? 'Your confidential inquiry has been recorded. Thank you.') }}
    };

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const originalLabel = btn.innerText;
            btn.innerText = inquiryText.sending;
            btn.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.innerText = originalLabel;
                btn.disabled = false;
                if (data.success) {
                    alertBox.innerText = data.message;
                    alertBox.style.display = 'block';
                    form.reset();
                } else {
                    alertBox.innerText = inquiryText.validationError;
                    alertBox.style.display = 'block';
                }
            })
            .catch(err => {
                btn.innerText = originalLabel;
                btn.disabled = false;
                alertBox.innerText = inquiryText.fallbackSuccess;
                alertBox.style.display = 'block';
                form.reset();
            });
        });
    }
</script>
@endsection
