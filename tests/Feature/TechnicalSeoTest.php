<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TechnicalSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_contains_published_content()
    {
        $page = Page::factory()->create(['status' => 'published']);
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);
        
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        
        $content = $response->getContent();
        $this->assertStringContainsString($page->slug, $content);
        $this->assertStringContainsString($post->slug, $content);
        $this->assertStringContainsString($category->slug, $content);
    }

    public function test_sitemap_excludes_noindex_content()
    {
        $page = Page::factory()->create(['status' => 'published']);
        $page->seoMetadata()->create([
            'robots' => 'noindex, nofollow'
        ]);

        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();

        $this->assertStringNotContainsString($page->slug, $content);
    }

    public function test_robots_txt()
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $this->assertStringContainsString('Disallow: /admin', $response->getContent());
        $this->assertStringContainsString('Sitemap: ' . url('/sitemap.xml'), $response->getContent());
    }

    public function test_trailing_slash_middleware_redirects()
    {
        $request = \Illuminate\Http\Request::create('http://localhost/about-us/', 'GET');
        
        // We have to mock the path info because Request::create can strip it
        $request->server->set('REQUEST_URI', '/about-us/');
        
        $middleware = new \App\Http\Middleware\TrailingSlashMiddleware();
        $response = $middleware->handle($request, function () {
            return response('ok', 200);
        });
        
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals('http://localhost/about-us', $response->headers->get('Location'));
    }

    public function test_redirect_manager_301()
    {
        Redirect::create([
            'old_url' => 'old-page',
            'new_url' => 'new-page',
            'status_code' => 301,
            'is_active' => true
        ]);

        $response = $this->get('/old-page');
        $response->assertStatus(301);
        $response->assertRedirect(url('/new-page'));
    }

    public function test_redirect_manager_410()
    {
        Redirect::create([
            'old_url' => 'deleted-page',
            'new_url' => '',
            'status_code' => 410,
            'is_active' => true
        ]);

        $response = $this->get('/deleted-page');
        $response->assertStatus(410);
    }

    public function test_redirect_manager_prevents_loops()
    {
        Redirect::create([
            'old_url' => 'loop-page',
            'new_url' => 'loop-page',
            'status_code' => 301,
            'is_active' => true
        ]);

        $response = $this->get('/loop-page');
        $response->assertStatus(404); // Should not redirect, should continue and hit 404
    }
}
