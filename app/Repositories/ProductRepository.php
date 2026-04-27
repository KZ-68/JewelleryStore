<?php

namespace App\Repositories;

use App\Contracts\ProductListRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductListRepositoryInterface
{
    public function getAllProducts(array $filters)
    {
        return Product::query()
            ->orderBy($filters['sortBy'], $filters['order'])
            ->get();
    }
}