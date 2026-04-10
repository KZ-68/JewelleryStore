<?php

namespace App\Repositories;

use App\Contracts\OrderListRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderListRepositoryInterface
{
    public function getAllOrders(array $filters)
    {
        return Order::query()
            ->orderBy($filters['sortBy'], $filters['order'])
            ->get();
    }

    public function getOrderByReference(string $reference) : Order|array
    {
        try {
            $order = Order::where('reference', $reference)->firstOrFail();
            return $order;
        } catch (\Throwable $th) {
            return ['error' => $th->getMessage()];
        }
    }
}