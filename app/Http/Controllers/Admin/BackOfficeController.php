<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackOfficeController extends Controller
{
    /**
     * Show the BackOffice page.
     */
    public function showBO(Request $request): Response
    {
        return Inertia::render('admin/BackOffice', [
            
        ]);
    }

}