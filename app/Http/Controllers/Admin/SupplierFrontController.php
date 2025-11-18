<?php
/* 
* Front Controller File for the supplier page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SupplierFrontController extends Controller
{
        /**
    * Show supplier details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $supplier = Supplier::where('slug', $request->slug)->firstOrFail();

        if(!$supplier) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/SupplierDetails', [
            'slug' => $supplier->slug,
            'supplier' => $supplier
        ]);
    }

    /**
    * Create supplier view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newSupplier(Request $request): Response|RedirectResponse
    {
        return Inertia::render('admin/NewSupplier', []);
    }

    /**
    * This method validate every fields used in the new supplier form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/suppliers')
                ->withErrors($validator)
                ->withInput();
        }

        $supplier = new Supplier;
        $supplier->name = $request->get('name');
        $supplier->save();

        return redirect('/admin/back-office/suppliers');
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
            return redirect('/admin/back-office/suppliers')
                ->withErrors($validator)
                ->withInput();
        }

        $supplier = Supplier::where('name', $request->get('name'))->first();
        $supplier->save();

        return redirect('/admin/back-office/suppliers');
    }
}