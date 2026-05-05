<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        $metrics = [
            'total_products' => \App\Models\Product::count(),
            'total_categories' => \App\Models\Category::count(),
            'total_orders' => \App\Models\Order::count(),
            'recent_products' => \App\Models\Product::with('category')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}
