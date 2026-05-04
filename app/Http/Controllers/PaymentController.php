<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\Payment;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $cartService;

    public function __construct(PaymentService $paymentService, CartService $cartService)
    {
        $this->paymentService = $paymentService;
        $this->cartService = $cartService;
    }

    /**
     * Create a mock payment intent.
     */
    public function createIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|exists:orders,id'
        ]);

        try {
            $intent = $this->paymentService->createPaymentIntent($request->amount);

            return response()->json($intent);
        } catch (\Exception $e) {
            Log::error('Error creating payment intent: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process payment request.'], 500);
        }
    }

    /**
     * Confirm a mock payment.
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric'
        ]);

        try {
            // Confirm the payment via service
            $result = $this->paymentService->confirmPayment($request->payment_intent_id);

            if ($result['status'] === 'succeeded') {
                // Save to database
                $payment = Payment::create([
                    'order_id' => $request->order_id,
                    'payment_intent_id' => $result['id'],
                    'amount' => $request->amount,
                    'currency' => 'usd',
                    'status' => 'succeeded',
                    'payment_method' => 'mock_card'
                ]);

                // Update order status if needed
                $order = Order::find($request->order_id);
                $order->update(['status' => 'paid']);

                // Clear the cart session
                $this->cartService->clearCart();

                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful',
                    'payment' => $payment
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment failed'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error confirming payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while confirming the payment.'
            ], 500);
        }
    }
}
