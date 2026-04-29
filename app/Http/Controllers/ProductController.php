<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the product catalogue listing.
     */
    public function index(Request $request): View
    {
        $query = \App\Models\Product::with('category')->where('status', 'available');

        if ($request->has('category') && $request->category !== '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('max_price') && $request->max_price !== '') {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $products = $query->get();
        $categories = \App\Models\Category::all();

        return view('pages.products', compact('products', 'categories'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(string $slug): View
    {
        $product = \App\Models\Product::with('category')->where('slug', $slug)->firstOrFail();
        return view('pages.product-detail', compact('product'));
    }
}
