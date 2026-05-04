<?php

namespace App\Services;

use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Simulate creating a Stripe Payment Intent.
     * 
     * @param float|int $amount
     * @return array
     */
    public function createPaymentIntent($amount)
    {
        // Mock Stripe Payment Intent response
        return [
            'id' => 'pi_mock_' . strtolower(Str::random(10)),
            'amount' => $amount,
            'currency' => 'usd',
            'status' => 'requires_payment_method',
            'client_secret' => 'mock_client_secret_' . strtolower(Str::random(15)),
        ];
    }

    /**
     * Simulate confirming a Stripe Payment Intent.
     * 
     * @param string $paymentIntentId
     * @return array
     */
    public function confirmPayment($paymentIntentId)
    {
        // Mock successful payment confirmation
        return [
            'id' => $paymentIntentId,
            'status' => 'succeeded',
        ];
    }

    /**
     * Simulate a failed payment.
     * 
     * @return array
     */
    public function simulateFailure()
    {
        return [
            'status' => 'failed',
            'error' => [
                'message' => 'Your card was declined.'
            ]
        ];
    }
}
