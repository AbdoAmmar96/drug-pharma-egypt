<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Drug Pharma Egypt
|--------------------------------------------------------------------------
|
| All public API endpoints. Mount under /api prefix in bootstrap/app.php
| via withRouting(api: __DIR__ . '/../routes/api.php').
|
*/

Route::prefix('v1')->group(function () {
    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category:slug}', [CategoryController::class, 'show']);

    // Products
    Route::get('products/featured', [ProductController::class, 'featured']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product:slug}', [ProductController::class, 'show']);

    // Contact form
    Route::post('contact', [ContactController::class, 'store'])
        ->middleware('throttle:5,1'); // 5 submissions per minute per IP
});
