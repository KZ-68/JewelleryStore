<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class CartHelper
{
    public function __construct(Request $request)
    {
        if($this->get() === null) {
            if($request->user('web') === null) {
                $this->set($this->empty());
            }
        }
    }

    public function add(array $product, float $retailPrice): void
    {
        $cart = $this->get();
        array_push($cart['products'], $product);
        array_push($cart['products']['retail-price'], $retailPrice);
        $this->set($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        array_splice($cart['products'], array_search($productId, array_column($cart['products'], 'id')), 1);
        $this->set($cart);
    }

    public function clear(): void
    {
        $this->set($this->empty());
    }

    public function empty(): ?array
    {
        return [];
    }

    public function get(): ?array
    {
        return request()->session()->get('cart');
    }

    private function set($cart): void
    {
        request()->session()->put('cart', $cart);
    }
}