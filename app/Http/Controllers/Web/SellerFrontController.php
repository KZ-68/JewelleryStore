<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SellerTaxInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;


class SellerFrontController extends Controller
{
    /**
     * Show the registration page.
     */
    public function registerSeller(): Response
    {
        $countries = Country::all();
        return Inertia::render('web/SellerRegistration', [
            'countries' => $countries
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Customer::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tax_country' => 'required|string|max:2',
            'tax_type' => 'required|string|max:20',
            'tax_number' => 'required|string|max:20',
            'tax_scheme' => 'required|string|max:50',
            'reduced_tax_rate' => 'required|decimal:0,2',
            'tax_registration_status' => 'required|string|max:20',
            'invoice_tax_label' => 'string|nullable',
            'qualified_invoice_number' => 'string|nullable',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer->assignRole('seller');
        event(new Registered($customer));

        $seller = new Seller();
        $seller->save();
        $sellerTaxInformation = new SellerTaxInformation();
        $sellerTaxInformation->tax_country = $request->get('tax_country');
        $sellerTaxInformation->tax_type = $request->get('tax_type');
        $sellerTaxInformation->tax_number = $request->get('tax_number');
        $sellerTaxInformation->tax_scheme = $request->get('tax_scheme');
        $sellerTaxInformation->reduced_tax_rate = $request->get('reduced_tax_rate');
        $sellerTaxInformation->tax_registration_status = $request->get('tax_registration_status');
        $sellerTaxInformation->invoice_tax_label = $request->get('invoice_tax_label') ?? null;
        $sellerTaxInformation->requires_tax_invoice = true;
        $sellerTaxInformation->qualified_invoice_number = $request->get('qualified_invoice_number') ?? null;
        $sellerTaxInformation->seller()->associate($seller);
        $sellerTaxInformation->save();

        return to_route('home');
    }

    public function sellerPage(Request $request) : RedirectResponse|Response 
    {
        $customer = Auth::guard('web')->user();
        $seller = Seller::where('customer_id', $customer->id)->firstOrFail();
        $sellerTaxInformation = $seller->sellerTaxInfo;
        if ($sellerTaxInformation->validation_status == 'Waiting approval') {
            return redirect('/settings');
        }

        $sortBy = $request->get('sortBy', 'id');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['id', 'name', 'created_at'])) {
            $sortBy = 'id';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $products = Product::where('seller_id', $seller->id)->orderBy($sortBy, $order)->get();

        return Inertia::render(
            'settings/SellerPage', 
            [
                'products' => $products,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }

    public function messagesBox(Request $request): RedirectResponse|Response
    {
        $customer = Auth::guard('web')->user();
        $seller = Seller::where('customer_id', $customer->id)->firstOrFail();
        $sellerTaxInformation = $seller->sellerTaxInfo;
        if (!$seller || $sellerTaxInformation->validation_status == 'Waiting approval') {
            return redirect('/settings');
        }

        $messagesReceived = Message::where('to_email', $customer->email);
        $messagesSended = Message::where('from_email', $customer->email);
        return Inertia::render(
            'settings/MessagesBox', 
            [
                'messagesReceived' => $messagesReceived,
                'messagesSended' => $messagesSended
            ]
        );
    }
}