<?php
/* 
* Front Controller File for the feature page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class FeatureFrontController extends Controller
{
    /**
    * Show feature details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function featureDetail(Request $request): Response|RedirectResponse
    {
        $feature = Feature::with('feature_values')->where('slug', $request->slug)->firstOrFail();
        $featureValues = $feature->feature_values;

        if(!$feature) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/FeatureDetails', [
            'slug' => $feature->slug,
            'feature' => $feature,
            'feature_values' => $featureValues
        ]);
    }

    /**
    * Create feature view
    * @param Request Get the request, via GET method
    */
    public function newFeature(): Response
    {
        return Inertia::render('admin/NewFeature', []);
    }

    /**
    * This method validate every fields used in the new feature form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/features')
                ->withErrors($validator)
                ->withInput();
        }

        $feature = new Feature;
        $feature->name = $request->input('name');
        $feature->save();

        return redirect('/admin/back-office/features');
    }

    /**
    * This method validate every fields used in the feature details form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/features')
                ->withErrors($validator)
                ->withInput();
        }

        $feature = Feature::where('name', $request->input('name'))->first();
        $feature->name = $request->input('name');
        $feature->save();

        return redirect('/admin/back-office/features');
    }
}