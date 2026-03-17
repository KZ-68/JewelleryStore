<?php

namespace App\Http\Controllers\Web;

use App\Contracts\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;


class HomeFrontController extends Controller
{
    public function show(ProductImageServiceInterface $image): Response
    {
        $products = Product::All();
        $topProducts = $this->topProducts($products, $image);

        return Inertia::render('Home', [
            'topProducts' => $topProducts
        ]);
    }

    public function topProducts (Collection $products, ProductImageServiceInterface $image)
    {
        $products = Product::orderBy('created_at', 'desc')->limit(8)->get();
        foreach ($products as $product) {
            $product->image = $image->getFirstImage($product->id);
        }
        return $products;
    }
}