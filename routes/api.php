<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes - Produkty (JEDNODUCHE)
|--------------------------------------------------------------------------
*/

Route::prefix('products')->group(function () {
    // GET /api/products/filter?category_id=1&search=med
    Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');

    // GET /api/products - všetky produkty
    Route::get('/', [ProductController::class, 'index'])->name('products.list');
});

