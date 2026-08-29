<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        return view('dashboard.category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);

        Category::create($request->all());
        toast('Category created Successfully', 'success', 'top-right');
        return redirect()->route('category.index');
    }

    public function show(Category $category): void
    {
        //
    }

    public function edit(Category $category): View
    {
        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->id,
        ]);

        $category->update($request->all());
        toast('Category Updated Successfully', 'success', 'top-right');
        return redirect()->route('category.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        toast('Category deleted Successfully', 'error', 'top-right');
        return redirect()->route('category.index');
    }
}
