<?php
/* 
* Controller File for stripe package
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StripeController extends Controller
{ 
    public function checkout(Request $request)
    {
        $stripePriceId = 'price_deluxe_album';
 
        $quantity = 1;
    
        return $request->customer()->checkout([$stripePriceId => $quantity], [
            'success_url' => route('checkout-success'),
            'cancel_url' => route('checkout-cancel'),
        ]);
    }
}