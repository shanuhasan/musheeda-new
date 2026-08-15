<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesAndPermissionsSeeder;

class FrontendPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_guest_can_view_published_page()
    {
        $page = Page::factory()->create([
            'title' => 'Services',
            'slug' => 'services',
            'status' => 'published'
        ]);

        $response = $this->get('/services');
        $response->assertStatus(200);
        $response->assertSee('Services');
    }

    public function test_guest_cannot_view_draft_page()
    {
        $page = Page::factory()->create([
            'slug' => 'draft-page',
            'status' => 'draft'
        ]);

        $response = $this->get('/draft-page');
        $response->assertStatus(404);
    }

    public function test_admin_can_preview_draft_page()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $page = Page::factory()->create([
            'slug' => 'draft-page',
            'status' => 'draft'
        ]);

        $response = $this->actingAs($admin)->get('/draft-page?preview=true');
        $response->assertStatus(200);
        $response->assertSee('PREVIEW mode');
    }
}
