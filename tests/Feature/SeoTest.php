<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_seo_metadata_can_be_saved_to_post()
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $postData = [
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'content' => 'Content here',
            'status' => 'published',
            'seo' => [
                'meta_title' => 'Custom Meta Title',
                'meta_description' => 'Custom Meta Description',
                'robots' => 'noindex, nofollow'
            ],
            'author_id' => $user->id,
        ];

        $response = $this->actingAs($user)->post(route('admin.posts.store'), $postData);

        $response->assertRedirect();
        
        $post = Post::where('slug', 'test-post-title')->first();
        
        $this->assertNotNull($post);
        $this->assertNotNull($post->seoMetadata);
        $this->assertEquals('Custom Meta Title', $post->seoMetadata->meta_title);
        $this->assertEquals('Custom Meta Description', $post->seoMetadata->meta_description);
        $this->assertEquals('noindex, nofollow', $post->seoMetadata->robots);
    }

    public function test_frontend_renders_seo_component()
    {
        $post = Post::factory()->create([
            'title' => 'Frontend Render Title',
            'slug' => 'frontend-render-title',
            'content' => 'Content for frontend',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $post->syncSeo([
            'meta_title' => 'Specific SEO Title for Render',
            'meta_description' => 'Specific SEO description for render',
        ]);

        $response = $this->get(route('blog.show', 'frontend-render-title'));

        $response->assertStatus(200);
        $response->assertSee('<title>Specific SEO Title for Render - Musheeda Solutions</title>', false);
        $response->assertSee('name="description" content="Specific SEO description for render"', false);
    }
}
