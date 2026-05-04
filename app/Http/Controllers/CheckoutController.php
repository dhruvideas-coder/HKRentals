<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('pages.checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'total_amount' => 'required|numeric'
        ]);

        $order = Order::create([
            'customer_name' => $request->firstName . ' ' . $request->lastName,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip,
            'total_amount' => $request->total_amount,
            'status' => 'pending'
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
}
