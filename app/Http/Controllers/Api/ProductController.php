<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * GET /api/products
     * Vrať všetky aktívne produkty ako JSON
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('category')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price_eur' => number_format($product->price_cents / 100, 2),
                    'price_cents' => $product->price_cents,
                    'stock' => $product->stock,
                    'is_active' => $product->is_active,
                    'category' => $product->category?->name ?? 'Bez kategórie',
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * GET /api/products/filter?category_id=1&search=med
     * Filtruj produkty a vrať ako JSON
     */
    public function filter(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Filter podľa kategórie
        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter podľa vyhľadávania
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price_eur' => number_format($product->price_cents / 100, 2),
                'price_cents' => $product->price_cents,
                'stock' => $product->stock,
                'is_active' => $product->is_active,
                'category' => $product->category?->name ?? 'Bez kategórie',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}

