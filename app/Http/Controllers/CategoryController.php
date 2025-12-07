<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;


// môžeš aj \App\Models\Category priamo v type

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
        // sem pôjde: $data = $request->validated(); Category::create($data); ...

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('succes', 'Cateogry created');
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

        return redirect()->route('categories.index')
            ->with('success', 'Category updated');
    }

    // DELETE /admin/categories/{category}
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted');
    }
}
