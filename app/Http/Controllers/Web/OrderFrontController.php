<?php
/**
* Controller File for the cart page.
* Manages the step-by-step order process including address selection,
* carrier selection, payment selection and order confirmation after
* Stripe payment verification.
*
* @package App\Http\Controllers\Web
* @author  Kevin ZITNIK
*/

namespace App\Http\Controllers\Web;

use App\Contracts\StripePaymentVerifierInterface;
use App\DTOs\CreateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ShippingRate;
use App\Models\Status;
use App\Services\Order\CreateOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class OrderFrontController extends Controller
{
    public function __construct(
        private CreateOrderService $orderService,
        private StripePaymentVerifierInterface $paymentVerifier,
    ) {}

    /**
     * Render the view assigned to the order page
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showOrderPage(Request $request, CartHelper $cart): Response
    {
        $user = $request->user();
        if(!$user) {
            $customer = '';
            $addresses = '';
        } else {
            $customer = Customer::where('email', $user->email)->firstOrFail();
            $addresses = $customer->addresses()->get();
        }
        $carriers = Carrier::all();
        $countries = Country::all();
        $payments = Payment::all();
        $cartProducts = $cart->get();

        return Inertia::render(
            'web/OrderPage', 
            [
                'addresses' => $addresses,
                'carriers' => $carriers,
                'customer' => $customer,
                'countries' => $countries,
                'payments' => $payments,
                'products' => $cartProducts['products'],
                'total_price' => $cartProducts['total_price']
            ]
        );
    }

    /**
     * Method select the address and associate to Cart
     * @param Request $request Get the request
     * @return JsonResponse Return a Response on JSON format with boolean value for confirmation or errors
    */
    public function selectAddress(Request $request, CartHelper $cart): JsonResponse
    {
        try {
            $user = $request->user();
            $addressId = $request->input('addressId');
            $address = Address::where('id', $addressId)->first();
            $cart->insertDeliveryAddress($user, $address);
        } catch (\Exception $e) {
            return response()->json([
                'isAddressSelected' => false,
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'isAddressSelected' => true,
        ]);
    }

    /**
     * Method select the carrier and associate to Cart
     * @param Request $request Get the request
     * @return JsonResponse Return a Response on JSON format with boolean value for confirmation or errors
    */
    public function selectCarrier(Request $request, CartHelper $cart): JsonResponse
    {
        $cartData = $cart->get();
        if (!$cartData['delivery_address'])
        {
            return response()->json([
                'isCarrierSelected' => false,
                'error' => 'Delivery Address is not selected'
            ]);
        }

        try {
            $carrierId = $request->input('carrierId');
            $carrier = Carrier::where('id', $carrierId)->first();
            $cart->insertCarrier($carrier);
            $shippingCost = $this->resolveShippingCost($carrierId, $cartData['total_price']);
        } catch (\Exception $e) {
            return response()->json([
                'isCarrierSelected' => false,
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'isCarrierSelected' => true,
            'shipping_cost' => $shippingCost,
        ]);
    }

    public function getShippingRatePrice(CartHelper $cart): JsonResponse
    {
        $cartData = $cart->get();
        $shippingCost = $this->resolveShippingCost($cartData['carrier']['id'], $cartData['total_price']);

        return response()->json([
            'totalWithShipping' => $cartData['total_price'] + $shippingCost,
        ]);
    }

    /**
     * Find the applicable shipping cost for a carrier given an order total.
     * Returns 0 if no matching rate is found.
     * @param int $carrierId The identifier for the carrier
     * @param float $total The total price for this cart
     * @return float The shipping rate
     */
    private function resolveShippingCost(int $carrierId, float $total): float
    {
        $shippingRate = ShippingRate::where('carrier_id', $carrierId)
            ->where('min_total', '<=', $total)
            ->where('max_total', '>=', $total)
            ->first();

        return $shippingRate ? (float) $shippingRate->price : 0.0;
    }

    /**
     * Method select the payment and associate to Cart
     * @param Request $request Get the request
     * @return JsonResponse Return a Response on JSON format with boolean value for confirmation or errors
    */
    public function selectPayment(Request $request, CartHelper $cart): JsonResponse
    {
        $cartData = $cart->get();

        if (empty($cartData['carrier']['id'])) {
            return response()->json([
                'isPaymentSelected' => false,
                'error' => 'Carrier is not selected'
            ]);
        }

        if ($cartData['total_price'] <= 0) {
            return response()->json([
                'isPaymentSelected' => false,
                'error' => 'Order total must be greater than 0'
            ]);
        }

        try {
            $paymentId = $request->input('paymentId');
            $payment = Payment::where('id', $paymentId)->first();
            $cart->insertPayment($payment);
        } catch (\Exception $e) {
            return response()->json([
                'isPaymentSelected' => false,
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'isPaymentSelected' => true,
        ]);
    }

    public function orderConfirmation(Request $request, CartHelper $cart): Response|RedirectResponse
    {
        $paymentIntentId = $request->query('payment_intent');
        $session         = Session::get('order');
        $locale          = app()->getLocale();

        if (!$paymentIntentId || empty($session['payment_intent_id'])) {
            return redirect()
                ->route('order.showOrderPage', ['locale' => $locale])
                ->with('error', 'No payment information found. Please complete your order again.');
        }

        if ($paymentIntentId !== $session['payment_intent_id']) {
            Session::forget('order');
            return redirect()
                ->route('order.showOrderPage', ['locale' => $locale])
                ->with('error', 'Payment reference mismatch. Please start a new order.');
        }

        if (!$this->paymentVerifier->isSucceeded($paymentIntentId)) {
            Session::forget('order');
            return redirect()
                ->route('order.showOrderPage', ['locale' => $locale])
                ->with('error', 'Payment was not successful. Please try again.');
        }

        try {
            $cartData = $cart->get();
            $user     = $request->user('web');
            $customer = Customer::where('id', $user->id)->firstOrFail();
            $carrier  = Carrier::where('id', $cartData['carrier']['id'])->firstOrFail();

            $dto   = CreateOrderDTO::fromArray($session['order_dto']);
            $order = $this->orderService->createOrder($dto, $carrier, $customer);

            $status = Status::firstOrCreate(['name' => 'Payment Confirmed']);
            $order->statuses()->attach($status);
            $order->save();

            Session::forget('order');
            $cart->clear();

            return Inertia::render('web/OrderConfirmation', ['order' => $order]);

        } catch (\Exception $e) {
            Log::error('Order confirmation failed', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Session::forget('order');
            return redirect()
                ->route('order.showOrderPage', ['locale' => $locale])
                ->with('error', 'An error occurred while confirming your order. Please contact support.');
        }
    }

}