<?php
/* 
* Front Controller File for the product page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\Json;
use App\Models\Product;
use App\Models\TaxRule;
use App\Models\Category;
use App\Models\TaxRuleGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Image\ImageUploader;
use App\Services\Tax\TaxCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ProductFrontController extends Controller
{
    /**
    * Show product details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $product = Product::where('slug', $request->slug)->firstOrFail();
        $taxRuleGroups = TaxRuleGroup::all();
        $selectedTaxRuleGroup = $product->taxRuleGroup;
        if ($selectedTaxRuleGroup !== null) {
            $taxRule = TaxRule::where('tax_rule_group_id', $selectedTaxRuleGroup->id)->firstOrFail();
            $tax = $taxRule->tax;
            $calculator = new TaxCalculatorService;
            $priceWithTax = $calculator->withTax($product->price_ht, $tax->rate);
        }

        if(!$product) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/ProductDetails', [
            'slug' => $product->slug,
            'product' => $product,
            'taxRuleGroups' => $taxRuleGroups,
            'priceWithTax' => $priceWithTax ?? null,
            'taxRuleGroupId' => $selectedTaxRuleGroup->id ?? ''
        ]);
    }

    /**
    * Create product view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newProduct(Request $request): Response|RedirectResponse
    {
        $categories = Category::all();

        $tree = $categories->map(function ($cat) {
            return [
                $cat->id => [
                    'text' => $cat->name,
                    'children' => $cat->subCategories->map(function ($sub) {
                        return "$sub->id";
                    }),
                    'state' => [
                        'checked' => false,
                        'indeterminate'=> false,
                        'draggable'=> true,
                        'dropable'=> false
                    ]
                ]
            ];
        });

        Json::encode($tree, true);

        return Inertia::render('admin/NewProduct', [
            'categories' => $tree
        ]);
    }

    /**
    * Preview the price with tax for a given price_ht and tax_rule_group_id.
    * @param Request GET request with price_ht and tax_rule_group_id query params
    * @return JsonResponse Return the computed price with tax
    */
    public function pricePreview(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'price_ht'          => 'required|numeric|min:0',
            'tax_rule_group_id' => 'required|integer|exists:tax_rule_groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $taxRule = TaxRule::where('tax_rule_group_id', $request->integer('tax_rule_group_id'))->first();

        if (!$taxRule) {
            return response()->json(['error' => 'No tax rule found for this group.'], 404);
        }

        $calculator = new TaxCalculatorService;
        $priceWithTax = $calculator->withTax((float) $request->input('price_ht'), $taxRule->tax->rate);

        return response()->json(['price_with_tax' => $priceWithTax]);
    }

    /**
    * This method validate every fields used in the new product form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        if($request->input('categories_selected') !== null) {
            $categories = json_decode($request->input('categories_selected'), true);
        } else {
            $categories = $request->input('category_id');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|min:0|max:500',
            'reference' => 'required|string|max:100',
            'ean13' => 'string|nullable|max:13',
            'quantity' => 'required|integer|numeric|min:0|max:10000000',
            'price_ht' => 'required|decimal:0,2',
            'cost_price' => 'required|decimal:0,2',
            'active' => 'required|boolean',
            'image' => 'nullable|file|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect('{locale}/admin/back-office/products')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'This product is invalid, please fill in all required fields correctly.');
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->reference = $request->input('reference');
        $product->ean13 = $request->input('ean13');
        $product->quantity = $request->input('quantity');
        $product->price_ht = $request->input('price_ht');
        $product->cost_price = $request->input('cost_price');
        $product->active = $request->input('active');
        $product->save();
        $product->categories()->attach($categories);
        $product->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $uploader = new ImageUploader('public');
                $uploader->uploadForProduct($request->file('image'), $product->id);
            } catch (\InvalidArgumentException $e) {
                return redirect('/admin/back-office/products')
                    ->with('warning', 'Product "' . $product->name . '" created but image upload failed: ' . $e->getMessage());
            }
        }

        return redirect('/admin/back-office/products')
            ->with('success', 'Product "' . $product->name . '" has been created successfully.');
    }

    /**
    * This method validate every fields used in the product details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|nullable|min:0|max:500',
            'reference' => 'required|string|max:100',
            'ean13' => 'string|nullable|max:13',
            'quantity' => 'required|integer|numeric|min:0|max:10000000',
            'price_ht' => 'required|decimal:0,2',
            'cost_price' => 'required|decimal:0,2'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/products')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'This product is invalid, please fill in all required fields correctly.');
        }

        $product = Product::where('name', $request->input('name'))->first();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->reference = $request->input('reference');
        $product->ean13 = $request->input('ean13');
        $product->quantity = $request->input('quantity');
        $product->price_ht = $request->input('price_ht');
        $product->cost_price = $request->input('cost_price');
        if($request->input('tax_rule_group_id') !== null) {
            $taxCalculator = new TaxCalculatorService;
            $taxRule = TaxRule::where('id', $request->input('tax_rule_group_id'))->first();
            $product->retail_price = $taxCalculator->withTax($request->input('price_ht'), $taxRule->tax->rate);
            $product->taxRuleGroup()->associate($request->input('tax_rule_group_id'));
        }
        $product->save();

        return redirect('/admin/back-office/products')
            ->with('success', 'Product "' . $product->name . '" has been updated successfully.');
    }
}