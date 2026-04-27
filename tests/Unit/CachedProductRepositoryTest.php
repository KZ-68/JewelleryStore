<?php

namespace Tests\Unit;

use App\Contracts\ProductListRepositoryInterface;
use App\Repositories\CachedProductRepository;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CachedProductRepositoryTest extends TestCase
{

    public function test_getAllProducts_returns_data_from_inner_repository_on_cache_miss(): void
    {
        $filters  = ['category' => 'rings'];
        $expected = [['id' => 1, 'name' => 'Gold Ring']];

        $inner = $this->createMock(ProductListRepositoryInterface::class);
        $inner->expects($this->once())
              ->method('getAllProducts')
              ->with($filters)
              ->willReturn($expected);

        Cache::shouldReceive('remember')
             ->once()
             ->andReturnUsing(fn ($key, $ttl, $callback) => $callback());

        $repo   = new CachedProductRepository($inner);
        $result = $repo->getAllProducts($filters);

        $this->assertSame($expected, $result);
    }

    public function test_getAllProducts_returns_cached_data_without_hitting_inner_repository(): void
    {
        $filters  = ['category' => 'necklaces'];
        $cached   = [['id' => 2, 'name' => 'Silver Necklace']];

        $inner = $this->createMock(ProductListRepositoryInterface::class);
        $inner->expects($this->never())->method('getAllProducts');

        Cache::shouldReceive('remember')
             ->once()
             ->andReturn($cached);

        $repo   = new CachedProductRepository($inner);
        $result = $repo->getAllProducts($filters);

        $this->assertSame($cached, $result);
    }

    public function test_getAllProducts_uses_different_cache_key_per_filter_combination(): void
    {
        $filtersA = ['category' => 'rings'];
        $filtersB = ['category' => 'bracelets'];

        $keyA = 'products.' . md5(serialize($filtersA));
        $keyB = 'products.' . md5(serialize($filtersB));

        $this->assertNotSame($keyA, $keyB);
    }

    public function test_getAllProducts_cache_key_is_stable_for_same_filters(): void
    {
        $filters = ['category' => 'earrings', 'sort' => 'price_asc'];

        $keyFirst  = 'products.' . md5(serialize($filters));
        $keySecond = 'products.' . md5(serialize($filters));

        $this->assertSame($keyFirst, $keySecond);
    }
}
