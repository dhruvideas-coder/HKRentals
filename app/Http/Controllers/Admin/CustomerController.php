<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(20)->withQueryString();

        $stats = [
            'total'           => Customer::count(),
            'new_this_month'  => Customer::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'with_orders'     => Customer::has('orders')->count(),
            'total_revenue'   => Customer::join('orders', 'customers.id', '=', 'orders.customer_id')->sum('orders.total_amount'),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.items.product']);
        $totalSpent = $customer->orders->sum('total_amount');
        $orderCount = $customer->orders->count();

        return view('admin.customers.show', compact('customer', 'totalSpent', 'orderCount'));
    }
}
