<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create necessary roles
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');
        $this->superAdmin = $superAdmin;
        
        $admin = User::factory()->create();
        // Assuming admin has manage_pages permission but not Super Admin
        $this->admin = $admin;
    }

    public function test_admin_can_create_landing_page_with_blocks()
    {
        $blocks = [
            [
                'id' => 'block_1',
                'type' => 'hero',
                'data' => [
                    'heading' => 'Test Heading'
                ]
            ]
        ];

        $response = $this->actingAs($this->superAdmin)->post(route('admin.landing-pages.store'), [
            'title' => 'Software Landing',
            'slug' => 'software-landing',
            'status' => 'published',
            'blocks' => $blocks
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('landing_pages', [
            'slug' => 'software-landing',
            'status' => 'published'
        ]);

        $page = LandingPage::where('slug', 'software-landing')->first();
        $this->assertIsArray($page->blocks);
        $this->assertEquals('Test Heading', $page->blocks[0]['data']['heading']);
    }

    public function test_non_super_admin_cannot_save_html_block()
    {
        $page = LandingPage::factory()->create(['status' => 'published']);
        
        $blocks = [
            [
                'id' => 'block_1',
                'type' => 'html',
                'data' => [
                    'content' => '<script>alert("xss")</script>'
                ]
            ]
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.landing-pages.update', $page), [
            'title' => 'Software Landing',
            'slug' => $page->slug,
            'status' => 'published',
            'blocks' => $blocks
        ]);

        $response->assertStatus(403); // Forbidden because it's an html block without super admin
    }

    public function test_super_admin_can_save_html_block()
    {
        $page = LandingPage::factory()->create(['status' => 'published']);
        
        $blocks = [
            [
                'id' => 'block_1',
                'type' => 'html',
                'data' => [
                    'content' => '<div>Safe HTML</div>'
                ]
            ]
        ];

        $response = $this->actingAs($this->superAdmin)->put(route('admin.landing-pages.update', $page), [
            'title' => 'Software Landing',
            'slug' => $page->slug,
            'status' => 'published',
            'blocks' => $blocks
        ]);

        $response->assertRedirect();
        
        $updatedPage = $page->fresh();
        $this->assertEquals('<div>Safe HTML</div>', $updatedPage->blocks[0]['data']['content']);
    }

    public function test_guest_cannot_view_draft_landing_page()
    {
        $page = LandingPage::factory()->create(['status' => 'draft']);

        $response = $this->get(route('landing.show', $page->slug));

        $response->assertStatus(404);
    }

    public function test_guest_can_view_published_landing_page()
    {
        $page = LandingPage::factory()->create(['status' => 'published']);

        $response = $this->get(route('landing.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee($page->title); // Title is available via x-seo
    }

    public function test_super_admin_can_preview_draft_page()
    {
        $page = LandingPage::factory()->create(['status' => 'draft']);

        $response = $this->actingAs($this->superAdmin)->get(route('landing.show', ['slug' => $page->slug, 'preview' => 'true']));

        $response->assertStatus(200);
        $response->assertSee('PREVIEW');
    }
}
