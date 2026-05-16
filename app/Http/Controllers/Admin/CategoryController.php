<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class CategoryController extends Controller
{
    public function index(): View
    {
        try {
            $categories = Category::withCount('products')->latest()->get();
            return view('admin.categories.index', compact('categories'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.categories.index', ['categories' => collect(), 'error' => 'Could not load categories.']);
        }
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'icon'        => 'nullable|string|max:10',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);

            $validated['slug'] = Str::slug($validated['name']);

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                $path     = public_path('images/categories');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                Image::read($file)->scaleDown(width: 800)->toWebp(75)->save($path . '/' . $filename);

                $validated['image'] = 'images/categories/' . $filename;
            }

            Category::create($validated);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not create category. Please try again.');
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'icon'        => 'nullable|string|max:10',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);

            if ($request->name !== $category->name) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            if ($request->hasFile('image')) {
                if ($category->image && File::exists(public_path($category->image))) {
                    File::delete(public_path($category->image));
                }

                $file     = $request->file('image');
                $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                $path     = public_path('images/categories');

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                Image::read($file)->scaleDown(width: 800)->toWebp(75)->save($path . '/' . $filename);

                $validated['image'] = 'images/categories/' . $filename;
            }

            $category->update($validated);

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not update category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->with('error', 'Could not delete category. Please try again.');
        }
    }

    public function showAssignProducts(Request $request, Category $category)
    {
        try {
            $search    = trim($request->query('search', ''));
            $filterCat = $request->query('filter_category', '');

            $query = Product::with('category')->orderBy('id', 'desc');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if (is_numeric($filterCat) && (int) $filterCat > 0) {
                $query->where('category_id', (int) $filterCat);
            }

            $products      = $query->paginate(10)->withQueryString();
            $allCategories = \App\Models\Category::orderBy('name', 'asc')->get();
            $total         = Product::count();

            return view('admin.categories.assign-products', compact(
                'category', 'products', 'allCategories', 'search', 'filterCat', 'total'
            ));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.categories.index')
                ->with('error', 'Could not load products for assignment.');
        }
    }

    public function assignProducts(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'product_ids'   => 'required|array|min:1',
                'product_ids.*' => 'integer|exists:products,id',
            ]);

            $count = Product::whereIn('id', $validated['product_ids'])
                ->update(['category_id' => $category->id]);

            $label = Str::plural('product', $count);

            return redirect()->route('admin.categories.index')
                ->with('success', "{$count} {$label} assigned to \"{$category->name}\" successfully.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->with('error', 'Could not assign products. Please try again.');
        }
    }
}
