<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the product catalogue listing.
     */
    public function index(): View
    {
        // TODO: Fetch products from DB when Product model is set up
        return view('pages.products');
    }

    /**
     * Show a single product detail page.
     */
    public function show(int $id): View
    {
        // TODO: Fetch product by ID
        return view('pages.product-detail', compact('id'));
    }
}
