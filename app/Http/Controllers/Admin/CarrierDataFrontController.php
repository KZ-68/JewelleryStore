<?php
/* 
* Front Controller File for the carrier page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use App\Models\Carrier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class CarrierDataFrontController extends Controller
{
    /**
    * This method validate every fields used in the new shipping rate form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function carrierManagementUpdate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/carriers')
                ->withErrors($validator)
                ->withInput();
        }

        $carrier = Carrier::where('name', $request->input('name'))->first();
        $carrier->name = $request->input('name');
        $carrier->description = $request->input('description');
        $carrier->save();
        $shippingRate = new ShippingRate();
        $shippingRate->min_total = $request->input('min_total');
        $shippingRate->max_total = $request->input('max_total');
        $shippingRate->price = $request->input('price');
        $shippingRate->save();
        $carrier->shippingRates()->associate($shippingRate);
        
        return redirect('/admin/back-office/carriers');
    }
}