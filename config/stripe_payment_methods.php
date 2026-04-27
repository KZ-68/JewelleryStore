<?php

/*
|--------------------------------------------------------------------------
| Stripe Payment Methods by Country (ISO 3166-1 alpha-2)
|--------------------------------------------------------------------------
| Maps each country ISO code to its list of accepted Stripe payment methods.
| When no entry matches, the 'default' key is used as fallback.
|
| Full list of supported methods: https://stripe.com/docs/payments/payment-methods/overview
*/

return [
    'BE' => ['card', 'bancontact'],
    'NL' => ['card', 'ideal'],
    'DE' => ['card', 'sepa_debit'],
    'AT' => ['card', 'eps'],
    'PL' => ['card', 'p24'],
    'FR' => ['card', 'bancontact'],
    'default' => ['card'],
];
