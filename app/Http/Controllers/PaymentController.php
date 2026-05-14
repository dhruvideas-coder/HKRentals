<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\Payment;
use App\Models\Order;
use App\Services\CartService;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $cartService;

    public function __construct(PaymentService $paymentService, CartService $cartService)
    {
        $this->paymentService = $paymentService;
        $this->cartService    = $cartService;
    }

    public function createIntent(Request $request)
    {
        try {
            $request->validate([
                'amount'   => 'required|numeric|min:1',
                'order_id' => 'required|exists:orders,id',
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
                'order_id'          => 'required|exists:orders,id',
                'amount'            => 'required|numeric',
            ]);

            $result = $this->paymentService->confirmPayment($request->payment_intent_id);

            if ($result['status'] === 'succeeded') {
                $payment = Payment::create([
                    'order_id'           => $request->order_id,
                    'payment_intent_id'  => $result['id'],
                    'amount'             => $request->amount,
                    'currency'           => 'usd',
                    'status'             => 'succeeded',
                    'payment_method'     => 'mock_card',
                ]);

                Order::find($request->order_id)->update(['status' => 'paid']);

                $this->cartService->clearCart();

                return response()->json(['success' => true, 'message' => 'Payment successful', 'payment' => $payment]);
            }

            return response()->json(['success' => false, 'message' => 'Payment failed'], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return response()->json(['success' => false, 'message' => 'An error occurred while confirming the payment.'], 500);
        }
    }
}
