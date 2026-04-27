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
    public function showRuleGroup(Request $request): Response|RedirectResponse
    {
        $taxRuleGroup = TaxRuleGroup::where('slug', $request->slug)->first();
        $taxRules = $taxRuleGroup->taxRules;
        $countries = Country::all();
        $taxes = Tax::all();

        if(!$taxRuleGroup) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/TaxRuleGroupDetails', [
            'taxRuleGroup' => $taxRuleGroup,
            'taxRules' => $taxRules,
            'countries' => $countries,
            'taxes' => $taxes
        ]);
    }

    /**
    * Tax Rule Group creation form view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newTaxRuleGroup(Request $request): Response|RedirectResponse
    {
        $taxes = Tax::all();
        $countries = Country::all();
        return Inertia::render('admin/NewTaxRuleGroup', [
            'taxes' => $taxes,
            'countries' => $countries
        ]);
    }

    /**
    * This method validate every fields used in the new tax rule group form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function createRuleGroup(Request $request): RedirectResponse
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
        $taxRuleGroup->name = $request->input('name');
        $taxRuleGroup->active = $request->input('active');
        $taxRuleGroup->save();
        $taxRuleGroup = TaxRuleGroup::where('name', $request->input('name'))->first();
        $selectedCountries = json_decode($request->input('selected-countries'), true);
        if(count($selectedCountries) > 1) {
            foreach ($selectedCountries as $countryLocal) {
                $taxRule = new TaxRule;
                $taxRule->tax()->associate(Tax::where('name', $request->input('tax'))->first());
                $taxRule->country()->associate(Country::where('local', $countryLocal)->first());
                $taxRule->taxRuleGroup()->associate($taxRuleGroup);
                $taxRule->behavior = $request->input('behavior');
                $taxRule->rate_order = $request->input('rate_order');
                $taxRule->save();
                $taxRule = null;
            }
        } else {
            $taxRule = new TaxRule;
            $taxRule->tax()->associate(Tax::where('name', $request->input('tax'))->first());
            $taxRule->country()->associate(Country::where('local', $request->input('countries'))->first());
            $taxRule->taxRuleGroup()->associate($taxRuleGroup);
            $taxRule->behavior = $request->input('behavior');
            $taxRule->rate_order = $request->input('rate_order');
            $taxRule->save();
        }
        
        return redirect('/admin/back-office/taxes');
    }

    /**
    * This method validate every fields used in the tax rule group details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function updateRuleGroup(Request $request): RedirectResponse
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

        $taxRuleGroup = TaxRuleGroup::where('name', $request->input('name'))->first();
        $taxRuleGroup->active = $request->input('active');
        $taxRuleGroup->save();
        $taxRules = $taxRuleGroup->taxRules;

        foreach ($taxRules as $taxRule) {
            $taxRule->tax()->disassociate();
            $taxRule->tax()->associate(Tax::where('name', $request->input('tax'))->first());
            $taxRule->country()->disassociate();
            $taxRule->country()->associate(Country::where('id', $request->input('selected-country'))->first());
            $taxRule->taxRuleGroup()->disassociate();
            $taxRule->taxRuleGroup()->associate($taxRuleGroup);
            $taxRule->behavior = $request->input('behavior');
            $taxRule->rate_order = $request->input('rate_order');
            $taxRule->save();
            
        }
        
        return redirect('/admin/back-office/taxes/rule-groups');
    }
}