<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
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

    public function showManufacturers(Request $request): Response
    {
        $manufacturers = Manufacturer::all();
        return Inertia::render('admin/Manufacturers', ['manufacturers' => $manufacturers]);
    }
}
