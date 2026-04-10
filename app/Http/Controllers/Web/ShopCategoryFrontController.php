<?php
/* 
* Front Controller File for the shop category pages
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ShopCategoryFrontController extends Controller
{
    /**
    * Show shop category products list view
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function showCategoryProducts(Request $request): Response|RedirectResponse
    {
        $filters = $this->extractFilters($request);
        $category = Category::where('slug', $request->category_slug)->firstOrFail();

        $categoryProducts = $category->products()
            ->when(!empty($filters['feature_value_ids']), function ($query) use ($filters) {
                foreach ($filters['feature_value_ids'] as $featureValueId) {
                    $query->whereHas('feature_values', function ($q) use ($featureValueId) {
                        $q->where('feature_values.id', $featureValueId);
                    });
                }
            })
            ->orderBy($filters['sortBy'], $filters['orderBy'])
            ->get();

        $availableFeatures = Feature::with(['values' => function ($q) use ($category) {
                $q->whereHas('products', function ($q) use ($category) {
                    $q->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id));
                });
            }])
            ->whereHas('values.products.categories', fn ($q) => $q->where('categories.id', $category->id))
            ->get();

        return Inertia::render('web/ShopCategoryProducts', [
            'products'          => $categoryProducts,
            'category_slug'     => $category->slug,
            'category_name'     => $category->name,
            'filters'           => $filters,
            'availableFeatures' => $availableFeatures,
        ]);
    }

    private function extractFilters(Request $request): array
    {
        $allowedSorts = ['name', 'quantity', 'name', 'price_ht', 'retail_price', 'created_at'];
        $allowedOrders = ['asc', 'desc'];

        $sortBy  = $request->input('sortBy', 'name');
        $orderBy = strtolower($request->input('orderBy', 'asc'));

        $featureValueIds = array_values(array_filter(
            array_map('intval', (array) $request->input('feature_value_ids', [])),
            fn (int $id) => $id > 0
        ));

        return [
            'sortBy'           => in_array($sortBy, $allowedSorts) ? $sortBy : 'name',
            'orderBy'          => in_array($orderBy, $allowedOrders) ? $orderBy : 'asc',
            'feature_value_ids' => $featureValueIds,
        ];
    }
}