<?php
/* 
* Controller File for the cart page
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderFrontController extends Controller
{
    /**
     * Render the view assigned to the order page
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showOrderPage(Request $request): Response
    {
        $user = $request->user();
        if(!$user) {
            $customer = '';
        } else {
            $customer = Customer::where('email', $user->email)->firstOrFail();
        }
        $carriers = Carrier::all();
        $countries = Country::all();
        $payments = Payment::all();

        return Inertia::render(
            'web/OrderPage', 
            [
                'carriers' => $carriers,
                'customer' => $customer,
                'countries' => $countries,
                'payments' => $payments,
            ]
        );
    }

}