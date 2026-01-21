<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// API controller pre AJAX volania z frontendu (api.js)
class ProductController
{
    // GET /api/products - vrati vsetky aktivne produkty ako JSON
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('category')  // eager load aby sa nevolalo N+1 queries
            ->get()
            ->map(function ($product) {
                // transformuj na format pre frontend
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price_eur' => number_format($product->price_cents / 100, 2),
                    'price_cents' => $product->price_cents,
                    'stock' => $product->stock,
                    'is_active' => $product->is_active,
                    'category' => $product->category?->name ?? 'Bez kategórie',
                    'image_path' => $product->image_path,
                    'image_url' => $product->image_path ? Storage::url($product->image_path) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    // GET /api/products/filter?category_id=X&search=Y
    // volane z api.js ked user zmeni filter alebo pise do hladania
    public function filter(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // filter podla kategorie (select v products/index.blade.php)
        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('category_id', $request->category_id);
        }

        // fulltext hladanie v nazve a popise (input v products/index.blade.php)
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // rovnaka transformacia ako v index()
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
                'image_path' => $product->image_path,
                'image_url' => $product->image_path ? Storage::url($product->image_path) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
