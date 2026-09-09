<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomizerThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_with_refined_hero_and_mandate_sections(): void
    {
        $this->seed();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('STONEBRIDGE');
        $response->assertSee('ADVISORY');
        $response->assertSee('mandate-badge', false);
        $response->assertSee('form-floating-group', false);
        $response->assertSee('theme-toggle-btn', false);
        $response->assertSee('hero-bridge-dark.jpg');
        $response->assertSee('hero-bridge-light.jpg');
    }

    public function test_admin_can_update_light_hero_image_and_theme_settings(): void
    {
        Storage::fake('public');
        $this->seed();

        $admin = User::first();

        $file = UploadedFile::fake()->image('custom-bridge-light.jpg', 1920, 1080);

        $response = $this->actingAs($admin)->post(route('admin.customize.settings'), [
            'tab' => 'hero',
            'hero_title' => "STONEBRIDGE\nADVISORY",
            'hero_image_light_file' => $file,
        ]);

        $response->assertRedirect(route('admin.customize', ['tab' => 'hero']));

        $setting = SiteSetting::where('key', 'hero_image_light')->first();
        $this->assertNotNull($setting);
        $this->assertStringStartsWith('/storage/uploads/', $setting->value);

        $storedPath = str_replace('/storage/', '', $setting->value);
        Storage::disk('public')->assertExists($storedPath);
    }
}
