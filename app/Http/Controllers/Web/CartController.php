<?php
/* 
* Controller File for the cart page
*/

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
    * Render the view assigned to the cart page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function show(Request $request): Response
    {
        return Inertia::render('web/Cart', [
            'status' => $request->session()->get('status'),
        ]);
    }
}
