<?php

use Illuminate\Support\Facades\Route;
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

        Route::get('/customers',          [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

        // Profile
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

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
