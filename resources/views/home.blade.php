@extends('layouts.app')

@section('styles')
<style>
    /* ==========================================================================
       SECTION 1: HERO (Atmospheric River & Stone Bridge)
       ========================================================================== */
    .hero-wrap {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: #090b0d url('{{ $settings["hero_image"] ?? "/images/hero-bridge.jpg" }}') no-repeat center right / cover;
        padding: 160px 64px 100px 64px;
    }
    .hero-vignette {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to right,
            rgba(7, 9, 11, 0.96) 0%,
            rgba(7, 9, 11, 0.88) 38%,
            rgba(7, 9, 11, 0.5) 65%,
            rgba(7, 9, 11, 0.25) 100%
        );
        z-index: 1;
    }
    .hero-bottom-grad {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 140px;
        background: linear-gradient(to bottom, transparent, #0c0e10);
        z-index: 2;
    }
    .hero-inner {
        position: relative;
        z-index: 10;
        max-width: 560px;
    }
    .hero-title {
        font-family: var(--font-serif);
        font-size: 58px;
        font-weight: 300;
        letter-spacing: 0.08em;
        line-height: 1.1;
        color: #f6f3eb;
        text-transform: uppercase;
        margin-bottom: 28px;
    }
    .hero-lead-text {
        font-family: var(--font-sans);
        font-size: 14.5px;
        line-height: 1.75;
        color: #bec3c7;
        margin-bottom: 20px;
        font-weight: 300;
    }
    .hero-invitation-badge {
        font-family: var(--font-sans);
        font-size: 10px;
        letter-spacing: 0.22em;
        color: var(--gold-accent);
        text-transform: uppercase;
        font-weight: 600;
        margin: 28px 0 28px;
        display: block;
    }
    /* Refined Architectural Accent Lines matching Reference Screenshot */
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
    .serves-small-divider {
        width: 32px;
        height: 1px;
        background-color: rgba(40, 35, 30, 0.2);
        margin: 32px 0 16px 0;
        display: block;
    }

    .btn-gold-box, .btn-gold-solid {
        display: inline-block;
        background: transparent !important;
        color: var(--gold-accent) !important;
        font-family: var(--font-sans);
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 11px 26px;
        text-decoration: none;
        border: 1px solid var(--gold-accent) !important;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .btn-gold-box:hover, .btn-gold-solid:hover {
        background: rgba(191, 161, 118, 0.12) !important;
        color: #dfc8a5 !important;
        border-color: #dfc8a5 !important;
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
        padding: 13px 26px;
        text-decoration: none;
        border: 1px solid var(--gold-accent);
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .btn-form-submit:hover {
        background: var(--gold-btn-hover);
        color: #000;
    }

    /* ==========================================================================
       SECTION 2: THE STONEBRIDGE APPROACH (Dark 5-column horizontal row)
       ========================================================================== */
    .approach-wrap {
        background-color: var(--bg-approach);
        padding: 70px 64px 85px 64px;
    }
    .approach-flex {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0;
        align-items: start;
    }
    .approach-header-col {
        padding-right: 32px;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
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
        color: #f7f4ed;
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
        padding: 0 12px;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
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
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.01em;
        color: #f5f3ee;
        margin-bottom: 8px;
        white-space: nowrap;
    }
    .pillar-body {
        font-family: var(--font-sans);
        font-size: 11.5px;
        line-height: 1.6;
        color: #888e94;
        font-weight: 300;
    }

    /* ==========================================================================
       SECTION 3: WHO STONEBRIDGE SERVES (Pure Cream #f4ede4 Background)
       ========================================================================== */
    .serves-wrap {
        background-color: var(--bg-cream);
        color: var(--text-dark);
        padding: 95px 64px 85px 64px;
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
        align-items: start;
    }
    .criteria-col-left, .criteria-col-right {
        display: flex;
        flex-direction: column;
        gap: 22px;
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
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 40px;
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
        max-width: 290px;
        margin: 0;
    }

    /* ==========================================================================
       SECTION 4: RETAINER RELATIONSHIPS (Dark & Still Life)
       ========================================================================= */
    .retainer-wrap {
        background-color: #0d0f11;
        display: grid;
        grid-template-columns: 46% 54%;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    .retainer-content-side {
        padding: 85px 56px 85px 64px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .retainer-heading {
        font-family: var(--font-serif);
        font-size: 34px;
        font-weight: 300;
        line-height: 1.25;
        color: #f7f4ed;
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
    .retainer-2col-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        margin-bottom: 32px;
    }
    .retainer-ul {
        list-style: none;
    }
    .retainer-ul li {
        font-family: var(--font-sans);
        font-size: 13.5px;
        color: #afb5ba;
        margin-bottom: 10px;
        position: relative;
        padding-left: 14px;
        line-height: 1.45;
        font-weight: 300;
    }
    .retainer-ul li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: var(--gold-accent);
        font-size: 12px;
    }
    .retainer-fee-note {
        font-family: var(--font-serif);
        font-size: 14.5px;
        line-height: 1.55;
        color: var(--gold-accent);
        font-style: italic;
        margin-top: 24px;
        max-width: 360px;
    }
    .retainer-photo-side {
        position: relative;
        background: #000;
    }
    .retainer-photo-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ==========================================================================
       SECTION 5: CARL MALMSTEN (50% Photo + 50% Cream Card)
       ========================================================================== */
    .founder-wrap {
        display: grid;
        grid-template-columns: 44% 56%;
        background-color: var(--bg-cream);
    }
    .founder-photo-half {
        position: relative;
        background-color: #000;
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
        padding: 95px 72px;
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
       SECTION 6: PRIVATE INQUIRY
       ========================================================================== */
    .inquiry-wrap {
        background-color: #080a0c;
        padding: 100px 64px 80px 64px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
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
        color: #f7f4ed;
        margin-bottom: 22px;
    }
    .inquiry-text {
        font-family: var(--font-sans);
        font-size: 14px;
        line-height: 1.75;
        color: #8f969d;
        margin-bottom: 16px;
        font-weight: 300;
    }

    /* The Inquiry Form Elements */
    .inquiry-form-wrapper {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .inquiry-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }
    .inquiry-input {
        width: 100%;
        background-color: #0f1215;
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #f0ece3;
        padding: 12px 14px;
        font-family: var(--font-sans);
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.2s;
    }
    .inquiry-input::placeholder {
        color: #5c6268;
        font-weight: 300;
    }
    .inquiry-input:focus {
        border-color: var(--gold-accent);
        background-color: #13171b;
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
        color: #727980;
    }
    .lock-notice svg {
        color: var(--gold-accent);
    }
    .alert-inquiry {
        padding: 14px;
        border: 1px solid var(--gold-accent);
        background: rgba(191, 161, 118, 0.08);
        color: var(--gold-accent);
        font-size: 13.5px;
        margin-bottom: 16px;
        display: none;
    }

    /* ==========================================================================
       SECTION 7: FOOTER
       ========================================================================== */
    .footer-wrap {
        background-color: #060708;
        padding: 34px 64px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 12px;
        color: #636a71;
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
        color: #d1ccc2;
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
        color: #555b62;
        font-size: 11.5px;
        text-align: right;
    }
    .footer-right-links a {
        color: #636a71;
        text-decoration: none;
        transition: color 0.2s;
    }
    .footer-right-links a:hover {
        color: var(--gold-accent);
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .approach-header-col { border-right: none; padding-right: 0; margin-bottom: 32px; }
        .approach-flex { grid-template-columns: 1fr; gap: 32px; }
        .pillars-row { grid-template-columns: repeat(3, 1fr); padding-left: 0; }
        .pillar-item { padding: 14px; border-right: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06); }
        .hero-wrap, .approach-wrap, .serves-wrap, .retainer-content-side, .founder-card-half, .inquiry-wrap, .footer-wrap {
            padding-left: 36px;
            padding-right: 36px;
        }
    }
    @media (max-width: 900px) {
        .hero-wrap { padding-top: 140px; }
        .approach-flex { grid-template-columns: 1fr; gap: 32px; }
        .pillars-row { grid-template-columns: repeat(2, 1fr); }
        .serves-flex { grid-template-columns: 1fr; gap: 32px; }
        .criteria-2col { grid-template-columns: 1fr; }
        .serves-disclaimer-row { grid-template-columns: 1fr; margin-top: 24px; }
        .serves-disclaimer-row > div:first-child { display: none; }
        .retainer-wrap { grid-template-columns: 1fr; }
        .retainer-photo-side { min-height: 380px; }
        .founder-wrap { grid-template-columns: 1fr; }
        .founder-photo-half { min-height: 400px; }
        .inquiry-flex { grid-template-columns: 1fr; gap: 36px; }
        .inquiry-row-3 { grid-template-columns: 1fr; }
        .footer-content { flex-direction: column; gap: 16px; text-align: center; }
    }
    @media (max-width: 600px) {
        .hero-title { font-size: 42px; }
        .pillars-row { grid-template-columns: 1fr; }
        .hero-wrap, .approach-wrap, .serves-wrap, .retainer-content-side, .founder-card-half, .inquiry-wrap, .footer-wrap {
            padding-left: 20px;
            padding-right: 20px;
        }
        .inquiry-footer-row { flex-direction: column-reverse; gap: 16px; align-items: stretch; text-align: center; }
    }
</style>
@endsection

@section('content')

    <!-- =========================================================================
         1. HERO SECTION
         ========================================================================= -->
    <section class="hero-wrap" id="hero">
        <div class="hero-vignette"></div>
        <div class="hero-bottom-grad"></div>

        <div class="hero-inner">
            <h1 class="hero-title">{!! nl2br(e($settings['hero_title'] ?? "STONEBRIDGE\nADVISORY")) !!}</h1>
            <div class="section-accent-line gold"></div>

            <p class="hero-lead-text">
                {{ $settings['hero_lead_1'] ?? 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.' }}
            </p>
            <p class="hero-lead-text">
                {{ $settings['hero_lead_2'] ?? 'Supporting those whose circumstances call for continuity, discretion, and thoughtful guidance.' }}
            </p>

            <span class="hero-invitation-badge">
                {{ $settings['hero_badge'] ?? 'BY REFERRAL AND LIMITED INVITATION.' }}
            </span>

            <div>
                <a href="{{ $settings['hero_cta_link'] ?? '#private-inquiry' }}" class="btn-gold-solid">
                    {{ $settings['hero_cta_text'] ?? 'PRIVATE INQUIRY' }}
                </a>
            </div>
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
                    <div></div>
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
         4. RETAINER RELATIONSHIPS
         ========================================================================= -->
    <section class="retainer-wrap" id="retainers">
        <div class="retainer-content-side">
            <span class="tag-gold">{{ $settings['retainer_tag'] ?? 'RETAINER RELATIONSHIPS' }}</span>
            <div class="section-accent-line gold"></div>
            <h2 class="retainer-heading">{{ $settings['retainer_headline'] ?? 'Stonebridge operates through a limited number of ongoing advisory relationships.' }}</h2>

            <div class="retainer-sub-intro">{{ $settings['retainer_intro'] ?? 'Engagements may include:' }}</div>

            <div class="retainer-2col-list">
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
         6. PRIVATE INQUIRY
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
                        <input type="text" name="full_name" class="inquiry-input" placeholder="{{ $settings['inquiry_placeholder_name'] ?? 'Full Name' }}" required>
                        <input type="email" name="email" class="inquiry-input" placeholder="{{ $settings['inquiry_placeholder_email'] ?? 'Email Address' }}" required>
                        <input type="tel" name="phone" class="inquiry-input" placeholder="{{ $settings['inquiry_placeholder_phone'] ?? 'Phone Number' }}">
                    </div>

                    <input type="text" name="circumstances" class="inquiry-input" placeholder="{{ $settings['inquiry_placeholder_circumstances'] ?? 'Brief description of your circumstances' }}" required>

                    <input type="text" name="motivation" class="inquiry-input" placeholder="{{ $settings['inquiry_placeholder_motivation'] ?? 'What led you to explore this type of relationship?' }}">

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
