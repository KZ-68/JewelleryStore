<?php
/* 
* Front Controller File for the shop product pages
*/

namespace App\Http\Controllers\Web;

use App\Contracts\ProductImageServiceInterface;
use App\Contracts\ProductListRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Mails\CustomerSellerMessage;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Product;
use App\Models\Seller;
use App\Models\TaxRule;
use App\Services\Tax\TaxCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ShopProductFrontController extends Controller
{

    public function __construct(
        protected ProductImageServiceInterface $image,
        private ProductListRepositoryInterface $productListRepository
    ) {}
    
    /**
    * Show shop product list view
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function shopProductsList(Request $request): Response|RedirectResponse
    {
        $filters = $this->extractFilters($request);
        $products = $this->productListRepository->getAllProducts($filters);
        $categories = Category::all();
        foreach ($products as $product) {
            $product->image = $this->image->getFirstImage($product->id);
        }

        return Inertia::render('web/ShopProductsList', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters
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
        $productImages = $this->image->getProductImages($product->id);
        $sellerId = null;
        if (isset($product->seller_id) && $product->seller_id !== null) {
            $sellerId = $product->seller_id;
            $seller = Seller::with('customer')->where('id', $sellerId)->firstOrFail();
            $customer = $seller->customer()->firstOrFail();
            $sellerName = $customer->name;
        }
        
        return Inertia::render('web/ShopProductPage', [
            'product' => $product,
            'price' => $priceWithTax,
            'productImages' => $productImages,
            'seller_id' => $sellerId,
            'seller_name' => $sellerName ?? null
        ]);
    }

    /**
    * Render the view assigned to the contact seller page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function contactSeller(Request $request): Response
    {
        $sellerId = $request->get('seller_id');
        $seller = Seller::where('id', $sellerId)->firstOrFail();
        $productSlug = $request;
        $user = Auth::guard('web')->user();
        if ($user) {
            $customer = Customer::where('id', $user->id)->firstOrFail();
        }
        
        return Inertia::render('web/ContactSeller', [
            'seller' => $seller,
            'customer' => $customer ?? null,
            'slug' => $productSlug
        ]);
    }

    /**
    * This method validate every fields used in the contact seller form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function validateContactSeller(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:200',
            'seller_id' => 'required|integer',
            'customer_id' => $user ? 'required|integer': 'nullable|integer',
            'from_email' => $user ? 'nullable|string|email|lowercase|max:200': 'required|string|email|lowercase|max:200',
            'from_name' => $user ? 'nullable|string|max:100': 'required|string|max:100',
            'content' => 'required|textarea|string|min:3|max:500'
        ]);

        if ($validator->fails()) {
            return redirect('/contact/seller')
                ->withErrors($validator)
                ->withInput();
        }

        $this->sendMailSeller($request);

        return redirect('/contact/seller')
            ->with(['confirmation' => 'Message has been send to the seller']);
    }

    private function sendMailSeller(Request $request): void
    {
        $seller = Seller::where('seller_id', $request->get('seller_id'))->firstOrFail();
        $sellerCustomerRelation = Customer::whereBelongsTo($seller)->get();
        if ($request->get('customer_id') !== null) {
            $customer = Customer::where('customer_id', $request->get('customer_id'))->firstOrFail();
        } else {
            $fromEmail = $request->get('from_email');
            $fromName = $request->get('from_name');
        }

        $message = Message::create([
            'from_email' => $customer->email ?? $fromEmail,
            'to_email' => $sellerCustomerRelation->email,
            'from_name' => $customer->name ?? $fromName,
            'to_name' => $sellerCustomerRelation->name,
            'subject' => $request->get('subject'),
            'content' => $request->get('content')
        ]);

        Mail::to($request->user())->send(new CustomerSellerMessage($message));
    }

    private function extractFilters(Request $request): array
    {
        $allowedSorts = ['name', 'quantity', 'price_ht', 'retail_price', 'created_at'];
        $allowedOrders = ['asc', 'desc'];

        $sortBy = $request->get('sortBy', 'name');
        $order = strtolower($request->get('order', 'asc'));

        return [
            'sortBy' => in_array($sortBy, $allowedSorts) ? $sortBy : 'name',
            'order' => in_array($order, $allowedOrders) ? $order : 'asc',
        ];
    }
}