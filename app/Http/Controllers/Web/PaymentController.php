<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = $request->user('web');
        $customer = Customer::where('id', $user->id);
        $order = new Order;
        $order->customer()->associate($customer);
        $order->statuses()->attach(1);
        $order->save();

        $intent = $customer->createPaymentIntent(
            $order->amount,
            [
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]
        );

        return response()->json([
            'clientSecret' => $intent->client_secret,
        ]);
    }
}