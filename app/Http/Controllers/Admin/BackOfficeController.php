<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackOfficeController extends Controller
{
    /**
     * Show the BackOffice page.
     */
    public function show(Request $request): Response
    {
       
        return Inertia::render('admin/BackOffice', [
            
        ]);
    }

}