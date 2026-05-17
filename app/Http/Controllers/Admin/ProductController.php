<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        try {
            $query = Product::with('category');

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('color')) {
                $query->where('color', $request->color);
            }

            if ($request->filled('material')) {
                $query->where('material', $request->material);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $products   = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
            $categories = Category::all();
            $colors     = Product::whereNotNull('color')->distinct()->pluck('color');
            $materials  = Product::whereNotNull('material')->distinct()->pluck('material');

            return view('admin.products.index', compact('products', 'categories', 'colors', 'materials'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.products.index', [
                'products'   => collect(),
                'categories' => collect(),
                'colors'     => collect(),
                'materials'  => collect(),
                'error'      => 'Could not load products.',
            ]);
        }
    }

    public function create(): View
    {
        try {
            $categories = Category::all();
            return view('admin.products.create', compact('categories'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.products.create', ['categories' => collect(), 'error' => 'Could not load form data.']);
        }
    }

    public function edit(Product $product): View
    {
        try {
            $categories = Category::all();
            $product->load('images');
            return view('admin.products.edit', compact('product', 'categories'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.products.edit', ['product' => $product, 'categories' => collect(), 'error' => 'Could not load form data.']);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id'      => 'required|exists:categories,id',
                'name'             => 'required|string|max:255',
                'description'      => 'nullable|string',
                'price_per_day'    => 'required|numeric|min:0',
                'total_quantity'   => 'required|integer|min:0',
                'color'            => 'nullable|string|max:100',
                'material'         => 'nullable|string|max:100',
                'status'           => 'required|string|in:available,unavailable',
                'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'spec_keys'        => 'nullable|array|max:20',
                'spec_keys.*'      => 'nullable|string|max:100',
                'spec_values'      => 'nullable|array|max:20',
                'spec_values.*'    => 'nullable|string|max:500',
                'gallery_images'   => 'nullable|array|max:8',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);

            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
            $validated['product_specification'] = $this->buildSpecs($request);

            unset($validated['spec_keys'], $validated['spec_values'], $validated['gallery_images']);

            $path = public_path('images/products');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                Image::read($file)->scaleDown(width: 800)->toWebp(75)->save($path . '/' . $filename);
                $validated['image'] = 'images/products/' . $filename;
            }

            $product = Product::create($validated);

            $this->storeGalleryImages($request, $product, $path);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not create product. Please try again.');
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'category_id'        => 'required|exists:categories,id',
                'name'               => 'required|string|max:255',
                'description'        => 'nullable|string',
                'price_per_day'      => 'required|numeric|min:0',
                'total_quantity'     => 'required|integer|min:0',
                'color'              => 'nullable|string|max:100',
                'material'           => 'nullable|string|max:100',
                'status'             => 'required|string|in:available,unavailable',
                'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'spec_keys'          => 'nullable|array|max:20',
                'spec_keys.*'        => 'nullable|string|max:100',
                'spec_values'        => 'nullable|array|max:20',
                'spec_values.*'      => 'nullable|string|max:500',
                'gallery_images'     => 'nullable|array|max:8',
                'gallery_images.*'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'delete_image_ids'   => 'nullable|array',
                'delete_image_ids.*' => 'nullable|integer',
            ]);

            if ($request->name !== $product->name) {
                $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
            }

            $validated['product_specification'] = $this->buildSpecs($request);
            unset($validated['spec_keys'], $validated['spec_values'], $validated['gallery_images'], $validated['delete_image_ids']);

            $path = public_path('images/products');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            if ($request->hasFile('image')) {
                if ($product->image && File::exists(public_path($product->image))) {
                    File::delete(public_path($product->image));
                }
                $file     = $request->file('image');
                $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                Image::read($file)->scaleDown(width: 800)->toWebp(75)->save($path . '/' . $filename);
                $validated['image'] = 'images/products/' . $filename;
            }

            // Delete gallery images marked for removal
            if ($request->filled('delete_image_ids')) {
                $toDelete = ProductImage::whereIn('id', $request->delete_image_ids)
                    ->where('product_id', $product->id)
                    ->get();
                foreach ($toDelete as $img) {
                    if (File::exists(public_path($img->image))) {
                        File::delete(public_path($img->image));
                    }
                    $img->delete();
                }
            }

            $product->update($validated);

            $this->storeGalleryImages($request, $product, $path, $product->images()->count());

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            foreach ($product->images as $img) {
                if (File::exists(public_path($img->image))) {
                    File::delete(public_path($img->image));
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->with('error', 'Could not delete product. Please try again.');
        }
    }

    private function buildSpecs(Request $request): ?array
    {
        $keys   = $request->input('spec_keys', []);
        $values = $request->input('spec_values', []);
        $specs  = [];

        foreach ($keys as $i => $key) {
            $key = trim((string) $key);
            if ($key !== '') {
                $specs[$key] = trim((string) ($values[$i] ?? ''));
            }
        }

        return !empty($specs) ? $specs : null;
    }

    private function storeGalleryImages(Request $request, Product $product, string $path, int $offset = 0): void
    {
        if (!$request->hasFile('gallery_images')) {
            return;
        }

        foreach ($request->file('gallery_images') as $i => $file) {
            $filename = time() . '_g' . ($offset + $i) . '_' . Str::random(6) . '.webp';
            Image::read($file)->scaleDown(width: 800)->toWebp(75)->save($path . '/' . $filename);
            $product->images()->create([
                'image'      => 'images/products/' . $filename,
                'sort_order' => $offset + $i,
            ]);
        }
    }
}
