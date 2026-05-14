<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
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
                'total'          => Customer::count(),
                'new_this_month' => Customer::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
                'with_orders'    => Customer::has('orders')->count(),
                'total_revenue'  => Customer::join('orders', 'customers.id', '=', 'orders.customer_id')->sum('orders.total_amount'),
            ];

            return view('admin.customers.index', compact('customers', 'stats'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.customers.index', [
                'customers' => collect(),
                'stats'     => ['total' => 0, 'new_this_month' => 0, 'with_orders' => 0, 'total_revenue' => 0],
                'error'     => 'Could not load customers.',
            ]);
        }
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        try {
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
                    'formatted_address' => $request->filled('formatted_address') ? $request->formatted_address : null,
                ];
            }

            Customer::create([
                'name'         => $validated['name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'] ?? null,
                'address'      => $validated['address'] ?? null,
                'map_location' => $mapLocation,
            ]);

            return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not create customer. Please try again.');
        }
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        try {
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
                    'formatted_address' => $request->filled('formatted_address') ? $request->formatted_address : null,
                ];
            }

            $customer->update([
                'name'         => $validated['name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'] ?? null,
                'address'      => $validated['address'] ?? null,
                'map_location' => $mapLocation,
            ]);

            return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['customer_id' => $customer->id]);
            return redirect()->back()->withInput()->with('error', 'Could not update customer. Please try again.');
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['customer_id' => $customer->id]);
            return redirect()->back()->with('error', 'Could not delete customer. Please try again.');
        }
    }

    public function show(Customer $customer)
    {
        try {
            $customer->load(['orders.items.product']);
            $totalSpent = $customer->orders->sum('total_amount');
            $orderCount = $customer->orders->count();

            return view('admin.customers.show', compact('customer', 'totalSpent', 'orderCount'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['customer_id' => $customer->id]);
            return redirect()->route('admin.customers.index')->with('error', 'Could not load customer details.');
        }
    }
}
