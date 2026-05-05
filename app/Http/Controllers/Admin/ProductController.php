<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Color Filter
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        // Material Filter
        if ($request->filled('material')) {
            $query->where('material', $request->material);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        
        $categories = Category::all();
        $colors = Product::whereNotNull('color')->distinct()->pluck('color');
        $materials = Product::whereNotNull('material')->distinct()->pluck('material');

        return view('admin.products.index', compact('products', 'categories', 'colors', 'materials'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'total_quantity' => 'required|integer|min:0',
            'color' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:100',
            'status' => 'required|string|in:available,unavailable',
            'image' => 'nullable|image|max:2048',
        ]);

        if (!$request->has('slug')) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $path = public_path('images/products');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            Image::read($file)
                ->scaleDown(width: 800)
                ->toWebp(75)
                ->save($path . '/' . $filename);

            $validated['image'] = 'images/products/' . $filename;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'total_quantity' => 'required|integer|min:0',
            'color' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:100',
            'status' => 'required|string|in:available,unavailable',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('image')) {
            // Delete old image from public/images/products if it exists
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $path = public_path('images/products');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            Image::read($file)
                ->scaleDown(width: 800)
                ->toWebp(75)
                ->save($path . '/' . $filename);

            $validated['image'] = 'images/products/' . $filename;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete image file if it exists
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
