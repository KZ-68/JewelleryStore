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

    /**
     * @var mixed $sortBy Get manufacturers sorted by name by default
     * @var mixed $order Get manufacturers order
     * @param Request $request Get the request
     * @return Response Return the response object
    */
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

    /**
     * 
     * @var mixed $sortBy Get products sorted by name by default
     * @var mixed $order Get products order
     * @param Request $request Get the request
     * @return Response Return the response object
    */
    public function showProducts(Request $request): Response 
    {

        $sortBy = $request->get('sortBy', 'id');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['id', 'name', 'created_at'])) {
            $sortBy = 'id';
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
