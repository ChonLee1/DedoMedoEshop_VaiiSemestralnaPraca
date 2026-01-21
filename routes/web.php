<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// 1. DOMOV
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. PRODUKTY - Zoznam
Route::get('/products', function () {
    return view('products.index', [
        'products' => \App\Models\Product::where('is_active', true)->with('category')->get(),
        'categories' => \App\Models\Category::where('is_active', true)->get()
    ]);
})->name('products.index');

// 3. PRODUKT - Detail
Route::get('/products/{product}', function (\App\Models\Product $product) {
    return view('product-detail', compact('product'));
})->name('product.show');

// 4. KONTAKT
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 5. KOŠÍK/CHECKOUT
Route::get('/cart', function () {
    return view('cart');
})->name('cart.show');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.show');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// PRESMEROVANIE /admin na login alebo dashboard
Route::get('/admin', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
})->name('admin.index');

// LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
});

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// ADMIN PANEL (iba pre prihlásených adminov)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // AJAX endpoint pre štatistiky
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');

    // Správa produktov
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/products/{product}/toggle', [ProductController::class, 'toggleActive'])->name('admin.products.toggle');
    Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Správa kategórií
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('admin.categories');
    Route::post('/categories/{category}/toggle', [CategoryController::class, 'toggleActive'])->name('admin.categories.toggle');
    Route::post('/categories/create', [CategoryController::class, 'quickCreate'])->name('admin.categories.create');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

