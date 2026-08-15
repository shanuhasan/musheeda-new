<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;

class DashboardStatsService
{
    /**
     * Cache duration in minutes.
     */
    protected const CACHE_TTL = 5;

    public function getMetrics(): array
    {
        return [
            'pages' => [
                'total' => Cache::remember('dashboard.pages.total', self::CACHE_TTL * 60, fn() => Page::count()),
                'published' => Cache::remember('dashboard.pages.published', self::CACHE_TTL * 60, fn() => Page::where('status', 'published')->count()),
                'draft' => Cache::remember('dashboard.pages.draft', self::CACHE_TTL * 60, fn() => Page::where('status', 'draft')->count()),
            ],
            'posts' => [
                'total' => Cache::remember('dashboard.posts.total', self::CACHE_TTL * 60, fn() => Post::count()),
                'published' => Cache::remember('dashboard.posts.published', self::CACHE_TTL * 60, fn() => Post::where('status', 'published')->count()),
            ],
            'products' => [
                'total' => Cache::remember('dashboard.products.total', self::CACHE_TTL * 60, fn() => Product::count()),
            ],
            'leads' => [
                'total' => Cache::remember('dashboard.leads.total', self::CACHE_TTL * 60, fn() => ContactSubmission::count()),
                'new' => Cache::remember('dashboard.leads.new', self::CACHE_TTL * 60, fn() => ContactSubmission::where('status', 'new')->count()),
            ],
            'subscribers' => [
                'total' => Cache::remember('dashboard.subscribers.total', self::CACHE_TTL * 60, fn() => NewsletterSubscriber::count()),
            ]
        ];
    }

    public function getRecentData(): array
    {
        // Don't cache lists to keep dashboard fresh, or cache for a very short time.
        // We will just use optimized eager loading and limits.
        return [
            'recent_contacts' => ContactSubmission::latest()->take(5)->get(),
            'recent_posts' => Post::with('author')->latest()->take(5)->get(),
            'recent_activities' => ActivityLog::with('user')->latest()->take(10)->get(),
        ];
    }
}
