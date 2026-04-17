<?php

namespace App\Contracts;

interface StripePaymentVerifierInterface
{
    /**
     * Return true if the given Stripe PaymentIntent has been successfully charged.
     */
    public function isSucceeded(string $paymentIntentId): bool;
}
