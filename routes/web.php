<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', [\App\Http\Controllers\Frontend\SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [\App\Http\Controllers\Frontend\ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');

Route::get('/robots.txt', [\App\Http\Controllers\Frontend\RobotsController::class, 'index'])->name('robots.txt');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\LandingPageController as AdminLandingPageController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CMS Modules
    Route::resource('landing-pages', AdminLandingPageController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class)->except(['show']);
    
    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Redirects
    Route::resource('redirects', \App\Http\Controllers\Admin\RedirectController::class)->except(['show']);

    // Services & Products
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['show']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);

    // Menus
    Route::resource('menus', \App\Http\Controllers\Admin\NavigationMenuController::class)->except(['show', 'create']);
    Route::resource('menu-items', \App\Http\Controllers\Admin\NavigationMenuItemController::class)->only(['store', 'update', 'destroy']);
    Route::patch('menu-items/{menu_item}/toggle', [\App\Http\Controllers\Admin\NavigationMenuItemController::class, 'toggle'])->name('menu-items.toggle');

    // Media Library
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class)->except(['show', 'create', 'edit']);

    // Leads
    Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class)->except(['create', 'store']);

    // Subscribers
    Route::get('subscribers/export', [\App\Http\Controllers\Admin\SubscriberController::class, 'export'])->name('subscribers.export');
    Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'destroy']);
});

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\LeadController as FrontendLeadController;
use App\Http\Controllers\Frontend\NewsletterController;

Route::post('/leads', [FrontendLeadController::class, 'store'])->name('leads.store')->middleware('throttle:5,1');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe')->middleware('throttle:3,1');
Route::get('/newsletter/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/landing/{slug}', [FrontendLandingPageController::class, 'show'])->name('landing.show');

// Fallback Route for Dynamic Pages (Must be at the very bottom of the file)
Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('page.show')->where('slug', '.*');
