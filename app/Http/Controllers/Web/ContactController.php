<?php
/* 
* Controller File for the Contact page
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
    * Render the view assigned to the contact page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function create(Request $request): Response
    {
        return Inertia::render('web/Contact');
    }

    /**
    * This method validate every fields used in the contact form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|lowercase|max:255',
            'subject' => 'required|string|max:174',
            'message' => 'required|textarea|string|min:3|max:500',
            'agreed' => 'required|boolean|value:true',
        ]);

        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        return redirect('/contact');
    }
}
