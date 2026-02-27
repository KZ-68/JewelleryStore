<?php

namespace App\Http\Controllers\Web;

use App\Contracts\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchFrontController extends Controller
{
    public function searchProducts(Request $request, ProductImageServiceInterface $image): JsonResponse
    {
        $products = Product::where('active', 1)->where('name', 'like', $request->get('text') . '%')->get();

        if(count($products) === 0) {
            $products = null;
        }

        foreach ($products as $product) {
            $product->image = $image->getFirstImage($product->id);
        }

        return response()->json([
            'results' => $products
        ]);
    }
}