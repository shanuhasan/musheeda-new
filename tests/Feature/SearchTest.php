<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_loads()
    {
        $response = $this->get(route('search'));
        $response->assertStatus(200);
        $response->assertSee('Enter a search term');
    }

    public function test_search_finds_page_and_post()
    {
        $page = Page::factory()->create([
            'title' => 'Unique Searchable Page',
            'content' => 'Content here',
            'status' => 'published',
        ]);

        $post = Post::factory()->create([
            'title' => 'Unique Searchable Post',
            'content' => 'Content here',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('search', ['q' => 'Unique Searchable']));
        
        $response->assertStatus(200);
        $response->assertSee('Unique Searchable Page');
        $response->assertSee('Unique Searchable Post');
    }

    public function test_search_filters_by_type()
    {
        $page = Page::factory()->create([
            'title' => 'Another Unique Title',
            'status' => 'published',
        ]);

        $post = Post::factory()->create([
            'title' => 'Another Unique Title',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('search', ['q' => 'Another Unique Title', 'type' => 'page']));
        
        $response->assertStatus(200);
        $response->assertSee('Another Unique Title');
        
        $response->assertSee('page', false);
        $response->assertDontSee('>post<', false); // Post badge should be hidden
    }

    public function test_search_ignores_drafts()
    {
        $draftPage = Page::factory()->create([
            'title' => 'Secret Draft Item',
            'status' => 'draft',
        ]);

        $response = $this->get(route('search', ['q' => 'Secret Draft Item']));
        
        $response->assertStatus(200);
        $response->assertSee('No results found');
    }

    public function test_search_rate_limiting()
    {
        // Simulate hitting the endpoint 31 times
        for ($i = 0; $i < 30; $i++) {
            $this->get(route('search', ['q' => 'test']));
        }

        $response = $this->get(route('search', ['q' => 'test']));
        
        $response->assertStatus(429); // Too Many Requests
    }
}
