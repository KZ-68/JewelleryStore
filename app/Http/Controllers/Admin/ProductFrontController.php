<?php
/* 
* Front Controller File for the product page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Nette\Utils\Json;

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

        if(!$product) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/ProductDetails', [
            'slug' => $product->slug,
            'product' => $product
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
    * This method validate every fields used in the new product form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        if($request->get('categories_selected') !== null) {
            $categories = json_decode($request->get('categories_selected'), true);
        } else {
            $categories = $request->get('category_id');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|min:0|max:500',
            'reference' => 'required|string|max:100',
            'ean13' => 'string|nullable|max:13',
            'quantity' => 'required|integer|numeric|min:0|max:10000000',
            'retailPrice' => 'required|decimal:0,2',
            'active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/products')
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Product;
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->reference = $request->get('reference');
        $product->ean13 = $request->get('ean13');
        $product->quantity = $request->get('quantity');
        $product->retailPrice = $request->get('retailPrice');
        $product->active = $request->get('active');
        $product->save();
        $product->categories()->attach($categories);
        $product->save();

        return redirect('/admin/back-office/products');
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
            'description' => 'string|min:0|max:500',
            'reference' => 'required|string|max:100',
            'ean13' => 'string|nullable|max:13',
            'quantity' => 'required|integer|numeric|min:0|max:10000000',
            'retailPrice' => 'required|decimal:0,2'        
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/products')
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::where('name', $request->get('name'))->first();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->reference = $request->get('reference');
        $product->ean13 = $request->get('ean13');
        $product->quantity = $request->get('quantity');
        $product->retailPrice = $request->get('retailPrice');
        $product->save();

        return redirect('/admin/back-office/products');
    }
}