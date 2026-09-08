@extends('admin.layouts.admin')

@section('title', 'Pages')

@section('admin_content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div>
            <h1 class="wp-heading-inline">Pages</h1>
            <a href="{{ route('admin.pages.create') }}" class="button button-secondary">Add New Page</a>
        </div>
    </div>
    <hr class="wp-header-end" style="margin-bottom:16px; border:none;">

    <div class="postbox">
        <div class="inside" style="padding:0;">
            <table class="wp-list-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th style="width:200px;">Slug / URL</th>
                        <th style="width:120px;">Status</th>
                        <th style="width:150px;">Date</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <strong>
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" style="color:#2271b1; text-decoration:none;">
                                        {{ $page->title }}
                                    </a>
                                </strong>
                                @if($page->subtitle)
                                    <div style="font-size:12px; color:#646970; margin-top:2px;">{{ $page->subtitle }}</div>
                                @endif
                            </td>
                            <td>
                                <code>/page/{{ $page->slug }}</code>
                            </td>
                            <td>
                                <span class="status-pill {{ $page->is_published ? 'status-new' : 'status-archived' }}">
                                    {{ $page->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>{{ $page->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="button button-small">View</a>
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="button button-small">Edit</a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Delete this page?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button button-small button-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
