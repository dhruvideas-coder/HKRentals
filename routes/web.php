<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/',          [HomeController::class,    'index'])->name('home');
Route::get('/products',  [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/about',     [AboutController::class,   'index'])->name('about');
Route::get('/contact',   [ContactController::class, 'index'])->name('contact');
Route::post('/contact',  [ContactController::class, 'send'])->name('contact.send');
Route::get('/reviews',   fn () => view('pages.reviews'))->name('reviews');
Route::get('/events',    fn () => view('pages.events'))->name('events');
Route::get('/gallery',   fn () => view('pages.gallery'))->name('gallery');

// Cart & Checkout
Route::get('/cart',          [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/data',     [\App\Http\Controllers\CartController::class, 'data'])->name('cart.data');
Route::post('/cart/add',     [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',  [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',  [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear',   [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout',      [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order-success', fn () => view('pages.order-success'))->name('order.success');

// Mock Payment Routes
Route::post('/payment/create-intent', [\App\Http\Controllers\PaymentController::class, 'createIntent'])->name('payment.create-intent');
Route::post('/payment/confirm',       [\App\Http\Controllers\PaymentController::class, 'confirm'])->name('payment.confirm');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Public — no middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Login page
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');

    // Google OAuth flow
    Route::get('/auth/google',          [AdminAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected — admin middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Catalogue
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::get('products-list', fn() => redirect()->route('admin.products.index'))->name('products'); // Alias

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::get('categories-list', fn() => redirect()->route('admin.categories.index'))->name('categories'); // Alias

        // Business
        Route::get('/orders',            [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}',    [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

        Route::get('/customers',                       [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create',              [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers',                    [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}',          [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/customers/{customer}/edit',     [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}',          [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}',       [CustomerController::class, 'destroy'])->name('customers.destroy');

        // Profile
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    });



/*
|--------------------------------------------------------------------------
| Production Image Fixer (for Shared Hosting without Symlink support)
|--------------------------------------------------------------------------
*/
Route::get('/fix-images', function () {
    $results = [];

    // ── Helper: ensure directory exists ──────────────────────────────
    $ensureDir = function (string $dir) use (&$results) {
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
            $results[] = "Created directory: {$dir}";
        }
    };

    // ── 1. Products ───────────────────────────────────────────────────
    $productsPublic  = public_path('images/products');
    $productsStorage = storage_path('app/public/products');
    $ensureDir($productsPublic);

    // 1a. Move any files still sitting in storage/app/public/products
    if (File::exists($productsStorage)) {
        foreach (File::files($productsStorage) as $file) {
            $dest = $productsPublic . '/' . $file->getFilename();
            if (!File::exists($dest)) {
                File::copy($file->getRealPath(), $dest);
                $results[] = "Moved product image: {$file->getFilename()}";
            } else {
                $results[] = "Already in public, removed duplicate: {$file->getFilename()}";
            }
            File::delete($file->getRealPath());
        }
    }

    // 1b. Fix DB records: bare filename → images/products/filename
    $bareCount = \App\Models\Product::whereNotNull('image')
        ->where('image', 'not like', 'images/%')
        ->where('image', 'not like', 'storage/%')
        ->where('image', 'not like', 'http%')
        ->get()
        ->each(function ($p) {
            $p->image = 'images/products/' . $p->image;
            $p->save();
        })->count();
    $results[] = "Products — fixed {$bareCount} bare-filename records";

    // 1c. Fix DB records: storage/products/… → images/products/…
    $storageCount = \App\Models\Product::where('image', 'like', 'storage/products/%')
        ->orWhere('image', 'like', 'storage/%')
        ->get()
        ->each(function ($p) {
            // storage/app/public/products/x.webp  OR  storage/products/x.webp
            $p->image = preg_replace('#storage(/app/public)?/products/#', 'images/products/', $p->image);
            $p->save();
        })->count();
    $results[] = "Products — fixed {$storageCount} storage-path records";

    // ── 2. Categories ─────────────────────────────────────────────────
    $categoriesPublic  = public_path('images/categories');
    $categoriesStorage = storage_path('app/public/categories');
    $ensureDir($categoriesPublic);

    if (File::exists($categoriesStorage)) {
        foreach (File::files($categoriesStorage) as $file) {
            $dest = $categoriesPublic . '/' . $file->getFilename();
            if (!File::exists($dest)) {
                File::copy($file->getRealPath(), $dest);
                $results[] = "Moved category image: {$file->getFilename()}";
            } else {
                $results[] = "Already in public, removed duplicate: {$file->getFilename()}";
            }
            File::delete($file->getRealPath());
        }
    }

    $catBareCount = \App\Models\Category::whereNotNull('image')
        ->where('image', 'not like', 'images/%')
        ->where('image', 'not like', 'storage/%')
        ->where('image', 'not like', 'http%')
        ->get()
        ->each(function ($c) {
            $c->image = 'images/categories/' . $c->image;
            $c->save();
        })->count();
    $results[] = "Categories — fixed {$catBareCount} bare-filename records";

    $catStorageCount = \App\Models\Category::where('image', 'like', 'storage/categories/%')
        ->orWhere('image', 'like', 'storage/%')
        ->get()
        ->each(function ($c) {
            $c->image = preg_replace('#storage(/app/public)?/categories/#', 'images/categories/', $c->image);
            $c->save();
        })->count();
    $results[] = "Categories — fixed {$catStorageCount} storage-path records";

    // ── 3. Summary ────────────────────────────────────────────────────
    $results[] = "Done. Refresh the admin panel to see images.";

    return response()->json($results, 200, [], JSON_PRETTY_PRINT);
});

/*
|--------------------------------------------------------------------------
| Legacy Logout (kept for compatibility)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
