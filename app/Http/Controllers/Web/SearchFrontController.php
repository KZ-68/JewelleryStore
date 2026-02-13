<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchFrontController extends Controller
{
    public function searchProducts(Request $request): JsonResponse
    {
        $products = Product::where('active', 1)->where('name', 'like', $request->get('text') . '%')->get();

        if(count($products) === 0) {
            $products = null;
        }

        return response()->json([
            'results' => $products
        ]);
    }
}