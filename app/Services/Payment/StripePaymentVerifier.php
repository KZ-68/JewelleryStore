<?php

namespace App\Services\Payment;

use App\Contracts\StripePaymentVerifierInterface;
use Laravel\Cashier\Cashier;

class StripePaymentVerifier implements StripePaymentVerifierInterface
{
    /**
     * Verify server-side via the Stripe API that the PaymentIntent has succeeded.
     * Never trust the redirect_status query param from the client alone.
     */
    public function isSucceeded(string $paymentIntentId): bool
    {
        try {
            $paymentIntent = Cashier::stripe()->paymentIntents->retrieve($paymentIntentId);

            return $paymentIntent->status === 'succeeded';
        } catch (\Exception $e) {
            return false;
        }
    }
}
