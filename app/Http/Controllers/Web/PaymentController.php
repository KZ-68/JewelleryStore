<?php

namespace App\Http\Controllers\Web;

use App\DTOs\CreateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Carrier;
use App\Models\Customer;
use App\Services\Order\CreateOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    private const SESSION_KEY = 'order';

    public function __construct(
        private CreateOrderService $orderService
    ) {}

    public function createIntent(Request $request, CartHelper $cart, CreateOrderRequest $orderRequest)
    {
        $user = $request->user('web');
        $customer = Customer::where('id', $user->id)->firstOrFail();
        $cartProduct = $cart->get();
        
        $carrier = Carrier::where('id', $cartProduct['carrier']['id'])->firstOrFail();
        $dto = CreateOrderDTO::fromRequest($orderRequest);
        $order = $this->orderService->createOrder($dto, $carrier, $customer);
        
        Session::put(self::SESSION_KEY, [
            'id' => $order->id,
            'reference' => $order->reference
        ]);

        $payment = $request->user()->payWith(
            ($request->input('amount') * 100),
            ['card', 'bancontact'],
            [
                'currency' => 'eur',
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ],
        );

        return response()->json([
            'clientSecret' => $payment->client_secret,
        ]);
    }
}