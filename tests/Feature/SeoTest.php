<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_core_seo_tags(): void
    {
        $this->seed();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('rel="canonical"', false);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('property="og:description"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('name="robots"', false);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('Organization', false);
        // Structured data must be VALID JSON with a proper @context key —
        // guards the Blade-directive regression that once leaked compiled
        // PHP into the script block on the live server.
        $html = $response->getContent();
        $this->assertMatchesRegularExpression(
            '#<script type="application/ld\+json">\s*(\{.*?\})\s*</script>#s',
            $html
        );
        preg_match('#<script type="application/ld\+json">\s*(\{.*?\})\s*</script>#s', $html, $matches);
        $structured = json_decode($matches[1], true);
        $this->assertIsArray($structured, 'JSON-LD block is not valid JSON.');
        $this->assertSame('https://schema.org', $structured['@context'] ?? null);
        // Social share image: the Carl Malmsten portrait (uploads file).
        $response->assertSee('/storage/uploads/bglgAapIf4r8BkW4LrFdMXuIOrdZ1EPssi2yvU8x.jpg', false);
        $response->assertSee('property="og:image:alt"', false);
        $response->assertSee('name="twitter:image:alt"', false);
        // Single h1 + labelled landmarks for crawlers and assistive tech.
        $response->assertSee('<h1', false);
        $response->assertSee('aria-label="Stonebridge Advisory introduction"', false);
    }

    public function test_subpage_has_unique_seo_tags_and_breadcrumb_data(): void
    {
        $this->seed();

        $response = $this->get(route('page.show', 'discretion-charter'));

        $response->assertStatus(200);
        $response->assertSee('Charter of Discretion', false);
        $response->assertSee(route('page.show', 'discretion-charter'), false);
        $response->assertSee('BreadcrumbList', false);
    }

    public function test_sitemap_returns_valid_xml_with_home_and_pages(): void
    {
        $this->seed();

        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        // Guards the Blade `?` + `>`-in-echo regression: the declaration must be intact.
        // (Built via concatenation so this very file never contains a literal close tag.)
        $declaration = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
        $this->assertStringStartsWith($declaration, $response->getContent());
        $response->assertSee('<urlset', false);
        $response->assertSee(route('home'), false);
        $response->assertSee(route('page.show', 'discretion-charter'), false);
    }

    public function test_unknown_url_redirects_home_with_error_toast(): void
    {
        $this->seed();

        $response = $this->get('/this-page-does-not-exist-anywhere');

        $response->assertRedirect(route('home'));

        $followed = $this->followingRedirects()->get('/this-page-does-not-exist-anywhere');

        $followed->assertStatus(200);
        $followed->assertSee('id="sb-toast"', false);
        $followed->assertSee('could not be found', false);
    }

    public function test_unknown_admin_url_redirects_into_admin_panel(): void
    {
        $this->seed();

        $response = $this->get('/admin/this-section-does-not-exist');

        // Guests funnel back toward the admin login via the auth middleware.
        $response->assertRedirect(route('admin.dashboard'));
    }
}
