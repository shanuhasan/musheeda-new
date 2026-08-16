<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Models\Page;
use App\Models\Post;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        $clearSitemap = function () {
            Cache::forget('sitemap.xml');
        };

        Page::saved($clearSitemap);
        Page::deleted($clearSitemap);
        Post::saved($clearSitemap);
        Post::deleted($clearSitemap);
        Category::saved($clearSitemap);
        Category::deleted($clearSitemap);
        Product::saved($clearSitemap);
        Product::deleted($clearSitemap);
        Service::saved($clearSitemap);
        Service::deleted($clearSitemap);
    }
}
