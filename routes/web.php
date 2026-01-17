<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HarvestBatchController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', function () {
    return view('products.index', [
        'categories' => \App\Models\Category::where('is_active', true)->get()
    ]);
})->name('products.index');
Route::view('/checkout', 'checkout')->name('checkout.show');
Route::get('/harvests', [HarvestBatchController::class, 'index'])->name('harvests.index');
Route::get('/harvests/{harvestBatch}', [HarvestBatchController::class, 'show'])->name('harvests.show');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('products', ProductController::class)->names('products');
});

