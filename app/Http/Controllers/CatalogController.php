<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function shop(Request $request)
    {
        $query = Product::with('variants')->where('is_active', true);

        // Filter by category slug if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by search query if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->get();
        $categories = Category::where('is_active', true)->get();

        return view('shop', compact('products', 'categories'));
    }

    public function product($id)
    {
        $product = Product::with(['variants', 'reviews.user'])->findOrFail($id);
        
        // Fetch related products (in same category, excluding current)
        $relatedProducts = Product::with('variants')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}
