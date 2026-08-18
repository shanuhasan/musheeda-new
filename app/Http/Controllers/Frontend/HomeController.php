<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Services\SeoService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(SeoService $seoService)
    {
        // Fetch active services (limit to 3 for homepage)
        $services = \Illuminate\Support\Facades\Cache::rememberForever('home.services', function () {
            return Service::active()->orderBy('sort_order')->take(3)->get();
        });
        
        // Fetch active products (limit to 3 for homepage)
        $products = \Illuminate\Support\Facades\Cache::rememberForever('home.products', function () {
            return Product::active()->latest()->take(3)->get();
        });
        
        // Fetch recent published posts (limit to 3)
        $posts = \Illuminate\Support\Facades\Cache::rememberForever('home.posts', function () {
            return Post::published()->latest('published_at')->take(3)->get();
        });

        // Set Default SEO for homepage
        $seoService->setDefaultSeo(
            setting('site_name', 'Musheeda Solutions') . ' - Custom Software & IT Services',
            setting('footer_about', 'Musheeda Solutions provides cutting edge IT services and software solutions.')
        );

        return view('frontend.home', compact('services', 'products', 'posts'));
    }
}
