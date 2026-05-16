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
        try {
            $settings = \App\Models\Setting::first();
            return view('pages.checkout', compact('settings'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('pages.checkout', ['settings' => null, 'error' => 'Could not load checkout page.']);
        }
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'firstName'    => 'required',
                'lastName'     => 'required',
                'email'        => 'required|email',
                'phone'        => 'required',
                'eventDate'    => 'required|date',
                'address'      => 'required',
                'city'         => 'required',
                'state'        => 'required',
                'zip'          => 'required',
                'total_amount' => 'required|numeric',
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

            $distanceKm   = 0;
            $travelingCost = 0;

            $settings = \App\Models\Setting::first();
            if ($settings && $settings->godown_lat && $settings->godown_lng && $mapLocation && isset($mapLocation['lat'], $mapLocation['lng'])) {
                $distanceKm = $this->calculateDistance(
                    (float) $settings->godown_lat, (float) $settings->godown_lng,
                    (float) $mapLocation['lat'], (float) $mapLocation['lng']
                );

                if ($distanceKm > ($settings->free_delivery_distance ?? 5)) {
                    $travelingCost = $distanceKm * ($settings->charge_per_km ?? 1);
                }
            }

            // Stock validation before creating order
            foreach ($this->cartService->getCart() as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product && $item['quantity'] > $product->total_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->total_quantity} in stock for \"{$product->name}\". Please update your cart.",
                    ], 422);
                }
            }

            $order = Order::create([
                'customer_id'      => $customer->id,
                'customer_name'    => $fullName,
                'customer_email'   => $request->email,
                'customer_phone'   => $request->phone,
                'customer_address' => $fullAddress,
                'event_date'       => $request->eventDate,
                'total_amount'     => $request->total_amount,
                'traveling_cost'   => $travelingCost,
                'distance_km'      => $distanceKm,
                'status'           => 'pending',
            ]);

            foreach ($this->cartService->getCart() as $item) {
                $startDate = null;
                $endDate   = null;

                if (!empty($item['dateRange'])) {
                    $parts = explode(' → ', $item['dateRange']);
                    if (count($parts) === 2) {
                        $startDate = Carbon::parse($parts[0])->format('Y-m-d');
                        $endDate   = Carbon::parse($parts[1])->format('Y-m-d');
                    }
                }

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'quantity'     => $item['quantity'],
                    'price_per_day' => $item['price'],
                    'start_date'   => $startDate,
                    'end_date'     => $endDate,
                ]);
            }

            return response()->json(['success' => true, 'order_id' => $order->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not place order. Please try again.'], 500);
        }
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
