<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('variants')->where('is_active', true)->get();

        return view('index', compact('products'));
    }
}
