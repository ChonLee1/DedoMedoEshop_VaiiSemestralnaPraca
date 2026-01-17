<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * GET /
     * Úvodná stránka s vybranými produktami
     */
    public function index()
    {
        // Načítame 6 aktívnych produktov s kategóriami
        $products = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('products'));
    }
}

