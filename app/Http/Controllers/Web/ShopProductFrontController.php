<?php
/* 
* Front Controller File for the shop product pages
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

class ShopProductFrontController extends Controller
{
    /**
    * Show shop product list view
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function shopProductsList(): Response|RedirectResponse
    {
        $products = Product::all();
        $categories = Category::all();

        return Inertia::render('web/ShopProductsList', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function shopRetailPrice (Request $request): JsonResponse
    {
        $product = Product::where('slug', $request->slug)->firstOrFail();
        $selectedTaxRuleGroup = $product->taxRuleGroup;
        $taxRule = TaxRule::where('tax_rule_group_id', $selectedTaxRuleGroup->id)->firstOrFail();
        $tax = $taxRule->tax;
        $calculator = new TaxCalculatorService;
        $priceWithTax = $calculator->withTax($product->price_ht, $tax->rate);

        return response()->json([
            'price' => $priceWithTax,
        ]);
    }
}