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
            $query = Order::with(['items.product', 'customer', 'payment'])->latest();

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

            if ($request->export === 'csv') {
                return $this->exportCsv($query->get());
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

    private function exportCsv($orders)
    {
        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        $columns = [
            'Order ID', 'Order Date', 'Event Date', 'Status',
            'Customer Name', 'Customer Email', 'Customer Phone', 'Customer Address',
            'Product Name', 'Product Qty', 'Price/Day (₹)', 'Rental Start', 'Rental End', 'Rental Days', 'Line Total (₹)',
            'Traveling Cost ($)', 'Distance (mi)',
            'Order Total (₹)',
            'Payment Status', 'Payment Method', 'Payment Amount (₹)', 'Payment Reference',
        ];

        $callback = function () use ($orders, $columns) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, $columns);

            foreach ($orders as $order) {
                $payment = $order->payment;
                $items   = $order->items;

                $baseRow = [
                    $order->formatted_id,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->event_date ? \Carbon\Carbon::parse($order->event_date)->format('d/m/Y') : '',
                    ucfirst($order->status),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->customer_address,
                ];

                $orderTail = [
                    number_format($order->traveling_cost ?? 0, 2),
                    number_format($order->distance_miles ?? 0, 2),
                    number_format($order->total_amount, 2),
                    $payment ? ucfirst($payment->status) : 'Unpaid',
                    $payment ? ucfirst($payment->payment_method ?? '') : '',
                    $payment ? number_format($payment->amount, 2) : '',
                    $payment ? ($payment->payment_intent_id ?? '') : '',
                ];

                if ($items->isEmpty()) {
                    fputcsv($handle, array_merge($baseRow, ['', '', '', '', '', '', ''], $orderTail));
                    continue;
                }

                foreach ($items as $index => $item) {
                    $itemRow = [
                        $item->product->name ?? 'N/A',
                        $item->quantity,
                        number_format($item->price_per_day, 2),
                        $item->start_date ? $item->start_date->format('d/m/Y') : '',
                        $item->end_date   ? $item->end_date->format('d/m/Y')   : '',
                        $item->rental_days,
                        number_format($item->line_total, 2),
                    ];

                    // Only repeat order-level tail on the first item row
                    fputcsv($handle, array_merge(
                        $baseRow,
                        $itemRow,
                        $index === 0 ? $orderTail : ['', '', '', '', '', '', '']
                    ));
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
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

    public function receipt(Order $order)
    {
        try {
            $order->load(['items.product', 'payment', 'customer']);
            $settings = \App\Models\Setting::first();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.order-receipt', compact('order', 'settings'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Receipt-' . $order->formatted_id . '.pdf');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['order_id' => $order->id]);
            return back()->with('error', 'Could not generate receipt. Please try again.');
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

    public function create()
    {
        try {
            $categories = \App\Models\Category::with([
                'products' => fn($q) => $q->where('status', 'available')->select('id', 'name', 'price_per_day', 'image', 'total_quantity', 'category_id')->orderBy('name')
            ])->orderBy('name')->get();

            $customers = \App\Models\Customer::orderBy('name')->select('id', 'name', 'email', 'phone', 'address', 'map_location')->get();
            $settings = \App\Models\Setting::first();

            // Transform products for Alpine.js
            $allProducts = [];
            foreach ($categories as $category) {
                foreach ($category->products as $product) {
                    $allProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price_per_day' => (float) $product->price_per_day,
                        'image' => $product->image,
                        'total_quantity' => $product->total_quantity,
                        'category_id' => $product->category_id,
                    ];
                }
            }

            $categoriesForJS = $categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->values()->all();

            return view('admin.orders.create', compact('categories', 'customers', 'settings', 'allProducts', 'categoriesForJS'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.orders.index')->with('error', 'Could not load create order form.');
        }
    }

    public function productsByCategory(Request $request)
    {
        try {
            $query = \App\Models\Product::query();

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $products = $query->where('status', 'available')
                ->orderBy('name')
                ->get(['id', 'name', 'price_per_day', 'image', 'total_quantity', 'category_id']);

            return response()->json($products);
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json([], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            \Log::info('BookOrder - Received form data:', $request->all());

            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'rental_start_date' => 'required|date',
                'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.start_date' => 'required|date',
                'items.*.end_date' => 'required|date|after_or_equal:items.*.start_date',
                'payment_status' => 'required|in:pending,paid,waived',
                'payment_method' => 'nullable|in:cash,bank_transfer,card,other',
                'payment_amount' => 'nullable|numeric|min:0',
                'payment_reference' => 'nullable|string',
                'traveling_cost' => 'nullable|numeric|min:0',
                'distance_miles' => 'nullable|numeric|min:0',
            ]);

            \Log::info('BookOrder - Validation passed');

            // Stock validation
            foreach ($request->items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);
                if ($item['quantity'] > $product->total_quantity) {
                    return back()->withInput()->with('error',
                        "Cannot order {$item['quantity']} of \"{$product->name}\" — only {$product->total_quantity} in stock."
                    );
                }
            }

            $customer = \App\Models\Customer::findOrFail($request->customer_id);

            $settings      = \App\Models\Setting::first();
            $chargePerMile = (float) ($settings?->charge_per_mile ?? 1);
            $maxDist       = (float) ($settings?->max_delivery_distance ?? 20);
            $taxRate       = (float) ($settings?->tax_rate ?? 8.5) / 100;

            $isPickup      = (bool) ($request->is_pickup ?? false);
            $distanceMiles = 0;
            $travelingCost = 0;

            if (!$isPickup) {
                $distanceMiles = (float) ($request->distance_miles ?? 0);
                $travelingCost = (float) ($request->traveling_cost ?? 0);

                // Fall back to server-side calculation when the form didn't supply a distance
                if ($distanceMiles <= 0) {
                    $customerLocation = $customer->map_location;

                    if ($settings && $settings->godown_lat && $settings->godown_lng && $customerLocation && isset($customerLocation['lat'], $customerLocation['lng'])) {
                        $distanceMiles = $this->calculateDistance(
                            (float) $settings->godown_lat,
                            (float) $settings->godown_lng,
                            (float) $customerLocation['lat'],
                            (float) $customerLocation['lng']
                        );
                    }
                }

                if (!$travelingCost && $distanceMiles > 0) {
                    if ($distanceMiles <= $maxDist) {
                        $travelingCost = $chargePerMile * $maxDist;
                    } else {
                        $travelingCost = $chargePerMile * $maxDist + $chargePerMile * $distanceMiles;
                    }
                }
            }

            $subtotal = 0;
            foreach ($request->items as $item) {
                $product    = \App\Models\Product::findOrFail($item['product_id']);
                $rentalDays = \App\Helpers\RentalHelper::calculateDays(
                    \Carbon\Carbon::parse($item['start_date']),
                    \Carbon\Carbon::parse($item['end_date'])
                );
                $multiplier = max(1, $rentalDays / 2);
                $lineTotal  = $item['quantity'] * $product->price_per_day * $multiplier;
                $subtotal  += $lineTotal;
            }

            $totalAmount = $subtotal + ($subtotal * $taxRate) + $travelingCost;

            $order = Order::create([
                'customer_id'      => $customer->id,
                'customer_name'    => $customer->name,
                'customer_email'   => $customer->email,
                'customer_phone'   => $customer->phone ?? '',
                'customer_address' => $customer->address ?? '',
                'rental_start_date' => $request->rental_start_date,
                'rental_end_date'   => $request->rental_end_date,
                'total_amount'     => $totalAmount,
                'traveling_cost'   => $travelingCost,
                'distance_miles'   => $distanceMiles,
                'is_pickup'        => $isPickup,
                'status'           => 'pending',
            ]);

            foreach ($request->items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_per_day' => $product->price_per_day,
                    'start_date' => $item['start_date'],
                    'end_date' => $item['end_date'],
                ]);
            }

            if ($request->payment_status === 'paid') {
                $paymentAmount = $request->payment_amount ?? $totalAmount;

                \App\Models\Payment::create([
                    'order_id' => $order->id,
                    'payment_intent_id' => 'admin-manual-' . now()->timestamp,
                    'amount' => $paymentAmount,
                    'currency' => 'usd',
                    'status' => 'succeeded',
                    'payment_method' => $request->payment_method ?? 'manual',
                ]);

                $order->update(['status' => 'confirmed']);
            }

            \Log::info('BookOrder - Order created successfully:', [
                'order_id' => $order->id,
                'formatted_id' => $order->formatted_id,
                'customer_id' => $order->customer_id,
                'total_amount' => $order->total_amount
            ]);

            return redirect()->route('admin.orders.show', $order)->with('success', 'Order #' . $order->formatted_id . ' has been created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('BookOrder - Validation Error:', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('BookOrder - Exception caught:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->logError(__FUNCTION__, $e);
            return back()->withInput()->with('error', 'Could not create order. Please try again.');
        }
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 3958.8;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
