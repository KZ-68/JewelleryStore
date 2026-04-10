<?php

namespace App\Contracts;

use App\Models\Order;

interface OrderListRepositoryInterface
{
    public function getAllOrders(array $filters);
    public function getOrderByReference(string $reference): Order|array;
}