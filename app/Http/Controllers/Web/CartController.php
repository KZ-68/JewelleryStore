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
    * @param Request $request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function show(Request $request, CartHelper $cart): Response
    {
        $cartProducts = $cart->get();
        $products = $cartProducts['products'];

        return Inertia::render('web/Cart', [
            'status' => $request->session()->get('status'),
            'products' => $products,
            'total_price' => $cartProducts['total_price']
        ]);
    }

    public function addToCart(Request $request, CartHelper $cart): bool
    {
        $product      = $request->product;
        $productId    = $request->product['id'];
        $quantity     = $request->quantity;
        $retailPrice  = $request->retail_price * $quantity;
        $selectedSize = $request->selected_size ?? null;

        // Session cart (guests + logged-in users)
        $cart->add($product, $productId, $quantity, $retailPrice);

        // Persist to database for authenticated customers
        if ($request->user('web')) {
            $customer     = Customer::where('email', $request->user('web')->email)->firstOrFail();
            $customerCart = Cart::firstOrCreate(['customer_id' => $customer->id]);

            $existing = $customerCart->products()->wherePivot('product_id', $productId)->first();

            if ($existing) {
                $customerCart->products()->updateExistingPivot($productId, [
                    'quantity'     => $existing->pivot->quantity + $quantity,
                    'retail_price' => $existing->pivot->retail_price + $retailPrice,
                ]);
            } else {
                $customerCart->products()->attach($productId, [
                    'quantity'      => $quantity,
                    'retail_price'  => $retailPrice,
                    'selected_size' => $selectedSize,
                ]);
            }
        }

        return true;
    }

    public function removeToCart(Request $request, CartHelper $cart): bool
    {
        $productCart = $request->product;
        $product     = Product::where('id', $productCart['product_id'])->firstOrFail();

        // Remove from session cart
        $cart->remove($product->id, $productCart['retail_price']);

        // Remove from database cart for authenticated customers
        if ($request->user('web')) {
            $customer = Customer::where('email', $request->user('web')->email)->firstOrFail();
            $customer->cart?->products()->detach($product->id);
        }

        return true;
    }
}
