<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::prefix('products')->group(function () {

    Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');


    Route::get('/', [ProductController::class, 'index'])->name('products.list');
});


