<?php

namespace App\Services\Order;

use App\DTOs\CreateOrderDTO;
use App\Models\Carrier;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Status;

class CreateOrderService
{
    public function createOrder(CreateOrderDTO $dto, Carrier $carrier, Customer $customer): Order
    {
        $orderData = [
            'gift' => $dto->gift,
            'gift_message' => $dto->gift_message,
            'note' => $dto->note,
            'valid' => $dto->valid,
            'returned' => $dto->returned
        ];

        $order = Order::create($orderData);
        $order->carrier()->associate($carrier);
        $order->customer()->associate($customer);
        $status = Status::firstOrCreate(['name' => 'pending']);
        $order->statuses()->attach($status);

        return $order;
    }
}