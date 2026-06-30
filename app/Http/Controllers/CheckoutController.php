<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\CheckoutOrderService;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected CheckoutOrderService $orderService;

    public function __construct(CartService $cartService, CheckoutOrderService $orderService)
    {
        $this->cartService  = $cartService;
        $this->orderService = $orderService;
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
                'firstName'       => 'required',
                'lastName'        => 'required',
                'email'           => 'required|email',
                'phone'           => 'required',
                'rentalStartDate' => 'required|date',
                'rentalEndDate'   => 'required|date|after_or_equal:rentalStartDate',
                'address'         => 'required',
                'city'            => 'required',
                'state'           => 'required',
                'zip'             => 'required',
                'total_amount'    => 'required|numeric',
            ]);

            $cart = $this->cartService->getCart();

            if (empty($cart)) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
            }

            // Stock validation up front — before any order is created or payment is taken.
            foreach ($cart as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product && $item['quantity'] > $product->total_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only {$product->total_quantity} in stock for \"{$product->name}\". Please update your cart.",
                    ], 422);
                }
            }

            $payload = $this->buildCheckoutPayload($request);

            // Card payments are completed at /payment/confirm. We DO NOT create an order
            // here — the checkout details are stashed in the session and the order is only
            // created once payment succeeds. So an abandoned card checkout leaves no order
            // (and no customer) behind.
            if (($request->paymentMethod ?? 'card') === 'card') {
                session(['pending_checkout' => ['data' => $payload, 'cart' => $cart]]);

                return response()->json(['success' => true, 'requires_payment' => true]);
            }

            // Invoice (pay-later) has no further step — submitting it IS the completion,
            // so the order is created now with a pending status.
            $order = $this->orderService->persist($payload, $cart, 'pending');
            $this->cartService->clearCart();
            session()->forget('pending_checkout');

            return response()->json(['success' => true, 'order_id' => $order->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Could not place order. Please try again.'], 500);
        }
    }

    /**
     * Normalise the checkout request into a flat payload used to build the order.
     */
    private function buildCheckoutPayload(Request $request): array
    {
        $fullName    = $request->firstName . ' ' . $request->lastName;
        $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip;

        $mapLocation = null;
        if ($request->filled('mapLocation')) {
            $raw = $request->mapLocation;
            $mapLocation = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        $isPickup      = (bool) ($request->is_pickup ?? false);
        $distanceMiles = 0;
        $travelingCost = 0;

        $settings = \App\Models\Setting::first();
        if (!$isPickup && $settings && $settings->godown_lat && $settings->godown_lng && $mapLocation && isset($mapLocation['lat'], $mapLocation['lng'])) {
            $distanceMiles = $this->calculateDistance(
                (float) $settings->godown_lat, (float) $settings->godown_lng,
                (float) $mapLocation['lat'], (float) $mapLocation['lng']
            );

            // Count delivery charges based on distance
            $chargePerMile = (float) ($settings->charge_per_mile ?? 1);
            $maxDist       = (float) ($settings->max_delivery_distance ?? 50);

            if ($distanceMiles <= $maxDist) {
                $travelingCost = $chargePerMile * $maxDist;
            } else {
                $travelingCost = $chargePerMile * $maxDist + $chargePerMile * $distanceMiles;
            }
        }

        return [
            'name'              => $fullName,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'address'           => $fullAddress,
            'map_location'      => $mapLocation,
            'rental_start_date' => Carbon::parse($request->rentalStartDate)->toDateTimeString(),
            'rental_end_date'   => Carbon::parse($request->rentalEndDate)->toDateTimeString(),
            'total_amount'      => $request->total_amount,
            'traveling_cost'    => $travelingCost,
            'distance_miles'    => $distanceMiles,
            'is_pickup'         => $isPickup,
        ];
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
