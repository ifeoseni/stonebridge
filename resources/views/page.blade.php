@extends('layouts.app')

@section('styles')
<style>
    .container {
        max-width: 1040px;
        margin: 0 auto;
        padding: 0 40px;
    }
    .gold-tag {
        font-family: var(--font-sans);
        font-size: 10px;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--gold-accent);
        font-weight: 600;
        margin-bottom: 14px;
        display: block;
    }
    .page-hero {
        padding: 160px 0 80px;
        background: var(--bg-dark-section);
        border-bottom: 1px solid var(--border-subtle);
        transition: background-color 0.3s ease;
    }
    .page-hero-title {
        font-family: var(--font-serif);
        font-size: 52px;
        font-weight: 300;
        color: var(--text-white);
        margin-bottom: 16px;
        line-height: 1.15;
    }
    .page-hero-subtitle {
        font-size: 16px;
        color: var(--gold-accent);
        font-style: italic;
        max-width: 680px;
    }
    .page-body-section {
        padding: 80px 0 120px;
        background: var(--bg-dark);
        transition: background-color 0.3s ease;
    }
    .page-content-wrapper {
        max-width: 780px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.9;
        color: var(--text-light-muted);
    }
    .page-content-wrapper h2, .page-content-wrapper h3 {
        font-family: var(--font-serif);
        color: var(--text-white);
        font-weight: 400;
        margin-top: 48px;
        margin-bottom: 20px;
    }
    .page-content-wrapper h3 {
        font-size: 24px;
        color: var(--gold-accent);
    }
    .page-content-wrapper p {
        margin-bottom: 24px;
    }
    .page-content-wrapper ul {
        margin-bottom: 28px;
        padding-left: 0;
        list-style: none;
    }
    .page-content-wrapper li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 18px;
    }
    .page-content-wrapper li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: var(--gold-accent);
        font-size: 13px;
    }
    .page-content-wrapper strong {
        color: var(--text-white);
        font-weight: 600;
    }
    .page-back-nav {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--gold-accent);
        font-size: 11px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        text-decoration: none;
        margin-bottom: 28px;
        transition: color 0.2s;
    }
    .page-back-nav:hover {
        color: var(--gold-btn-hover);
    }
    .btn-gold {
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
        border: none;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .btn-gold:hover {
        background: var(--gold-btn-hover);
        color: #000;
    }
    .btn-outline-gold {
        display: inline-block;
        background: transparent;
        color: var(--gold-accent);
        font-family: var(--font-sans);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 12px 24px;
        text-decoration: none;
        border: 1px solid var(--gold-accent);
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .btn-outline-gold:hover {
        background: var(--gold-subtle);
        color: var(--gold-accent);
    }
</style>
@endsection

@section('content')
    <section class="page-hero">
        <div class="container">
            <a href="{{ route('home') }}" class="page-back-nav">
                &larr; Return to Overview
            </a>
            <span class="gold-tag">DOCUMENT OF ADVISORY PROTOCOL</span>
            <h1 class="page-hero-title">{{ $page->title }}</h1>
            @if($page->subtitle)
                <p class="page-hero-subtitle">{{ $page->subtitle }}</p>
            @endif
        </div>
    </section>

    <section class="page-body-section">
        <div class="container">
            <div class="page-content-wrapper">
                {!! \Illuminate\Support\Str::markdown($page->content) !!}

                <div style="margin-top: 64px; padding-top: 32px; border-top: 1px solid var(--border-dark); display:flex; justify-content:space-between; align-items:center;">
                    <a href="{{ route('home') }}" class="btn-outline-gold">&larr; Back to Stonebridge Advisory</a>
                    <a href="{{ route('home') }}#private-inquiry" class="btn-gold">Private Inquiry</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple footer -->
    <footer style="background:var(--bg-dark-section); padding:36px 0; border-top:1px solid var(--border-subtle); text-align:center; font-size:12px; color:var(--text-light-muted); transition:background-color 0.3s ease;">
        <div class="container">
            {{ $settings['brand_name'] ?? 'STONEBRIDGE ADVISORY' }} &mdash; {{ $settings['footer_tagline'] ?? 'Confidential. Personalized. Enduring.' }}
        </div>
    </footer>
@endsection
