@extends('admin.layouts.admin')

@section('title', 'Customize Website')

@section('admin_styles')
<style>
    /* Split Customizer Layout */
    .customize-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
        padding: 14px 18px;
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .customize-split-layout {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        width: 100%;
        transition: all 0.25s ease;
    }
    .customize-editor-pane {
        flex: 1;
        min-width: 0;
        transition: all 0.25s ease;
    }
    .customize-split-layout.preview-active .customize-editor-pane {
        flex: 0 0 46%;
        max-width: 46%;
    }
    .customize-preview-pane {
        flex: 1;
        min-width: 0;
        position: sticky;
        top: 48px;
        height: calc(100vh - 65px);
        background: #1e1e1e;
        border: 1px solid #3c434a;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
        overflow: hidden;
        z-index: 100;
    }
    .preview-control-bar {
        background: #2c3338;
        padding: 8px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #3c434a;
        flex-shrink: 0;
    }
    .preview-devices {
        display: flex;
        gap: 4px;
        background: #1d2327;
        padding: 3px;
        border-radius: 4px;
    }
    .preview-device-btn {
        display: flex;
        align-items: center;
        gap: 5px;
        background: transparent;
        border: none;
        color: #a7aaad;
        padding: 4px 10px;
        font-size: 11px;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .preview-device-btn:hover {
        color: #fff;
        background: rgba(255,255,255,0.08);
    }
    .preview-device-btn.active {
        background: #2271b1;
        color: #fff;
        font-weight: 600;
    }
    .preview-iframe-outer {
        flex: 1;
        background: #141618;
        display: flex;
        justify-content: center;
        overflow: hidden;
        padding: 10px 0;
    }
    .preview-frame-container {
        height: 100%;
        transition: width 0.25s ease;
        box-shadow: 0 4px 18px rgba(0,0,0,0.6);
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
    }
    .preview-iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }
</style>
@endsection

@section('admin_content')
    <div class="customize-topbar">
        <div>
            <h1 class="wp-heading-inline" style="margin:0; font-size:20px; font-weight:600;">Website Customizer &mdash; Section by Section</h1>
            <p style="margin:4px 0 0 0; color:#646970; font-size:12px;">Edit headlines, photography, pillars, retainers, and private inquiry with optional live preview.</p>
        </div>
        <div style="display:flex; align-items:center; gap:10px;">
            <button type="button" id="togglePreviewBtn" class="button" onclick="toggleSplitPreview()" style="display:inline-flex; align-items:center; gap:6px; font-weight:600; border-color:#2271b1; color:#2271b1; background:#f0f6fc;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span id="togglePreviewBtnText">Enable Live Preview Pane</span>
            </button>
            <a href="{{ route('home') }}" target="_blank" class="button button-gold" style="display:inline-flex; align-items:center; gap:6px; font-weight:600;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Screen Preview</span>
            </a>
        </div>
    </div>

    <div id="customizeSplitLayout" class="customize-split-layout">
        <!-- Left Pane: Editor & Forms -->
        <div id="customizeEditorPane" class="customize-editor-pane">
            <!-- WordPress Nav Tabs -->
            <nav class="nav-tab-wrapper">
                <a href="{{ route('admin.customize', ['tab' => 'hero']) }}" class="nav-tab {{ $activeTab === 'hero' ? 'nav-tab-active' : '' }}">
                    Hero & Background
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'approach']) }}" class="nav-tab {{ $activeTab === 'approach' ? 'nav-tab-active' : '' }}">
                    The Approach (5 Pillars)
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'clientele']) }}" class="nav-tab {{ $activeTab === 'clientele' ? 'nav-tab-active' : '' }}">
                    Who Stonebridge Serves
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'retainer']) }}" class="nav-tab {{ $activeTab === 'retainer' ? 'nav-tab-active' : '' }}">
                    Retainer Relationships
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'founder']) }}" class="nav-tab {{ $activeTab === 'founder' ? 'nav-tab-active' : '' }}">
                    Carl Malmsten (Founder)
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'inquiry']) }}" class="nav-tab {{ $activeTab === 'inquiry' ? 'nav-tab-active' : '' }}">
                    Private Inquiry
                </a>
                <a href="{{ route('admin.customize', ['tab' => 'footer']) }}" class="nav-tab {{ $activeTab === 'footer' ? 'nav-tab-active' : '' }}">
                    Header & Footer
                </a>
            </nav>

    <!-- =========================================================================
         TAB 1: HERO SECTION
         ========================================================================= -->
    @if($activeTab === 'hero')
        <form action="{{ route('admin.customize.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tab" value="hero">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Hero Banner Content</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="hero_title">Main Headline</label></th>
                            <td>
                                <textarea name="hero_title" id="hero_title" rows="3" class="large-text">{{ \App\Models\SiteSetting::get('hero_title') }}</textarea>
                                <p class="description">Displayed in prominent monumental serif lettering across the top hero banner.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_lead_1">Lead Paragraph 1</label></th>
                            <td>
                                <textarea name="hero_lead_1" id="hero_lead_1" rows="4" class="large-text">{{ \App\Models\SiteSetting::get('hero_lead_1') }}</textarea>
                                <p class="description">Core narrative describing the confidential advisory relationships.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_lead_2">Lead Paragraph 2</label></th>
                            <td>
                                <textarea name="hero_lead_2" id="hero_lead_2" rows="3" class="large-text">{{ \App\Models\SiteSetting::get('hero_lead_2') }}</textarea>
                                <p class="description">Secondary narrative regarding continuity and thoughtful guidance.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_badge">Invitation Notice</label></th>
                            <td>
                                <input type="text" name="hero_badge" id="hero_badge" class="regular-text" value="{{ \App\Models\SiteSetting::get('hero_badge') }}">
                                <p class="description">Gold uppercase sub-badge (e.g. "BY REFERRAL AND LIMITED INVITATION.")</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_cta_text">CTA Button Label</label></th>
                            <td>
                                <input type="text" name="hero_cta_text" id="hero_cta_text" class="regular-text" value="{{ \App\Models\SiteSetting::get('hero_cta_text') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="hero_cta_link">CTA Button Link</label></th>
                            <td>
                                <input type="text" name="hero_cta_link" id="hero_cta_link" class="regular-text" value="{{ \App\Models\SiteSetting::get('hero_cta_link') }}">
                                <p class="description">Defaults to <code>#private-inquiry</code> for smooth scroll to inquiry form.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Hero Background Photography</label></th>
                            <td>
                                <div style="display:flex; gap:20px; align-items:flex-start;">
                                    <img src="{{ \App\Models\SiteSetting::get('hero_image', '/images/hero-bridge-dark.jpg') }}" style="width:240px; height:135px; object-fit:cover; border:1px solid #c3c4c7; box-shadow:0 1px 3px rgba(0,0,0,0.1);" alt="Current Hero Bridge">
                                    <div>
                                        <input type="file" name="hero_image_file" accept="image/*">
                                        <p class="description">Moody stone bridge with twilight sky & mist. Recommended 1920x1080.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="margin-top:20px; border-top:1px solid #f0f0f1; padding-top:16px;">
                        <button type="submit" class="button button-primary">Save Changes</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 2: THE APPROACH (5 PILLARS)
         ========================================================================= -->
    @if($activeTab === 'approach')
        <!-- Section Heading Settings -->
        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="approach">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Section Titles</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="approach_tag">Category Tag</label></th>
                            <td>
                                <input type="text" name="approach_tag" id="approach_tag" class="regular-text" value="{{ \App\Models\SiteSetting::get('approach_tag') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="approach_headline">Section Headline</label></th>
                            <td>
                                <textarea name="approach_headline" id="approach_headline" rows="3" class="large-text" style="min-height:85px;">{{ \App\Models\SiteSetting::get('approach_headline') }}</textarea>
                            </td>
                        </tr>
                    </table>
                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Titles</button>
                    </p>
                </div>
            </div>
        </form>

        <!-- The 5 Pillars Editor -->
        <form action="{{ route('admin.customize.pillars') }}" method="POST">
            @csrf
            <div class="postbox">
                <div class="postbox-header">
                    <h2>Edit The 5 Pillars</h2>
                </div>
                <div class="inside">
                    <p style="color:#646970; margin-bottom:16px;">Edit titles, descriptions, and vector SVG line iconography for each of the five pillars:</p>

                    @foreach($pillars as $p)
                        <div style="background:#fafafa; border:1px solid #c3c4c7; padding:16px; margin-bottom:16px; border-radius:4px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <strong style="font-size:14px; color:#1d2327;">Pillar #{{ $p->order }}: {{ $p->title }}</strong>
                                <div style="width:28px; height:28px; color:#c5a880;">{!! $p->icon_svg !!}</div>
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 2fr; gap:16px;">
                                <div>
                                    <label style="display:block; font-weight:600; margin-bottom:4px;">Title</label>
                                    <input type="text" name="pillars[{{ $p->id }}][title]" class="regular-text" value="{{ $p->title }}" style="width:100%;">
                                    
                                    <label style="display:block; font-weight:600; margin-top:10px; margin-bottom:4px;">SVG Icon Markup</label>
                                    <textarea name="pillars[{{ $p->id }}][icon_svg]" rows="3" class="large-text" style="font-family:monospace; font-size:11px;">{{ $p->icon_svg }}</textarea>
                                </div>
                                <div>
                                    <label style="display:block; font-weight:600; margin-bottom:4px;">Description</label>
                                    <textarea name="pillars[{{ $p->id }}][description]" rows="5" class="large-text">{{ $p->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <p class="submit" style="margin-top:20px;">
                        <button type="submit" class="button button-primary">Save All 5 Pillars</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 3: WHO STONEBRIDGE SERVES
         ========================================================================= -->
    @if($activeTab === 'clientele')
        <!-- Section Headings -->
        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="clientele">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Section Titles & Disclaimer</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="clientele_tag">Category Tag</label></th>
                            <td>
                                <input type="text" name="clientele_tag" id="clientele_tag" class="regular-text" value="{{ \App\Models\SiteSetting::get('clientele_tag') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="clientele_headline">Section Main Headline</label></th>
                            <td>
                                <textarea name="clientele_headline" id="clientele_headline" rows="3" class="large-text" style="min-height:85px;">{{ \App\Models\SiteSetting::get('clientele_headline') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="clientele_disclaimer">Emergency / Psychiatric Disclaimer</label></th>
                            <td>
                                <textarea name="clientele_disclaimer" id="clientele_disclaimer" rows="3" class="large-text" style="min-height:80px;">{{ \App\Models\SiteSetting::get('clientele_disclaimer') }}</textarea>
                                <p class="description">Displayed in fine italic serif at the bottom right of the cream card.</p>
                            </td>
                        </tr>
                    </table>
                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Titles</button>
                    </p>
                </div>
            </div>
        </form>

        <!-- Criteria Checklist Items -->
        <form action="{{ route('admin.customize.criteria') }}" method="POST">
            @csrf
            <div class="postbox">
                <div class="postbox-header">
                    <h2>Clientele Criteria (The 8 Qualities)</h2>
                </div>
                <div class="inside">
                    <p style="color:#646970; margin-bottom:16px;">Edit the wording and active status of each item below. Items cannot be added or removed &mdash; only their text and visibility can be changed.</p>
                    <table class="wp-list-table" style="margin-bottom:20px;">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Criteria Description</th>
                                <th style="width:80px;">Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $c)
                                <tr>
                                    <td style="vertical-align:top; padding-top:16px;">{{ $c->order }}</td>
                                    <td>
                                        <textarea name="criteria[{{ $c->id }}][text]" rows="2" class="large-text" style="font-size:14px; min-height:55px;">{{ $c->text }}</textarea>
                                    </td>
                                    <td style="text-align:center; vertical-align:top; padding-top:16px;">
                                        <input type="checkbox" name="criteria[{{ $c->id }}][is_active]" value="1" {{ $c->is_active ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p class="submit">
                        <button type="submit" class="button button-primary">Save Changes to Criteria</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 4: RETAINER RELATIONSHIPS
         ========================================================================= -->
    @if($activeTab === 'retainer')
        <form action="{{ route('admin.customize.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tab" value="retainer">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Retainer Overview & Imagery</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="retainer_tag">Category Tag</label></th>
                            <td>
                                <input type="text" name="retainer_tag" id="retainer_tag" class="regular-text" value="{{ \App\Models\SiteSetting::get('retainer_tag') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="retainer_headline">Section Headline</label></th>
                            <td>
                                <textarea name="retainer_headline" id="retainer_headline" rows="3" class="large-text" style="min-height:85px;">{{ \App\Models\SiteSetting::get('retainer_headline') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="retainer_intro">Offerings Intro</label></th>
                            <td>
                                <input type="text" name="retainer_intro" id="retainer_intro" class="regular-text" value="{{ \App\Models\SiteSetting::get('retainer_intro') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="retainer_note">Investment & Availability Note</label></th>
                            <td>
                                <textarea name="retainer_note" id="retainer_note" rows="3" class="large-text" style="min-height:80px;">{{ \App\Models\SiteSetting::get('retainer_note') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Interior Still-Life Photography</label></th>
                            <td>
                                <div style="display:flex; gap:20px; align-items:flex-start;">
                                    <img src="{{ \App\Models\SiteSetting::get('retainer_image') }}" style="width:240px; height:135px; object-fit:cover; border:1px solid #c3c4c7;" alt="Retainer Still Life">
                                    <div>
                                        <input type="file" name="retainer_image_file" accept="image/*">
                                        <p class="description">Upload a warm interior image (rustic table, dark bowl, dried botanicals). Recommended 1280x720.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Retainer Settings</button>
                    </p>
                </div>
            </div>
        </form>

        <!-- Retainer Offerings (Two Columns) -->
        <form action="{{ route('admin.customize.retainers') }}" method="POST">
            @csrf
            <div class="postbox">
                <div class="postbox-header">
                    <h2>Retainer Engagement Formats (Two Column Lists)</h2>
                </div>
                <div class="inside">
                    <p style="color:#646970; margin-bottom:16px;">Edit the wording of each engagement format below. Items cannot be added or removed &mdash; only their text can be changed.</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px; margin-bottom:24px;">
                        <!-- Column Left -->
                        <div>
                            <h3 style="font-size:14px; margin-bottom:10px; color:#1d2327;">Column 1 (Scheduled & Direct Access)</h3>
                            @foreach($retainerLeft as $item)
                                <div style="margin-bottom:12px;">
                                    <textarea name="engagements[{{ $item->id }}][title]" rows="2" class="large-text" style="width:100%; min-height:55px; font-size:13.5px;">{{ $item->title }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <!-- Column Right -->
                        <div>
                            <h3 style="font-size:14px; margin-bottom:10px; color:#1d2327;">Column 2 (Intensives & Specialized)</h3>
                            @foreach($retainerRight as $item)
                                <div style="margin-bottom:12px;">
                                    <textarea name="engagements[{{ $item->id }}][title]" rows="2" class="large-text" style="width:100%; min-height:55px; font-size:13.5px;">{{ $item->title }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="submit">
                        <button type="submit" class="button button-primary">Save Retainer Lists</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 5: CARL MALMSTEN BIO
         ========================================================================= -->
    @if($activeTab === 'founder')
        <form action="{{ route('admin.customize.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tab" value="founder">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Carl Malmsten Profile & Biography</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="founder_tag">Section Tag</label></th>
                            <td>
                                <input type="text" name="founder_tag" id="founder_tag" class="regular-text" value="{{ \App\Models\SiteSetting::get('founder_tag') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="founder_headline">Main Heading</label></th>
                            <td>
                                <textarea name="founder_headline" id="founder_headline" rows="2" class="large-text" style="min-height:75px;">{{ \App\Models\SiteSetting::get('founder_headline') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="founder_p1">Biography Paragraph 1</label></th>
                            <td>
                                <textarea name="founder_p1" id="founder_p1" rows="4" class="large-text">{{ \App\Models\SiteSetting::get('founder_p1') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="founder_p2">Biography Paragraph 2</label></th>
                            <td>
                                <textarea name="founder_p2" id="founder_p2" rows="5" class="large-text">{{ \App\Models\SiteSetting::get('founder_p2') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="founder_p3">Biography Paragraph 3</label></th>
                            <td>
                                <textarea name="founder_p3" id="founder_p3" rows="4" class="large-text">{{ \App\Models\SiteSetting::get('founder_p3') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Founder Portrait Photograph</label></th>
                            <td>
                                <div style="display:flex; gap:20px; align-items:flex-start;">
                                    <img src="{{ \App\Models\SiteSetting::get('founder_image') }}" style="width:160px; height:160px; object-fit:cover; border:1px solid #c3c4c7; box-shadow:0 1px 3px rgba(0,0,0,0.1);" alt="Carl Malmsten Portrait">
                                    <div>
                                        <input type="file" name="founder_image_file" accept="image/*">
                                        <p class="description">Upload a black and white editorial studio portrait (JPEG, PNG, WebP). Recommended 800x800 square.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Biography & Portrait</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 6: PRIVATE INQUIRY
         ========================================================================= -->
    @if($activeTab === 'inquiry')
        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="inquiry">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Private Inquiry Form Settings</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="inquiry_tag">Section Tag</label></th>
                            <td>
                                <input type="text" name="inquiry_tag" id="inquiry_tag" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_tag') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_headline">Main Heading</label></th>
                            <td>
                                <textarea name="inquiry_headline" id="inquiry_headline" rows="2" class="large-text" style="min-height:75px;">{{ \App\Models\SiteSetting::get('inquiry_headline') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_p1">Explanatory Notice 1</label></th>
                            <td>
                                <textarea name="inquiry_p1" id="inquiry_p1" rows="4" class="large-text">{{ \App\Models\SiteSetting::get('inquiry_p1') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_p2">Explanatory Notice 2</label></th>
                            <td>
                                <textarea name="inquiry_p2" id="inquiry_p2" rows="4" class="large-text">{{ \App\Models\SiteSetting::get('inquiry_p2') }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_disclaimer">Confidentiality Guarantee</label></th>
                            <td>
                                <textarea name="inquiry_disclaimer" id="inquiry_disclaimer" rows="2" class="large-text" style="min-height:60px;">{{ \App\Models\SiteSetting::get('inquiry_disclaimer') }}</textarea>
                                <p class="description">Displayed with the lock icon next to the submit button (e.g. "All inquiries are confidential.")</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_btn_text">Submit Button Label</label></th>
                            <td>
                                <input type="text" name="inquiry_btn_text" id="inquiry_btn_text" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_btn_text') }}">
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Inquiry Form Settings</button>
                    </p>
                </div>
            </div>
        </form>

        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="inquiry">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Form Field Placeholders</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="inquiry_placeholder_name">Full Name Placeholder</label></th>
                            <td>
                                <input type="text" name="inquiry_placeholder_name" id="inquiry_placeholder_name" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_placeholder_name', 'Full Name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_placeholder_email">Email Placeholder</label></th>
                            <td>
                                <input type="text" name="inquiry_placeholder_email" id="inquiry_placeholder_email" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_placeholder_email', 'Email Address') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_placeholder_phone">Phone Placeholder</label></th>
                            <td>
                                <input type="text" name="inquiry_placeholder_phone" id="inquiry_placeholder_phone" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_placeholder_phone', 'Phone Number') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_placeholder_circumstances">Circumstances Placeholder</label></th>
                            <td>
                                <input type="text" name="inquiry_placeholder_circumstances" id="inquiry_placeholder_circumstances" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_placeholder_circumstances', 'Brief description of your circumstances') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_placeholder_motivation">Motivation Placeholder</label></th>
                            <td>
                                <input type="text" name="inquiry_placeholder_motivation" id="inquiry_placeholder_motivation" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_placeholder_motivation', 'What led you to explore this type of relationship?') }}">
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Placeholders</button>
                    </p>
                </div>
            </div>
        </form>

        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="inquiry">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Form Status Messages</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="inquiry_sending_label">Submitting State Label</label></th>
                            <td>
                                <input type="text" name="inquiry_sending_label" id="inquiry_sending_label" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_sending_label', 'TRANSMITTING...') }}">
                                <p class="description">Shown on the submit button while the inquiry is being sent.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_validation_error">Validation Error Message</label></th>
                            <td>
                                <input type="text" name="inquiry_validation_error" id="inquiry_validation_error" class="regular-text" value="{{ \App\Models\SiteSetting::get('inquiry_validation_error', 'Please check required fields.') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="inquiry_fallback_success">Fallback Success Message</label></th>
                            <td>
                                <textarea name="inquiry_fallback_success" id="inquiry_fallback_success" rows="2" class="large-text">{{ \App\Models\SiteSetting::get('inquiry_fallback_success', 'Your confidential inquiry has been recorded. Thank you.') }}</textarea>
                                <p class="description">Shown if the network request fails but the browser could not confirm delivery.</p>
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Status Messages</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

    <!-- =========================================================================
         TAB 7: HEADER & FOOTER
         ========================================================================= -->
    @if($activeTab === 'footer')
        <form action="{{ route('admin.customize.settings') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="footer">

            <div class="postbox">
                <div class="postbox-header">
                    <h2>Brand, Header & Footer Settings</h2>
                </div>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <th><label for="brand_name">Brand Name (Logo)</label></th>
                            <td>
                                <input type="text" name="brand_name" id="brand_name" class="regular-text" value="{{ \App\Models\SiteSetting::get('brand_name') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="header_cta_text">Top Right CTA Button Label</label></th>
                            <td>
                                <input type="text" name="header_cta_text" id="header_cta_text" class="regular-text" value="{{ \App\Models\SiteSetting::get('header_cta_text') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="header_cta_link">Top Right CTA Button Link</label></th>
                            <td>
                                <input type="text" name="header_cta_link" id="header_cta_link" class="regular-text" value="{{ \App\Models\SiteSetting::get('header_cta_link') }}">
                                <p class="description">Defaults to <code>#private-inquiry</code> for smooth scroll to inquiry form.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="header_docs_label">Documents Menu Label</label></th>
                            <td>
                                <input type="text" name="header_docs_label" id="header_docs_label" class="regular-text" value="{{ \App\Models\SiteSetting::get('header_docs_label', 'DOCUMENTS') }}">
                                <p class="description">Label for the discreet header dropdown that lists confidential sub-pages.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="modal_eyebrow">Document Modal Eyebrow Text</label></th>
                            <td>
                                <input type="text" name="modal_eyebrow" id="modal_eyebrow" class="regular-text" value="{{ \App\Models\SiteSetting::get('modal_eyebrow', 'CONFIDENTIAL CHARTER') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="modal_close_label">Document Modal Close Button Label</label></th>
                            <td>
                                <input type="text" name="modal_close_label" id="modal_close_label" class="regular-text" value="{{ \App\Models\SiteSetting::get('modal_close_label', 'Close Document') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="footer_brand">Footer Brand Name</label></th>
                            <td>
                                <input type="text" name="footer_brand" id="footer_brand" class="regular-text" value="{{ \App\Models\SiteSetting::get('footer_brand', 'STONEBRIDGE ADVISORY') }}">
                                <p class="description">Displayed in small uppercase serif on the bottom-left of the footer.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="footer_tagline">Footer Tagline</label></th>
                            <td>
                                <input type="text" name="footer_tagline" id="footer_tagline" class="regular-text" value="{{ \App\Models\SiteSetting::get('footer_tagline') }}">
                                <p class="description">Displayed in the center of the footer (e.g. "Confidential. Personalized. Enduring.").</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="footer_copyright">Footer Copyright Notice</label></th>
                            <td>
                                <input type="text" name="footer_copyright" id="footer_copyright" class="regular-text" value="{{ \App\Models\SiteSetting::get('footer_copyright') }}">
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="padding-top:10px;">
                        <button type="submit" class="button button-primary">Save Global Brand Settings</button>
                    </p>
                </div>
            </div>
        </form>
    @endif

        </div><!-- /#customizeEditorPane -->

        <!-- Right Pane: Live Website Preview -->
        <div id="customizePreviewPane" class="customize-preview-pane" style="display:none;">
            <div class="preview-control-bar">
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-weight:600; font-size:12px; color:#fff; text-transform:uppercase; letter-spacing:0.06em;">Live Website Preview</span>
                    <span id="previewStatusBadge" style="background:#00a32a; color:#fff; font-size:10px; padding:2px 6px; border-radius:3px; font-weight:600;">Live</span>
                </div>

                <!-- Responsive Device Toggle -->
                <div class="preview-devices">
                    <button type="button" class="preview-device-btn active" id="btnDeviceDesktop" onclick="setPreviewDevice('100%', this)" title="Desktop View (100%)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>Desktop</span>
                    </button>
                    <button type="button" class="preview-device-btn" id="btnDeviceTablet" onclick="setPreviewDevice('768px', this)" title="Tablet View (768px)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <span>Tablet</span>
                    </button>
                    <button type="button" class="preview-device-btn" id="btnDeviceMobile" onclick="setPreviewDevice('375px', this)" title="Mobile View (375px)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <span>Mobile</span>
                    </button>
                </div>

                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="button button-small" onclick="reloadPreviewIframe()" title="Reload Live Site">
                        &#x21bb; Refresh
                    </button>
                    <button type="button" class="button button-small" onclick="toggleSplitPreview()" title="Close Preview Pane">
                        &times; Close
                    </button>
                </div>
            </div>

            <div class="preview-iframe-outer">
                <div id="previewFrameContainer" class="preview-frame-container" style="width:100%;">
                    <iframe id="liveSiteIframe" src="{{ route('home') }}" class="preview-iframe"></iframe>
                </div>
            </div>
        </div>
    </div><!-- /#customizeSplitLayout -->
@endsection

@section('scripts')
<script>
    function toggleSplitPreview() {
        const layout = document.getElementById('customizeSplitLayout');
        const previewPane = document.getElementById('customizePreviewPane');
        const btnText = document.getElementById('togglePreviewBtnText');
        const btn = document.getElementById('togglePreviewBtn');

        if (!layout || !previewPane) return;

        const isCurrentlyActive = layout.classList.contains('preview-active');

        if (isCurrentlyActive) {
            layout.classList.remove('preview-active');
            previewPane.style.display = 'none';
            btnText.textContent = 'Enable Live Preview Pane';
            btn.style.background = '#f0f6fc';
            btn.style.borderColor = '#2271b1';
            btn.style.color = '#2271b1';
            localStorage.setItem('stonebridge_preview_open', 'false');
        } else {
            layout.classList.add('preview-active');
            previewPane.style.display = 'flex';
            btnText.textContent = 'Hide Live Preview';
            btn.style.background = '#2271b1';
            btn.style.borderColor = '#2271b1';
            btn.style.color = '#ffffff';
            localStorage.setItem('stonebridge_preview_open', 'true');
            // Trigger autoResizeTextareas after split view resizes the columns
            setTimeout(autoResizeTextareas, 280);
        }
    }

    function setPreviewDevice(width, btn) {
        const container = document.getElementById('previewFrameContainer');
        if (container) {
            container.style.width = width;
        }
        document.querySelectorAll('.preview-device-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
    }

    function reloadPreviewIframe() {
        const iframe = document.getElementById('liveSiteIframe');
        const badge = document.getElementById('previewStatusBadge');
        if (iframe) {
            if (badge) {
                badge.textContent = 'Refreshing...';
                badge.style.background = '#dba617';
            }
            iframe.src = iframe.src;
            iframe.onload = function() {
                if (badge) {
                    badge.textContent = 'Live';
                    badge.style.background = '#00a32a';
                }
            };
        }
    }

    // Restore split preview state on page load if previously open
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('stonebridge_preview_open') === 'true') {
            toggleSplitPreview();
        }
    });
</script>
@endsection
