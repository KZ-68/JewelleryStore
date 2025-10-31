<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('web/Contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'required', 'string', 'lowercase', 'max:255'],
            'subject' => ['required', 'string', 'max:174'],
            'message' => ['required', 'textarea', 'string', 'min:3', 'max:500'],
            'agreed' => ['required', 'checkbox', 'boolean', 'value:true'],
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
