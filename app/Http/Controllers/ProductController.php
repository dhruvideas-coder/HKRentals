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
        $query = \App\Models\Product::with('category');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by price
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        // Filter by material
        if ($request->filled('material')) {
            $query->where('material', $request->material);
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc'); // Featured/Default
                break;
        }

        $products  = $query->paginate(9)->withQueryString();
        $categories = \App\Models\Category::all();

        // Distinct color & material values for filter dropdowns
        $colors    = \App\Models\Product::whereNotNull('color')->distinct()->orderBy('color')->pluck('color');
        $materials = \App\Models\Product::whereNotNull('material')->distinct()->orderBy('material')->pluck('material');

        return view('pages.products', compact('products', 'categories', 'colors', 'materials'));
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
