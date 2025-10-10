<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function show(Request $request): Response
    {
        
        
        return Inertia::render('web/Cart', [
            'status' => $request->session()->get('status'),
        ]);
    }

}