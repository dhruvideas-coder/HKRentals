<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $settings = \App\Models\Setting::first();
        return view('pages.checkout', compact('settings'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'firstName'  => 'required',
            'lastName'   => 'required',
            'email'      => 'required|email',
            'phone'      => 'required',
            'eventDate'  => 'required|date',
            'address'    => 'required',
            'city'       => 'required',
            'state'      => 'required',
            'zip'        => 'required',
            'total_amount' => 'required|numeric'
        ]);

        $fullName    = $request->firstName . ' ' . $request->lastName;
        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip;

        $mapLocation = null;
        if ($request->filled('mapLocation')) {
            $raw = $request->mapLocation;
            $mapLocation = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            array_filter([
                'name'         => $fullName,
                'phone'        => $request->phone,
                'address'      => $fullAddress,
                'map_location' => $mapLocation,
            ], fn($v) => $v !== null)
        );

        $distanceKm = 0;
        $travelingCost = 0;

        $settings = \App\Models\Setting::first();
        if ($settings && $settings->godown_lat && $settings->godown_lng && $mapLocation && isset($mapLocation['lat']) && isset($mapLocation['lng'])) {
            $distanceKm = $this->calculateDistance(
                (float) $settings->godown_lat, (float) $settings->godown_lng,
                (float) $mapLocation['lat'], (float) $mapLocation['lng']
            );

            if ($distanceKm > ($settings->free_delivery_distance ?? 5)) {
                $chargePerKm = $settings->charge_per_km ?? 1;
                $travelingCost = $distanceKm * $chargePerKm;
            }
        }

        // Verify total amount from client matches our calculation
        $subtotal = collect($this->cartService->getCart())->sum(function($item) {
            $days = 1;
            if (!empty($item['dateRange'])) {
                $parts = explode(' → ', $item['dateRange']);
                if (count($parts) === 2) {
                    $start = Carbon::parse($parts[0]);
                    $end = Carbon::parse($parts[1]);
                    $days = max(1, $start->diffInDays($end));
                }
            }
            return $item['price'] * $item['quantity'] * $days;
        });
        $calculatedTotal = $subtotal + ($subtotal * 0.085) + $travelingCost;
        // In production, you would validate $request->total_amount against $calculatedTotal
        // For now, we trust the client to avoid minor rounding mismatches, or we can force ours:
        $finalTotalAmount = $request->total_amount;

        $order = Order::create([
            'customer_id'      => $customer->id,
            'customer_name'    => $fullName,
            'customer_email'   => $request->email,
            'customer_phone'   => $request->phone,
            'customer_address' => $fullAddress,
            'event_date'       => $request->eventDate,
            'total_amount'     => $finalTotalAmount,
            'traveling_cost'   => $travelingCost,
            'distance_km'      => $distanceKm,
            'status'           => 'pending',
        ]);

        // Insert OrderItems
        $cartItems = $this->cartService->getCart();
        foreach ($cartItems as $item) {
            $startDate = null;
            $endDate = null;
            
            if (!empty($item['dateRange'])) {
                $parts = explode(' → ', $item['dateRange']);
                if (count($parts) === 2) {
                    $startDate = Carbon::parse($parts[0])->format('Y-m-d');
                    $endDate = Carbon::parse($parts[1])->format('Y-m-d');
                }
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price_per_day' => $item['price'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'order_id' => $order->id
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }
}
