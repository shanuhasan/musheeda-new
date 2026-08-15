<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
use App\Http\Controllers\Frontend\PageController as FrontendPageController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CMS Modules
    Route::resource('pages', AdminPageController::class);
    
    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Menus
    Route::resource('menus', \App\Http\Controllers\Admin\NavigationMenuController::class)->except(['show', 'create']);
    Route::resource('menu-items', \App\Http\Controllers\Admin\NavigationMenuItemController::class)->only(['store', 'update', 'destroy']);
    Route::patch('menu-items/{menu_item}/toggle', [\App\Http\Controllers\Admin\NavigationMenuItemController::class, 'toggle'])->name('menu-items.toggle');
});

// Fallback Route for Dynamic Pages (Must be at the very bottom of the file)
Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('page.show')->where('slug', '.*');
