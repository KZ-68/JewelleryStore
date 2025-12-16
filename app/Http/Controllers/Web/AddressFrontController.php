<?php
/* 
* Front Controller File for the address page connected to the Back Office section 
*/

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Country;

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
    * This method validate every fields used in the new carrier form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'string|max:255',
            'city' => 'required|string|max:200',
            'postal_code' => 'string|max:10',
            'region' => 'string|max:255',
            'district' => 'string|max:255',
            'sub_district' => 'string|max:255',
            'locality' => 'string|max:255',
            'sub_locality' => 'string|max:255',
            'country_name' => 'string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect('/settings/addresses')
                ->withErrors($validator)
                ->withInput();
        }

        $address = new Address;
        $address->name = $request->get('name');
        $address->save();

        return redirect('/settings/addresses');
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

    //     $address = Address::where('address_line_1', $request->get('address_line_1'))->first();
    //     $address->address_line_1 = $request->get('address_line_1');
    //     $address->address_line_2 = $request->get('address_line_2');
    //     $address->city = $request->get('city');
    //     $address->postal_code = $request->get('postal_code');
    //     $address->region = $request->get('region');
    //     $address->district = $request->get('district');
    //     $address->sub_district = $request->get('sub_district');
    //     $address->locality = $request->get('locality');
    //     $address->sub_locality = $request->get('sub_locality');
    //     $address->save();

    //     return redirect('/settings/addresses');
    // }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroy(Request $request): RedirectResponse
    {
        $address = Address::where('name', $request->get('name'))->first();
        $address->delete();

        return redirect('/settings/adresses');
    }
}