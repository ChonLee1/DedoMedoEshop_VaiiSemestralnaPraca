<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function adminIndex()
    {
        $products = Product::with('category')->get();
        $categories = Category::where('is_active', true)->get();

        return view('admin-products', compact('products', 'categories'));
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Stav produktu bol zmenený');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_cents' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;

        Product::create($data);

        return back()->with('success', 'Produkt bol úspešne vytvorený!');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'price_cents' => ['sometimes', 'integer', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'category_id' => ['sometimes', 'nullable', 'exists:categories,id'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);


        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image']);

        $product->update($data);

        return back()->with('success', 'Produkt bol upravený.');
    }

    public function destroy(Product $product)
    {
        $imagePath = $product->image_path;

        $product->delete();

        if ($imagePath) {
            $otherProductsWithImage = Product::where('image_path', $imagePath)->count();

            if ($otherProductsWithImage === 0 && file_exists(storage_path('app/public/' . $imagePath))) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        return back()->with('success', 'Produkt bol zmazaný.');
    }
}
