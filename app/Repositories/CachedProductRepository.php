<?php

namespace App\Repositories;

use App\Contracts\ProductListRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CachedProductRepository implements ProductListRepositoryInterface
{
    private const TTL_SECONDS = 300;

    public function __construct(
        private readonly ProductListRepositoryInterface $inner
    ) {}

    public function getAllProducts(array $filters)
    {
        $cacheKey = 'products.' . md5(serialize($filters));

        return Cache::remember($cacheKey, self::TTL_SECONDS, function () use ($filters) {
            return $this->inner->getAllProducts($filters);
        });
    }
}
