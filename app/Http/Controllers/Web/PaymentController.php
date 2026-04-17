<?php

namespace App\Http\Controllers\Web;

use App\Contracts\StripePaymentMethodsResolverInterface;
use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    private const SESSION_KEY = 'order';

    public function __construct(
        private StripePaymentMethodsResolverInterface $paymentMethodsResolver,
    ) {}

    public function createIntent(CreateOrderRequest $orderRequest, CartHelper $cart): JsonResponse
    {
        $user = $orderRequest->user('web');

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $cartData = $cart->get();

        if (empty($cartData['products'])) {
            return response()->json(['error' => 'Your cart is empty'], 422);
        }

        if (empty($cartData['delivery_address']['address_line_1'])) {
            return response()->json(['error' => 'No delivery address selected'], 422);
        }

        if (empty($cartData['carrier']['id'])) {
            return response()->json(['error' => 'No carrier selected'], 422);
        }

        if (empty($cartData['payment']['id'])) {
            return response()->json(['error' => 'No payment method selected'], 422);
        }

        try {
            $carrier = Carrier::where('id', $cartData['carrier']['id'])->firstOrFail();
            $country = Country::findOrFail($cartData['delivery_address']['country_id']);

            $shippingRate = ShippingRate::where('carrier_id', $carrier->id)
                ->where('min_total', '<=', $cartData['total_price'])
                ->where('max_total', '>=', $cartData['total_price'])
                ->first();

            $shippingCost  = $shippingRate ? (float) $shippingRate->price : 0.0;
            $amountInCents = (int) round(($cartData['total_price'] + $shippingCost) * 100);

            $paymentMethods = $this->paymentMethodsResolver->resolve($country->iso);

            $payment = $user->payWith(
                $amountInCents,
                $paymentMethods,
                [
                    'currency' => 'eur',
                    'metadata' => [
                        'carrier_id' => $carrier->id,
                        'country'    => $country->iso,
                    ],
                ],
            );

            // Persiste le contexte nécessaire à la création de commande post-paiement
            Session::put(self::SESSION_KEY, [
                'payment_intent_id' => $payment->id,
                'order_dto'         => $orderRequest->validated(),
            ]);

            return response()->json(['clientSecret' => $payment->client_secret]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment initialization failed'], 500);
        }
    }
}
