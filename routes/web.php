<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/',          [HomeController::class,    'index'])->name('home');
Route::get('/products',  [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show')->where('id', '[0-9]+');
Route::get('/about',     [AboutController::class,   'index'])->name('about');
Route::get('/contact',   [ContactController::class, 'index'])->name('contact');
Route::post('/contact',  [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Protected by auth middleware — swap 'auth' for your custom guard later.
*/

Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['auth', 'role:admin'])   // Uncomment when auth is set up
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Future admin resource routes go here:
        // Route::resource('products', Admin\ProductController::class);
        // Route::resource('orders', Admin\OrderController::class);
        // Route::resource('customers', Admin\CustomerController::class);

    });

/*
|--------------------------------------------------------------------------
| Logout (placeholder — wire to real Auth controller later)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
