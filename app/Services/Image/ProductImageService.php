<?php

namespace App\Services\Image;

use App\Contracts\ProductImageServiceInterface;
use Illuminate\Support\Facades\Storage;

class ProductImageService implements ProductImageServiceInterface
{
    protected string $storagePath = 'app/public';
    protected string $basePath = 'img/p';
    protected array $cache = [];

    public function getProductImages(int|string $productId): array
    {
        if (isset($this->cache[$productId])) {
            return $this->cache[$productId];
        }

        $directory = "{$this->basePath}/{$productId}";

        if (!Storage::disk('public')->exists($directory)) {
            return $this->cache[$productId] = [];
        }

        $files = Storage::disk('public')->files($directory);

        return $this->cache[$productId] = collect($files)
            ->filter(fn ($file) => str_contains(basename($file), 'product-'))
            ->sortBy(function ($file) {
                preg_match('/^product-\d+\.jpg$/', basename($file), $matches);
                return isset($matches[1]) ? (int) $matches[1] : 0;
            })
            ->map(fn ($file) => Storage::url($file))
            ->values()
            ->toArray();
    }

    public function getFirstImage(int|string $productId): ?string
    {
        return $this->getProductImages($productId)[0] ?? null;
    }
}