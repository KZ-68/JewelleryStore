<?php
/* 
* Front Controller File for the manufacturer page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer;

class ManufacturerFrontController extends Controller
{
    /**
    * Show manufacturer details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $manufacturer = Manufacturer::where('slug', $request->slug)->firstOrFail();

        if(!$manufacturer) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/ManufacturerDetails', [
            'slug' => $manufacturer->slug,
            'manufacturer' => $manufacturer
        ]);
    }

    /**
    * Create manufacturer view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newManufacturer(Request $request): Response|RedirectResponse
    {
        return Inertia::render('admin/NewManufacturer', []);
    }

    /**
    * This method validate every fields used in the new manufacturer form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/manufacturers')
                ->withErrors($validator)
                ->withInput();
        }

        $manufacturer = new Manufacturer;
        $manufacturer->name = $request->get('name');
        $manufacturer->save();

        return redirect('/admin/back-office/manufacturers');
    }

    /**
    * This method validate every fields used in the manufacturer details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',     
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/manufacturers')
                ->withErrors($validator)
                ->withInput();
        }

        $manufacturer = Manufacturer::where('name', $request->get('name'))->first();
        $manufacturer->name = $request->get('name');
        $manufacturer->save();

        return redirect('/admin/back-office/manufacturers');
    }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroy(Request $request): RedirectResponse
    {
        $manufacturer = Manufacturer::where('name', $request->get('name'))->first();
        $manufacturer->delete();

        return redirect('/admin/back-office/manufacturers');
    }

    /**
    * This method validate data and confirm the deletion.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function destroyBulk(Request $request): RedirectResponse
    {
        $manufacturers = Manufacturer::whereIn('name', $request->get('names'))->get();
        foreach($manufacturers as $manufacturer) {
            $manufacturer->delete();
        }

        return redirect('/admin/back-office/manufacturers');
    }
}