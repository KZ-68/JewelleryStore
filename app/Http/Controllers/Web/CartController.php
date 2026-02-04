<?php
/* 
* Controller File for the cart page
*/

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Customer;
use App\Helpers\CartHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
    * Render the view assigned to the cart page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function show(Request $request): Response
    {
        return Inertia::render('web/Cart', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function createCart(Request $request) : Response|RedirectResponse
    {
        $user = $request->user('web');
        $product = $request->product;
        $retailPrice = $request->retail_price;
        $cart = new CartHelper($request);
        $cart->add($product, $retailPrice);

        if($user) {
            $cartCustomer = new Cart;
            $cartCustomer->products()->attach($product);
            $customer = Customer::where('email', $user->email)->firstOrFail();
            $customer->carts()->attach();
        } 
    }
}
