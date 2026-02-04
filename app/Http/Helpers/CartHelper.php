<?php

namespace App\Http\Helpers;

use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class CartHelper
{
    private const SESSION_KEY = 'cart';

    public function __construct()
    {
        if (!Session::has(self::SESSION_KEY)) {
            $this->initialize();
        }
    }

    public function add(array $product, int $quantity = 1, float $retailPrice = 0.00): void
    {
        $cart = $this->get();

        foreach ($cart['products'] as &$item) {
            if ($item['product_id'] === $product['id']) {
                $item['quantity'] += $quantity;
                $item['retail_price'] += $retailPrice;
                $this->set($cart);
                return;
            }
        }

        $cart['products'][] = [
            'product_id' => $product['id'],
            'name'       => $product['name'],
            'retail_price' => $retailPrice,
            'quantity'   => $quantity,
        ];

        $this->set($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();

        $cart['products'] = array_values(
            array_filter($cart['products'], fn ($product) => $product['product_id'] !== $productId)
        );

        $this->set($cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
        $this->initialize();
    }

    public function get(): array
    {
        return Session::get(self::SESSION_KEY, $this->empty());
    }

    public function isEmpty(): bool
    {
        return empty($this->get()['products']);
    }

    private function initialize(): void
    {
        $this->set($this->empty());
    }

    private function empty(): array
    {
        return [
            'products' => [],
        ];
    }

    private function set(array $cart): void
    {
        Session::put(self::SESSION_KEY, $cart);
    }

    public function persistForUser(Customer $customer): ?Cart
    {
        $cartSession = $this->get();

        if (empty($cartSession['products'])) {
            return null;
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => $customer->id, 'status' => 'draft']
        );

        foreach ($cartSession['products'] as $product) {
            $cart->products()->updateOrCreate(
                ['product_id' => $product['product_id']],
                [
                    'price'    => $product['price'],
                    'quantity' => $product['quantity'],
                ]
            );
        }

        return $cart;
    }
}