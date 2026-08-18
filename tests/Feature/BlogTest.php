<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_create_post()
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Test Blog Post',
            'content' => '<p>This is a test post.</p>',
            'status' => 'published',
            'published_at' => now(),
            'author_id' => $admin->id,
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
        ]);
    }

    public function test_guest_cannot_create_post()
    {
        $response = $this->post(route('admin.posts.store'), [
            'title' => 'Test Blog Post',
            'content' => '<p>This is a test post.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_frontend_shows_published_posts()
    {
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('blog.index'));
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_frontend_hides_drafts_and_future_posts()
    {
        $draft = Post::factory()->create(['status' => 'draft']);
        $future = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDays(2),
        ]);

        $response = $this->get(route('blog.index'));
        $response->assertStatus(200);
        $response->assertDontSee($draft->title);
        $response->assertDontSee($future->title);
    }

    public function test_single_post_is_accessible()
    {
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('blog.show', $post->slug));
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }
}
