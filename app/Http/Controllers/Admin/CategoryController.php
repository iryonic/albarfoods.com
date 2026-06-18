<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->with('parent')
            ->orderBy('name')
            ->get();

        $totalCategories = $categories->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $totalProducts = $categories->sum('products_count');

        return view('admin.categories', compact('categories', 'totalCategories', 'activeCategories', 'totalProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:255',
            'is_active'   => 'required|in:0,1',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Category::create([
            'parent_id'   => $request->parent_id ?: null,
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'image'       => $request->image,
            'is_active'   => $request->is_active,
        ]);

        return back()->with('success', "Category \"{$request->name}\" created successfully!");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:255',
            'is_active'   => 'required|in:0,1',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);

        if ($category->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $category->slug = $slug;
        }

        $category->parent_id   = $request->parent_id ?: null;
        $category->name        = $request->name;
        $category->description = $request->description;
        $category->is_active   = $request->is_active;
        if ($request->filled('image')) {
            $category->image = $request->image;
        }
        $category->save();

        return back()->with('success', "Category \"{$request->name}\" updated successfully!");
    }

    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return back()->with('error', "Cannot delete \"{$category->name}\" — it has {$category->products_count} product(s) assigned. Reassign them first.");
        }

        $category->delete();
        return back()->with('success', "Category \"{$category->name}\" deleted successfully.");
    }
}
