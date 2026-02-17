<?php
/* 
* Controller File for the cart page
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CartHelper;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
    * Render the view assigned to the cart page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function show(Request $request, CartHelper $cart): Response
    {
        $cartProducts = $cart->get();
        $products = $cartProducts['products'];

        return Inertia::render('web/Cart', [
            'status' => $request->session()->get('status'),
            'products' => $products
        ]);
    }

    public function addToCart(Request $request, CartHelper $cart) : bool
    {
        $product = $request->product;
        $productId = $request->product['id'];
        $retailPrice = $request->retail_price;
        $quantity = $request->quantity;
        $cart->add($product, $productId, $quantity, $retailPrice);

        if($request->user('web')) {
            $user = $request->user('web');
            $cartCustomer = new Cart;
            $cartCustomer->products()->attach($product);
            $customer = Customer::where('email', $user->email)->firstOrFail();
            $customer->carts()->attach($cartCustomer);
        } 

        return true;
    }

    public function removeToCart(Request $request, CartHelper $cart) : bool
    {
        $productCart = $request->product;
        $product = Product::where('id', $productCart['product_id'])->first();
        $cart->remove($product->id);

        return true;
    }
}
