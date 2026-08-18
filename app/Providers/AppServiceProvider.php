<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
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
        $this->app->bind(
            \App\Contracts\NewsletterServiceInterface::class,
            \App\Services\Newsletter\DatabaseNewsletterService::class
        );
        $this->app->bind(
            \App\Contracts\SearchServiceInterface::class,
            \App\Services\Search\DatabaseSearchService::class
        );
        $this->app->singleton(\App\Services\SeoService::class);
        $this->app->singleton(\App\Services\ActivityLogger::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        \Illuminate\Support\Facades\RateLimiter::for('search', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(30)->by($request->ip());
        });

        View::composer('layouts.app', function ($view) {
            $view->with('headerServices', Service::active()->orderBy('sort_order')->take(5)->get());
            $view->with('headerProducts', Product::active()->latest()->take(5)->get());
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

        // Activity Logging Observers
        $observedModels = [
            \App\Models\Page::class,
            \App\Models\Post::class,
            \App\Models\Product::class,
            \App\Models\Service::class,
            \App\Models\Setting::class,
            \Spatie\Permission\Models\Role::class,
            \Spatie\Permission\Models\Permission::class,
        ];

        foreach ($observedModels as $modelClass) {
            if (class_exists($modelClass)) {
                $modelClass::observe(\App\Observers\ActivityLogObserver::class);
            }
        }

        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Login $event) {
            log_activity('login', $event->user);
        });

        \Illuminate\Support\Facades\Event::listen(function (\Illuminate\Auth\Events\Logout $event) {
            if ($event->user) {
                log_activity('logout', $event->user);
            }
        });
    }
}
