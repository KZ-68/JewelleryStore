<?php

namespace App\Contracts;

interface StripePaymentMethodsResolverInterface
{
    /**
     * Resolve the Stripe payment methods available for a given country ISO code.
     *
     * @return string[]
     */
    public function resolve(string $countryIso): array;
}
