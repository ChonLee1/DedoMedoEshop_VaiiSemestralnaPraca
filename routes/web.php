<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/products', 'products.index')->name('products.index');
Route::view('/checkout', 'checkout')->name('checkout.show');
