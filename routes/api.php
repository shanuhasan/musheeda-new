<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ContactSubmissionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// V1 API Routes
Route::prefix('v1')->name('api.v1.')->group(function () {
    
    // Public Routes
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);
    Route::apiResource('services', ServiceController::class)->only(['index', 'show']);
    Route::apiResource('posts', PostController::class)->only(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
    
    Route::post('contact', [ContactSubmissionController::class, 'store']);

    // Protected Routes (Example)
    Route::middleware('auth:sanctum')->group(function () {
        // Add protected routes here in the future
    });
});
