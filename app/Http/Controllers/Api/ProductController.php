<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//Pomoc s AI
class ProductController
{
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

                    'image_path' => $product->image_path,
                    'image_url' => $product->image_path ? Storage::url($product->image_path) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function filter(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('category_id', $request->category_id);
        }

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
