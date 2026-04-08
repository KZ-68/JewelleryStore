<?php

namespace App\Contracts;

interface ProductListRepositoryInterface
{
    public function getAllProducts(array $filters);
}