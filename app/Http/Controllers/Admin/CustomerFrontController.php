<?php
/* 
* Front Controller File for the customer page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CustomerFrontController extends Controller
{
    /**
    * Show customer details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $customer = Customer::where('id', $request->id)->firstOrFail();

        if(!$customer) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/CustomerDetails', [
            'customer' => $customer
        ]);
    }

    /**
    * Create customer view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function newCustomer(Request $request): Response|RedirectResponse
    {
        return Inertia::render('admin/NewCustomer', []);
    }

    /**
    * This method validate every fields used in the new customer form.
    * @param Request Get the POST method body from the form
    * @return RedirectResponse Send a response with a redirection
    */
    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'current_password' => 'required|current_password',
            'password' => 'required|min:12|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/back-office/customers')
                ->withErrors($validator)
                ->withInput();
        }

        $customer = new Customer;
        $customer->name = $request->get('name');
        $customer->email = $request->get('email');
        $customer->password = Hash::make($request->get('password'));
        $customer->save();

        return redirect('/admin/back-office/customers');
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
            'email' => 'required|string|email|max:255|unique:customers',
        ]);

        if($request->get('current_password') !== '' && $request->get('password') !== '') {
            $customer = Customer::where('email', $request->get('email'))->first();
            $validatePassword = Validator::make([$request->get('current_password'), $request->get('password')], [
                'current_password' => 'current_password',
                'password' => 'min:12|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/',
            ]);
            $customer->password = Hash::make($request->get('password'));
        }

        if ($validator->fails() || $validatePassword->fails()) {
            return redirect('/admin/back-office/customers')
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::where('email', $request->get('email'))->first();
        $customer->name = $request->get('name');
        $customer->email = $request->get('email');
        $customer->save();

        return redirect('/admin/back-office/customers');
    }
}