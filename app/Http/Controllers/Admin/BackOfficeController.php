<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BackOfficeController extends Controller
{
    /**
     * Show the BackOffice page.
     */
    public function showBO(Request $request): Response
    {
        return Inertia::render('admin/BackOffice', []);
    }
}
