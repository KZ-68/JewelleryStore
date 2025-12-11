<?php
/* 
* Front Controller File for the carrier page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Carrier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CarrierFrontController extends Controller
{
    /**
    * Show carrier details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $carrier = Carrier::where('slug', $request->slug)->firstOrFail();

        if(!$carrier) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/CarrierDetails', [
            'slug' => $carrier->slug,
            'carrier' => $carrier
        ]);
    }

    /**
    * Create carrier view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newCarrier(Request $request): Response|RedirectResponse
    {
        $countries = Country::all();
        
        return Inertia::render('admin/NewCarrier', [
            'countries' => $countries,
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
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/carriers')
                ->withErrors($validator)
                ->withInput();
        }

        $carrier = new Carrier;
        $carrier->name = $request->get('name');
        $carrier->save();

        return redirect('/admin/back-office/carriers');
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
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/carriers')
                ->withErrors($validator)
                ->withInput();
        }

        $carrier = Carrier::where('name', $request->get('name'))->first();
        $carrier->name = $request->get('name');
        $carrier->save();

        return redirect('/admin/back-office/carriers');
    }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroy(Request $request): RedirectResponse
    {
        $category = Carrier::where('name', $request->get('name'))->first();
        $category->delete();

        return redirect('/admin/back-office/carriers');
    }
}