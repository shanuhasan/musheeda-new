<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesAndPermissionsSeeder;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_view_pages_list()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $response = $this->actingAs($admin)->get(route('admin.pages.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_page()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $response = $this->actingAs($admin)->post(route('admin.pages.store'), [
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => '<p>About us content</p>',
            'status' => 'published',
            'seo' => [
                'meta_title' => 'About Us SEO',
            ],
        ]);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['title' => 'About Us', 'slug' => 'about-us']);
        $this->assertDatabaseHas('seo_metadata', ['meta_title' => 'About Us SEO']);
    }

    public function test_unauthorized_user_cannot_create_page()
    {
        $user = User::factory()->create(); // No role
        
        $response = $this->actingAs($user)->post(route('admin.pages.store'), [
            'title' => 'About Us',
            'status' => 'published',
        ]);

        $response->assertStatus(403);
    }
}
