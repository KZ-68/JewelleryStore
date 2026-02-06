<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Http\Helpers\CartHelper;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;


class HomeFrontController extends Controller
{
    public function show(CartHelper $cart): Response
    {
        $products = Product::All();
        $topProducts = $this->topProducts($products);

        return Inertia::render('Home', [
            'topProducts' => $topProducts
        ]);
    }

    public function topProducts (Collection $products)
    {
        $products = Product::orderBy('created_at', 'desc')->limit(8)->get();
        return $products;
    }
}