<?php
/* 
* Controller File for the cart page
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderFrontController extends Controller
{
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
            $addressId = $request->get('addressId');
            $address = Address::where('id', $addressId)->first();
            $cart->insertDeliveryAddress($user, $address);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
            return response()->json([
                'isAddressSelected' => false,
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
        try {
            $user = $request->user();
            $carrierId = $request->get('carrierId');
            $carrier = Carrier::where('id', $carrierId)->first();
            $cart->insertCarrier($user, $carrier);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
            return response()->json([
                'isCarrierSelected' => false
            ]);
        }

        return response()->json([
            'isCarrierSelected' => true,
        ]);
    }

}