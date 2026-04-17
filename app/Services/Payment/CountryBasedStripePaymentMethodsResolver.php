<?php

namespace App\Services\Payment;

use App\Contracts\StripePaymentMethodsResolverInterface;

class CountryBasedStripePaymentMethodsResolver implements StripePaymentMethodsResolverInterface
{
    /**
     * Return the Stripe payment methods configured for the given country ISO code.
     * Falls back to the 'default' entry if the country is not explicitly listed.
     *
     * @return string[]
     */
    public function resolve(string $countryIso): array
    {
        $countryCode = $this->extractCountryCode($countryIso);

        return config('stripe_payment_methods.' . $countryCode)
            ?? config('stripe_payment_methods.default', ['card']);
    }

    /**
     * Extract the ISO 3166-1 alpha-2 country code from a locale tag.
     * Handles both plain codes ('FR') and BCP 47 tags ('fr-FR', 'nl-BE').
     */
    private function extractCountryCode(string $iso): string
    {
        $parts = explode('-', $iso);
        return strtoupper(end($parts));
    }
}
