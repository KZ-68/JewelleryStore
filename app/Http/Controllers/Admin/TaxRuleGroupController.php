<?php
/* 
* Front Controller File for the taxRuleGroup page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use App\Models\Tax;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Country;
use App\Models\TaxRule;
use App\Models\TaxRuleGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class TaxRuleGroupFrontController extends Controller
{
    /**
    * Show tax rule group details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $taxRuleGroup = TaxRuleGroup::where('name', $request->name)->firstOrFail();

        if(!$taxRuleGroup) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/TaxRuleGroupDetails', [
            'taxRuleGroup' => $taxRuleGroup
        ]);
    }

    /**
    * Tax Rule Group creation form view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newTaxRuleGroup(Request $request): Response|RedirectResponse
    {
        return Inertia::render('admin/NewTaxRuleGroup', []);
    }

    /**
    * This method validate every fields used in the new tax rule group form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/taxes/rule-groups')
                ->withErrors($validator)
                ->withInput();
        }

        $taxRuleGroup = new TaxRuleGroup;
        $taxRuleGroup->name = $request->get('name');
        $taxRuleGroup->active = $request->get('active');
        $taxRuleGroup->save();
        $taxRuleGroup = TaxRuleGroup::where('name', $request->get('name'))->first();

        if(count($request->get('countries')) > 1) {
            foreach ($request->get('countries') as $country) {
                $taxRule = new TaxRule;
                $taxRule->tax()->associate(Tax::where('name', $request->get('tax'))->first());
                $taxRule->country()->associate(Country::where('local', $country->local)->first());
                $taxRule->taxRuleGroup()->associate($taxRuleGroup);
                $taxRule->save();
                $taxRule = null;
            }
        } else {
            $taxRule = new TaxRule;
            $taxRule->tax()->associate(Tax::where('name', $request->get('tax'))->first());
            $taxRule->country()->associate(Country::where('local', $request->get('countries'))->first());
            $taxRule->taxRuleGroup()->associate($taxRuleGroup);
            $taxRule->save();
        }
        
        return redirect('/admin/back-office/taxes/rule-groups');
    }

    /**
    * This method validate every fields used in the tax rule group details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/taxes/rule-groups')
                ->withErrors($validator)
                ->withInput();
        }

        $taxRuleGroup = TaxRuleGroup::where('name', $request->get('name'))->first();
        $taxRuleGroup->active = $request->get('active');
        $taxRuleGroup->save();

        return redirect('/admin/back-office/taxes/rule-groups');
    }
}