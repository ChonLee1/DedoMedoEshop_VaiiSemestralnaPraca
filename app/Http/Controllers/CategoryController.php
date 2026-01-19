<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET /admin/categories
    public function index()
    {
        $categories = Category::latest()->paginate(10); // sem pôjde načítanie všetkých kategórií/
        return view('admin.categories.index', compact('categories')); // dočasne
    }

    // GET /admin/categories/create
    public function create()
    {
        return view('admin.categories.create');
    }

    // POST /admin/categories
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $data['is_active'] = (bool)($request->has('is_active') ?? false);

        Category::create($data);

        return redirect()->route('admin.categories')
            ->with('success', 'Category created');
    }

    // GET /admin/categories/{category}/edit
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // dočasne
    }

    // PUT/PATCH /admin/categories/{category}
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['is_active'] = (bool)($request->has('is_active') ?? false);

        $category->update($data);

        return redirect()->route('admin.categories')
            ->with('success', 'Category updated');
    }

    // DELETE /admin/categories/{category}
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Category deleted');
    }

    /**
     * ADMIN: Zoznam kategórií (zjednodušený)
     */
    public function adminIndex()
    {
        $categories = Category::withCount('products')->get();
        return view('admin-categories', compact('categories'));
    }

    /**
     * ADMIN: Toggle aktívnosť kategórie
     */
    public function toggleActive(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Stav kategórie bol zmenený');
    }

    /**
     * ADMIN: Rýchle vytvorenie kategórie
     */
    public function quickCreate(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories']);

        Category::create([
            'name' => $request->name,
            'slug' => str()->slug($request->name),
            'is_active' => true,
        ]);

        return back()->with('success', 'Kategória bola vytvorená');
    }
}
