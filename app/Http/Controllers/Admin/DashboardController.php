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
        // TODO: Pass real metrics (orders, revenue, active rentals, customers)
        return view('admin.dashboard');
    }
}
