<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_advertisement(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/advertisements', [
            'name' => 'Header Ad',
            'placement' => 'header',
            'code' => '<script>console.log("ad")</script>',
            'is_active' => true,
            'is_lazy' => true,
            'sort_order' => 0,
        ]);

        $response->assertRedirect('/admin/advertisements');
        $this->assertDatabaseHas('advertisements', [
            'name' => 'Header Ad',
            'placement' => 'header',
            'is_active' => true,
        ]);
    }

    public function test_active_ad_is_rendered_in_component(): void
    {
        Advertisement::create([
            'name' => 'Test Header Ad',
            'placement' => 'header',
            'code' => '<div id="test-ad-code">Hello Ad</div>',
            'is_active' => true,
            'is_lazy' => false,
        ]);

        $view = $this->blade('<x-ad-slot placement="header" />');

        $view->assertSee('<div id="test-ad-code">Hello Ad</div>', false);
    }

    public function test_inactive_ad_is_not_rendered(): void
    {
        Advertisement::create([
            'name' => 'Test Header Ad',
            'placement' => 'header',
            'code' => '<div id="test-ad-code">Hello Ad</div>',
            'is_active' => false,
            'is_lazy' => false,
        ]);

        $view = $this->blade('<x-ad-slot placement="header" />');

        $view->assertDontSee('<div id="test-ad-code">Hello Ad</div>', false);
    }

    public function test_global_tracking_scripts_are_rendered_when_configured(): void
    {
        Setting::create(['group' => 'integrations', 'key' => 'google_analytics_id', 'value' => 'G-12345', 'type' => 'text']);

        $view = $this->blade('<x-tracking-scripts />');

        $view->assertSee('G-12345');
    }
}
