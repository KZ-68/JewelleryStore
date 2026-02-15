<?php
/* 
* Front Controller File for the shop product pages
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Models\TaxRule;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Tax\TaxCalculatorService;

class ShopProductFrontController extends Controller
{
    /**
    * Show shop product list view
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function shopProductsList(Request $request): Response|RedirectResponse
    {
        
        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'quantity', 'price_ht', 'retail_price', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $products = Product::all();
        $categories = Category::all();

        return Inertia::render('web/ShopProductsList', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'sortBy' => $sortBy,
                'order' => $order,
            ],
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

    public function showShopProduct (Request $request): Response|RedirectResponse
    {
        $product = Product::where('slug', $request->slug)->firstOrFail();
        $selectedTaxRuleGroup = $product->taxRuleGroup;
        $taxRule = TaxRule::where('tax_rule_group_id', $selectedTaxRuleGroup->id)->firstOrFail();
        $tax = $taxRule->tax;
        $calculator = new TaxCalculatorService;
        $priceWithTax = $calculator->withTax($product->price_ht, $tax->rate);

        return Inertia::render('web/ShopProductPage', [
            'product' => $product,
            'price' => $priceWithTax
        ]);
    }
}