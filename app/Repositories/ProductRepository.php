<?php

namespace App\Repositories;

use App\Contracts\ProductListRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductListRepositoryInterface
{
    public function getAllProducts(array $filters)
    {
        return Product::query()
            ->when(!empty($filters['feature_value_ids']), function ($query) use ($filters) {
                foreach ($filters['feature_value_ids'] as $featureValueId) {
                    $query->whereHas('feature_values', function ($q) use ($featureValueId) {
                        $q->where('feature_values.id', $featureValueId);
                    });
                }
            })
            ->orderBy($filters['sortBy'], $filters['orderBy'])
            ->get();
    }
}