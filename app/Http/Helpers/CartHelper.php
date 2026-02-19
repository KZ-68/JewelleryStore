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

    public function add(array $product, int $id, int $quantity = 1, float $retailPrice = 0.00): void
    {
        $cart = $this->get();

        foreach ($cart['products'] as &$item) {
            if ($item['product_id'] === $id) {
                $item['quantity'] += $quantity;
                $item['retail_price'] += $retailPrice;
                $this->set($cart);
                return;
            }
        }

        $cart['products'][] = [
            'product_id' => $id,
            'name'       => $product['name'],
            'retail_price' => $retailPrice,
            'quantity'   => $quantity,
        ];
        $cart['total_price'] += $retailPrice;

        $this->set($cart);
    }

    public function increment(int $id, int $quantity = 1, float $retailPrice = 0.00): void
    {
        $cart = $this->get();

        if(isset($cart['products']) && is_array($cart['products'])) {
            foreach($cart['products'] as &$item) {
                if ($item['product_id'] === $id) {
                    $item['quantity'] += $quantity;
                    $item['retail_price'] += $retailPrice;
                    $this->set($cart);
                }
            }
        }
    }

    public function decrement(int $id, int $quantity = 1, float $retailPrice = 0.00): void
    {
        $cart = $this->get();

        foreach($cart['products'] as &$item) {
            if ($item['product_id'] === $id) {
                $item['quantity'] -= $quantity;
                $item['retail_price'] -= $retailPrice;
                if($item['quantity'] === 0) {
                    $cart['products'] = [];
                    $this->set($cart);
                } else {
                    $this->set($cart);
                }
            }
        }
        
    }

    public function remove(int $productId, float $retailPrice): void
    {
        $cart = $this->get();

        $cart['products'] = array_values(
            array_filter($cart['products'], fn ($product) => $product['product_id'] !== $productId)
        );
        $cart['total_price'] -= $retailPrice;

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
            'total_price' => 0,
            'delivery_address' => [
                'country_id' => null,
                'customer_id' => null,
                'name' => '',
                'address_line_1' => '',
                'address_line_2' => '',
                'city' => '',
                'postal_code' => '',
                'region' => '',
                'district' => '',
                'sub_district' => '',
                'locality' => '',
                'sub_locality' => '',
            ],
            'carrier' => [
                'id' => null,
                'name' => null,
                'slug' => null,
                'description' => null,
                'carrier_position' => 0
            ]
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

    public function insertDeliveryAddress($user, $address): void
    {
        $cart = $this->get();
        $cart['delivery_address']['country_id'] = $address->country_id;
        if($user) {
            $customer = Customer::where('email', $user->email)->firstOrFail();
            $cart['delivery_address']['customer_id'] = $customer->id;
        } else {
            $cart['delivery_address']['customer_id'] = null;
        }

        $cart['delivery_address']['name'] = $address->name;
        $cart['delivery_address']['address_line_1'] = $address->address_line_1;
        $cart['delivery_address']['address_line_2'] = $address->address_line_2;
        $cart['delivery_address']['city'] = $address->city;
        $cart['delivery_address']['postal_code'] = $address->postal_code;
        $cart['delivery_address']['region'] = $address->region;
        $cart['delivery_address']['district'] = $address->district;
        $cart['delivery_address']['sub_district'] = $address->sub_district;
        $cart['delivery_address']['locality'] = $address->locality;
        $cart['delivery_address']['sub_locality'] = $address->sub_locality;
        $this->set($cart);
    }

    public function insertCarrier($carrier): void
    {
        $cart = $this->get();
        $cart['carrier']['id'] = $carrier->id;
        $cart['carrier']['name'] = $carrier->name;
        $cart['carrier']['slug'] = $carrier->slug;
        $cart['carrier']['description'] = $carrier->description;
        $cart['carrier']['carrier_position'] = $carrier->carrier_position;
        $this->set($cart);
    }
}