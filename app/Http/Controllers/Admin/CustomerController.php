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

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:customers,email',
            'phone'             => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:1000',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'formatted_address' => 'nullable|string|max:500',
        ]);

        $mapLocation = null;
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $mapLocation = [
                'lat'               => (float) $request->latitude,
                'lng'               => (float) $request->longitude,
                'formatted_address' => $request->filled('formatted_address')
                                        ? $request->formatted_address
                                        : null,
            ];
        }

        Customer::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'address'      => $validated['address'] ?? null,
            'map_location' => $mapLocation,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone'             => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:1000',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'formatted_address' => 'nullable|string|max:500',
        ]);

        $mapLocation = null;
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $mapLocation = [
                'lat'               => (float) $request->latitude,
                'lng'               => (float) $request->longitude,
                'formatted_address' => $request->filled('formatted_address')
                                        ? $request->formatted_address
                                        : null,
            ];
        }

        $customer->update([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'address'      => $validated['address'] ?? null,
            'map_location' => $mapLocation,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.items.product']);
        $totalSpent = $customer->orders->sum('total_amount');
        $orderCount = $customer->orders->count();

        return view('admin.customers.show', compact('customer', 'totalSpent', 'orderCount'));
    }
}
