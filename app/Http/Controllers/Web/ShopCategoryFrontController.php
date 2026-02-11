<?php
/* 
* Front Controller File for the shop category pages
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\Json;
use App\Models\Product;
use App\Models\TaxRule;
use App\Models\Category;
use App\Models\TaxRuleGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Services\Tax\TaxCalculatorService;

class ShopCategoryFrontController extends Controller
{
    /**
    * Show shop category products list view
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function showCategoryProducts(Request $request): Response|RedirectResponse
    {
        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'quantity', 'price_ht', 'retail_price', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $category = Category::where('slug', $request->slug)->firstOrFail();
        $categoryProducts = $category->products;
        // $categoryProducts = Category::productsByCategoryId($request->category_id);

        return Inertia::render('web/ShopCategoryProducts', [
            'products' => $categoryProducts,
            'category_slug' => $category->slug,
            'filters' => [
                'sortBy' => $sortBy,
                'order' => $order,
            ],
        ]);
    }
}