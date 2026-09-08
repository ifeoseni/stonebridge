@extends('admin.layouts.admin')

@section('title', 'Add New Page')

@section('admin_content')
    <h1 class="wp-heading-inline">Add New Page</h1>
    <hr class="wp-header-end" style="margin-bottom:20px; border:none;">

    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf

        <div style="display:grid; grid-template-columns: 3fr 1fr; gap:24px;">
            <div>
                <div style="margin-bottom:20px;">
                    <input type="text" name="title" placeholder="Add title" class="large-text" required style="font-size:20px; padding:10px 14px;">
                </div>

                <div class="postbox">
                    <div class="postbox-header">
                        <h2>Subtitle & Document Header</h2>
                    </div>
                    <div class="inside">
                        <input type="text" name="subtitle" placeholder="Document subtitle or brief charter purpose" class="large-text">
                    </div>
                </div>

                <div class="postbox">
                    <div class="postbox-header">
                        <h2>Content</h2>
                    </div>
                    <div class="inside">
                        <textarea name="content" rows="16" class="large-text" placeholder="Write document narrative and protocol content here..." required></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>Publish</h2>
                    </div>
                    <div class="inside">
                        <div style="margin-bottom:12px;">
                            <label style="display:flex; align-items:center; gap:8px;">
                                <input type="checkbox" name="is_published" value="1" checked>
                                <strong>Published Immediately</strong>
                            </label>
                        </div>
                        <div style="margin-bottom:16px;">
                            <label for="slug" style="display:block; font-weight:600; margin-bottom:4px;">URL Slug:</label>
                            <input type="text" name="slug" id="slug" placeholder="leave blank to auto-generate" class="large-text" style="font-size:12px;">
                        </div>
                        <button type="submit" class="button button-primary" style="width:100%;">Publish Page</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
