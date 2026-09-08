<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * List all pages (WordPress-style pages list)
     */
    public function index()
    {
        $pages = SubPage::orderBy('order')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show create page form
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store newly created page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sub_pages,slug',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'meta_description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);

        SubPage::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'] ?? null,
            'is_published' => $request->has('is_published'),
            'order' => SubPage::max('order') + 1,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page published successfully.');
    }

    /**
     * Show edit page form
     */
    public function edit($id)
    {
        $page = SubPage::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update page
     */
    public function update(Request $request, $id)
    {
        $page = SubPage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_pages,slug,' . $id,
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'meta_description' => 'nullable|string',
        ]);

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'] ?? null,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Delete page
     */
    public function destroy($id)
    {
        SubPage::destroy($id);
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }
}
