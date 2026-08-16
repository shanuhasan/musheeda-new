<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap.xml', now()->addHours(24), function () {
            // Home page is always included
            $urls = [
                [
                    'loc' => url('/'),
                    'lastmod' => now()->toAtomString(),
                    'changefreq' => 'daily',
                    'priority' => '1.0'
                ]
            ];

            // Pages
            $pages = Page::where('status', 'published')->with('seoMetadata')->get();
            foreach ($pages as $page) {
                if ($this->isNoIndex($page)) continue;
                $urls[] = [
                    'loc' => url('/' . $page->slug),
                    'lastmod' => $page->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8'
                ];
            }

            // Posts
            $posts = Post::published()->with('seoMetadata')->get();
            foreach ($posts as $post) {
                if ($this->isNoIndex($post)) continue;
                $urls[] = [
                    'loc' => route('blog.show', $post->slug),
                    'lastmod' => $post->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7'
                ];
            }

            // Categories
            $categories = Category::with('seoMetadata')->get();
            foreach ($categories as $category) {
                if ($this->isNoIndex($category)) continue;
                $urls[] = [
                    'loc' => route('blog.category', $category->slug),
                    'lastmod' => $category->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6'
                ];
            }

            // Products
            $products = Product::whereIn('status', ['active', 'discontinued'])->with('seoMetadata')->get();
            foreach ($products as $product) {
                if ($this->isNoIndex($product)) continue;
                $urls[] = [
                    'loc' => route('products.show', $product->slug),
                    'lastmod' => $product->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.9'
                ];
            }

            // Services
            $services = Service::active()->with('seoMetadata')->get();
            foreach ($services as $service) {
                if ($this->isNoIndex($service)) continue;
                $urls[] = [
                    'loc' => route('services.show', $service->slug),
                    'lastmod' => $service->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.9'
                ];
            }

            return view('frontend.sitemap.xml', compact('urls'))->render();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function isNoIndex($model)
    {
        if ($model->seoMetadata && $model->seoMetadata->robots) {
            return Str::contains(strtolower($model->seoMetadata->robots), 'noindex');
        }
        return false;
    }
}
