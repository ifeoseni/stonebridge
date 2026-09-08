@extends('admin.layouts.admin')

@section('title', 'Edit Page')

@section('admin_content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <h1 class="wp-heading-inline">Edit Page &mdash; {{ $page->title }}</h1>
        <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="button">View Page</a>
    </div>
    <hr class="wp-header-end" style="margin-bottom:20px; border:none;">

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display:grid; grid-template-columns: 3fr 1fr; gap:24px;">
            <div>
                <div style="margin-bottom:20px;">
                    <input type="text" name="title" value="{{ $page->title }}" class="large-text" required style="font-size:20px; padding:10px 14px;">
                </div>

                <div class="postbox">
                    <div class="postbox-header">
                        <h2>Subtitle & Document Header</h2>
                    </div>
                    <div class="inside">
                        <input type="text" name="subtitle" value="{{ $page->subtitle }}" class="large-text">
                    </div>
                </div>

                <div class="postbox">
                    <div class="postbox-header">
                        <h2>Content</h2>
                    </div>
                    <div class="inside">
                        <textarea name="content" rows="18" class="large-text" required>{{ $page->content }}</textarea>
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
                                <input type="checkbox" name="is_published" value="1" {{ $page->is_published ? 'checked' : '' }}>
                                <strong>Published</strong>
                            </label>
                        </div>
                        <div style="margin-bottom:16px;">
                            <label for="slug" style="display:block; font-weight:600; margin-bottom:4px;">URL Slug:</label>
                            <input type="text" name="slug" id="slug" value="{{ $page->slug }}" class="large-text" style="font-size:12px;" required>
                        </div>
                        <button type="submit" class="button button-primary" style="width:100%;">Update Page</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
