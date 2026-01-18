<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * ADMIN: Zoznam produktov (zjednodušený)
     */
    public function adminIndex()
    {
        $products = Product::with('category')->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin-products', compact('products', 'categories'));
    }

    /**
     * ADMIN: Toggle aktívnosť produktu
     */
    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Stav produktu bol zmenený');
    }

    /**
     * ADMIN: Rýchla aktualizácia skladu
     */
    public function quickUpdate(Request $request, Product $product)
    {
        $request->validate(['stock' => 'required|integer|min:0']);
        $product->update(['stock' => $request->stock]);
        return back()->with('success', 'Sklad bol aktualizovaný');
    }

    /**
     * ADMIN: Vytvorenie nového produktu
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_cents' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        // Vytvor slug z názvu
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = true;

        Product::create($validated);

        return back()->with('success', 'Produkt bol úspešne vytvorený!');
    }
}
