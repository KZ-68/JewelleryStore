<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'country', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $manufacturers = Manufacturer::orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/Manufacturers', 
            [
                'manufacturers' => $manufacturers,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }

    public function showProducts(Request $request): Response
    {

        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'country', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $products = Product::orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/Products', 
            [
                'products' => $products,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }
}
