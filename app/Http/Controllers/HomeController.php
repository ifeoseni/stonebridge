<?php

namespace App\Http\Controllers;

use App\Models\ApproachPillar;
use App\Models\ClienteleCriterion;
use App\Models\RetainerEngagement;
use App\Models\SiteSetting;
use App\Models\SubPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the Stonebridge Advisory homepage
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $pillars = ApproachPillar::orderBy('order')->get();
        $criteria = ClienteleCriterion::where('is_active', true)->orderBy('order')->get();
        $retainerLeft = RetainerEngagement::where('column_side', 'left')->orderBy('order')->get();
        $retainerRight = RetainerEngagement::where('column_side', 'right')->orderBy('order')->get();
        $subPages = SubPage::where('is_published', true)->orderBy('order')->get();

        return view('home', compact(
            'settings',
            'pillars',
            'criteria',
            'retainerLeft',
            'retainerRight',
            'subPages'
        ));
    }

    /**
     * Show a specific sub-page
     */
    public function page(string $slug)
    {
        $page = SubPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $subPages = SubPage::where('is_published', true)->orderBy('order')->get();

        return view('page', compact('page', 'settings', 'subPages'));
    }

    /**
     * Return JSON for modal sub-page view
     */
    public function pageJson(string $slug)
    {
        $page = SubPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return response()->json([
            'title' => $page->title,
            'subtitle' => $page->subtitle,
            'content' => \Illuminate\Support\Str::markdown($page->content),
            'slug' => $page->slug,
        ]);
    }

    /**
     * XML sitemap for search engines.
     *
     * Intentionally homepage-only: sub-pages are hidden from ranking, so
     * they stay out of the sitemap. Built as a raw string (not a Blade
     * view) so the XML declaration can never break Blade compilation, and
     * with no dependency on the page.show route so hiding sub-pages can
     * never crash this endpoint.
     */
    public function sitemap()
    {
        $xml = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"
            . '    <url>' . "\n"
            . '        <loc>' . e(route('home')) . '</loc>' . "\n"
            . '        <lastmod>' . e(now()->toAtomString()) . '</lastmod>' . "\n"
            . '        <changefreq>weekly</changefreq>' . "\n"
            . '        <priority>1.0</priority>' . "\n"
            . '    </url>' . "\n"
            . '</urlset>';

        return response($xml)->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}
