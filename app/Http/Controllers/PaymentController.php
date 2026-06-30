<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Services\PaymentService;
use App\Services\CheckoutOrderService;
use App\Models\Payment;
use App\Services\CartService;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $cartService;
    protected CheckoutOrderService $orderService;

    public function __construct(PaymentService $paymentService, CartService $cartService, CheckoutOrderService $orderService)
    {
        $this->paymentService = $paymentService;
        $this->cartService    = $cartService;
        $this->orderService   = $orderService;
    }

    public function createIntent(Request $request)
    {
        try {
            // No order exists yet for card checkouts — the order is only created once the
            // payment is confirmed, so we just need the amount here.
            $request->validate([
                'amount' => 'required|numeric|min:1',
            ]);

            $intent = $this->paymentService->createPaymentIntent($request->amount);

            return response()->json($intent);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'Unable to process payment request.'], 500);
        }
    }

    public function confirm(Request $request)
    {
        try {
            $request->validate([
                'payment_intent_id' => 'required|string',
                'amount'            => 'required|numeric',
            ]);

            // The checkout details were stashed when the customer submitted the form.
            // Without them we cannot (and must not) create an order.
            $pending = session('pending_checkout');
            if (! $pending || empty($pending['data']) || empty($pending['cart'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your checkout session expired. Please start again.',
                ], 422);
            }

            $result = $this->paymentService->confirmPayment($request->payment_intent_id);

            if ($result['status'] !== 'succeeded') {
                // Payment failed → no order is created.
                return response()->json(['success' => false, 'message' => 'Payment failed'], 400);
            }

            // Payment succeeded → NOW create the order (customer + order + items + payment).
            $order = $this->orderService->persist($pending['data'], $pending['cart'], 'confirmed');

            Payment::create([
                'order_id'          => $order->id,
                'payment_intent_id' => $result['id'],
                'amount'            => $request->amount,
                'currency'          => 'usd',
                'status'            => 'succeeded',
                'payment_method'    => 'mock_card',
            ]);

            $this->cartService->clearCart();
            session()->forget('pending_checkout');

            // Send confirmation email with PDF receipt
            try {
                $order->load(['items.product', 'payment', 'customer']);
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            } catch (\Throwable $e) {
                \Log::warning('Order confirmation email failed: ' . $e->getMessage(), ['order_id' => $order->id]);
            }

            return response()->json(['success' => true, 'message' => 'Payment successful', 'order_id' => $order->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'An error occurred while confirming the payment.'], 500);
        }
    }
}
