<?php
/* 
* Front Controller File for the tax page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Tax;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TaxFrontController extends Controller
{
    /**
    * Show tax details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $tax = Tax::where('slug', $request->slug)->firstOrFail();

        if(!$tax) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/TaxDetails', [
            'tax' => $tax
        ]);
    }

    /**
    * Tax creation form view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newTax(Request $request): Response|RedirectResponse
    {
        return Inertia::render('admin/NewTax', []);
    }

    /**
    * This method validate every fields used in the new tax form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|decimal:0,2',     
            'applicable' => 'required|boolean',
            'type' => 'required|string|max:20',
            'description' => 'string|nullable|max:128'
        ]);

        if ($validator->fails()) {
            dd('test');
            return redirect('/admin/back-office/taxes')
                ->withErrors($validator)
                ->withInput();
        }

        $tax = new Tax;
        $taxRatePercent = $request->input('rate') * 100;
        $tax->name = "{$request->input('type')} {$taxRatePercent} %";
        $tax->rate = $request->input('rate');
        $tax->applicable = $request->input('applicable');
        $tax->type = $request->input('type');
        if($request->input('description') !== null) {
            $tax->description = $request->input('description');
        }

        $tax->save();

        return redirect('/admin/back-office/taxes');
    }

    /**
    * This method validate every fields used in the product details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|decimal:0,2',     
            'applicable' => 'required|boolean',
            'type' => 'required|string|max:20',
            'description' => 'string|nullable|max:128'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/taxes')
                ->withErrors($validator)
                ->withInput();
        }

        $tax = Tax::where('name', $request->input('name'))->first();
        $tax->rate = $request->input('rate');
        $tax->applicable = $request->input('applicable');
        $tax->type = $request->input('type');
        if($request->input('description') !== null) {
            $tax->description = $request->input('description');
        }

        $tax->save();

        return redirect('/admin/back-office/taxes');
    }
}