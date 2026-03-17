<?php

namespace App\Contracts;

interface ProductImageServiceInterface
{
    public function getProductImages(int|string $productId): array;

    public function getFirstImage(int|string $productId): ?string;
}