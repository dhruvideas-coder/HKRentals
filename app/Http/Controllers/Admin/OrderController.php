<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::with(['items', 'customer'])->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%")
                      ->orWhereRaw('LPAD(id, 5, "0") LIKE ?', ["%{$search}%"]);
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            $orders = $query->paginate(15)->withQueryString();

            $stats = [
                'all'       => Order::count(),
                'pending'   => Order::where('status', 'pending')->count(),
                'active'    => Order::where('status', 'active')->count(),
                'completed' => Order::where('status', 'completed')->count(),
            ];

            return view('admin.orders.index', compact('orders', 'stats'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.orders.index', [
                'orders' => collect(),
                'stats'  => ['all' => 0, 'pending' => 0, 'active' => 0, 'completed' => 0],
                'error'  => 'Could not load orders.',
            ]);
        }
    }

    public function show(Order $order)
    {
        try {
            $order->load(['items.product', 'customer', 'payment']);
            return view('admin.orders.show', compact('order'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['order_id' => $order->id]);
            return redirect()->route('admin.orders.index')->with('error', 'Could not load order details.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,active,completed,cancelled',
            ]);

            $order->update(['status' => $request->status]);

            return back()->with('success', 'Order status updated to ' . ucfirst($request->status) . '.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['order_id' => $order->id]);
            return back()->with('error', 'Could not update order status. Please try again.');
        }
    }
}
