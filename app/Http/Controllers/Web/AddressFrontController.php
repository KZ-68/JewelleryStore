<?php
/* 
* Front Controller File for the address page connected to the Back Office section 
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AddressFrontController extends Controller
{
    /**
    * Show addresses view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function showAddresses(Request $request): Response|RedirectResponse
    {
        $addresses = Address::all();

        return Inertia::render('settings/Addresses', [
            'addresses' => $addresses
        ]);
    }

    /**
    * Create carrier view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newAddress(Request $request): Response|RedirectResponse
    {
        $countries = Country::all();

        return Inertia::render('settings/NewAddress', [
            'countries' => $countries
        ]);
    }

    /**
    * This method validate every fields used in the new address form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'address_line_1' => 'required|string|min:3|max:255',
            'address_line_2' => 'nullable|string|min:0|max:255',
            'city' => 'string|max:200',
            'region' => 'nullable|string|min:0|max:255',
            'district' => 'nullable|string|min:0|max:255',
            'sub_district' => 'nullable|string|min:0|max:255',
            'locality' => 'nullable|string|min:0|max:255',
            'sub_locality' => 'nullable|string|min:0|max:255',
            'country' => 'nullable|string',
        ]);

        $isOrder = $request->boolean('isOrder');

        if ($validator->fails()) {
            if($isOrder === true) {
                return redirect('/order')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                return redirect('/settings/addresses')
                ->withErrors($validator)
                ->withInput();
            }
        }

        $user = $request->user();
        $customer = Customer::where('email', $user->email)->first();
        $address = new Address;
        $country = Country::where('local', $request->input('country'))->first();
        $address->customer_id = $customer->id;
        $address->country_id = $country->id;
        $address->name = $request->input('name');
        $address->address_line_1 = $request->input('address_line_1');
        $address->address_line_2 = $request->input('address_line_2');
        $address->city = $request->input('city');
        $address->postal_code = $request->input('postal_code');
        $address->region = $request->input('region');
        $address->district = $request->input('district');
        $address->sub_district = $request->input('sub_district');
        $address->locality = $request->input('locality');
        $address->sub_locality = $request->input('sub_locality');
        $address->save();

        if($isOrder === true) {
            return redirect()->route('order.showOrderPage');;
        } else {
            return redirect('/settings/addresses');
        }
    }

    // /**
    // * This method validate every fields used in the address details form.
    // * @param Request Get the POST method body from the form
    // * @return RedirectResponse Send a response with a redirection
    // */
    // public function update(Request $request): RedirectResponse
    // {
    //     $validator = Validator::make($request->all(), [
    //          'address_line_1' => 'required|string|max:255',
    //          'address_line_2' => 'string|max:255',
    //          'city' => 'required|string|max:200',
    //          'postal_code' => 'string|max:10',
    //          'region' => 'string|max:255',
    //          'district' => 'string|max:255',
    //          'sub_district' => 'string|max:255',
    //          'locality' => 'string|max:255',
    //          'sub_locality' => 'string|max:255',
    //          'country_name' => 'string|max:200',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect('/settings/addresses')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $address = Address::where('address_line_1', $request->input('address_line_1'))->first();
    //     $address->address_line_1 = $request->input('address_line_1');
    //     $address->address_line_2 = $request->input('address_line_2');
    //     $address->city = $request->input('city');
    //     $address->postal_code = $request->input('postal_code');
    //     $address->region = $request->input('region');
    //     $address->district = $request->input('district');
    //     $address->sub_district = $request->input('sub_district');
    //     $address->locality = $request->input('locality');
    //     $address->sub_locality = $request->input('sub_locality');
    //     $address->save();

    //     return redirect('/settings/addresses');
    // }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function deleteAddress(Request $request): RedirectResponse
    {
        $address = Address::where('name', $request->input('name'))->first();
        $address->delete();

        return redirect('/settings/adresses');
    }
}