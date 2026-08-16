<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_correctly_and_displays_dynamic_content()
    {
        // Create active and inactive items
        $activeService = Service::factory()->create(['status' => 'active', 'name' => 'Active Service Name']);
        $inactiveService = Service::factory()->create(['status' => 'draft', 'name' => 'Inactive Service Name']);

        $activeProduct = Product::factory()->create(['status' => 'active', 'name' => 'Active Product Name']);
        $inactiveProduct = Product::factory()->create(['status' => 'draft', 'name' => 'Inactive Product Name']);

        $publishedPost = Post::factory()->create(['status' => 'published', 'title' => 'Published Post Title', 'published_at' => now()]);
        $draftPost = Post::factory()->create(['status' => 'draft', 'title' => 'Draft Post Title']);

        $response = $this->get('/');

        $response->assertStatus(200);

        // Check if active items are visible
        $response->assertSee($activeService->name);
        $response->assertSee($activeProduct->name);
        $response->assertSee($publishedPost->title);

        // Check if inactive items are NOT visible
        $response->assertDontSee($inactiveService->name);
        $response->assertDontSee($inactiveProduct->name);
        $response->assertDontSee($draftPost->title);
    }
}
