<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        try {
            $query = \App\Models\Product::with('category');

            if ($request->filled('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            if ($request->filled('max_price')) {
                $query->where('price_per_day', '<=', $request->max_price);
            }

            if ($request->filled('color')) {
                $query->where('color', $request->color);
            }

            if ($request->filled('material')) {
                $query->where('material', $request->material);
            }

            $sort = $request->get('sort', 'featured');
            match ($sort) {
                'price_low'  => $query->orderBy('price_per_day', 'asc'),
                'price_high' => $query->orderBy('price_per_day', 'desc'),
                'newest'     => $query->orderBy('created_at', 'desc'),
                default      => $query->orderBy('id', 'desc'),
            };

            $products         = $query->paginate(9)->withQueryString();
            $categories       = \App\Models\Category::all();
            $selectedCategory = $request->filled('category')
                ? \App\Models\Category::where('slug', $request->category)->first()
                : null;
            $colors    = \App\Models\Product::whereNotNull('color')->distinct()->orderBy('color')->pluck('color');
            $materials = \App\Models\Product::whereNotNull('material')->distinct()->orderBy('material')->pluck('material');

            return view('pages.products', compact('products', 'categories', 'colors', 'materials', 'selectedCategory'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('pages.products', [
                'products'         => collect(),
                'categories'       => collect(),
                'colors'           => collect(),
                'materials'        => collect(),
                'selectedCategory' => null,
                'error'            => 'Could not load products.',
            ]);
        }
    }

    public function show(string $slug): View
    {
        try {
            $product = \App\Models\Product::with('category')->where('slug', $slug)->firstOrFail();

            $related = \App\Models\Product::with('category')
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->where('status', 'available')
                ->limit(4)
                ->get();

            return view('pages.product-detail', compact('product', 'related'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['slug' => $slug]);
            abort(500);
        }
    }
}
