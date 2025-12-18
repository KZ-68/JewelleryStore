<?php
/* 
* Controller File for the Back Office section
* List all methods for the pages connected to the Back Office
*/

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class BackOfficeController extends Controller
{
    /**
    * Render the view assigned to the Back Office page
    * @param Request Get the request, via GET method
    * @return Response Return an Inertia Object response with the rendered view
    */
    public function showBO(Request $request): Response
    {
        return Inertia::render('admin/BackOffice', []);
    }

    /**
     * Render the view assigned to the manufacturers list page
     * @var mixed $sortBy Get manufacturers sorted by name by default
     * @var mixed $order Get manufacturers order
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showManufacturers(Request $request): Response
    {

        // Create filters for dynamic change on the manufacturers list
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
     * Render the view assigned to the products list page
     * @var mixed $sortBy Get products sorted by name by default
     * @var mixed $order Get products order
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showProducts(Request $request): Response 
    {

        // Create filters for dynamic change on the products list
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
    
    /**
     * Render the view assigned to the suppliers list page
     * @var mixed $sortBy Get suppliers sorted by name by default
     * @var mixed $order Get suppliers order
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showSuppliers(Request $request): Response
    {

        // Create filters for dynamic change on the suppliers list
        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $suppliers = Supplier::orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/Suppliers', 
            [
                'suppliers' => $suppliers,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }

    /**
     * Render the view assigned to the categories list page
     * @var mixed $sortBy Get categories sorted by name by default
     * @var mixed $order Get categories order
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showCategories(Request $request): Response
    {
        // Create filters for dynamic change on the categories list
        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['name', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $categories = Category::where('parent_id', null)->orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/Categories', 
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * Render the view assigned to the customers list page
     * @var mixed $sortBy Get customers sorted by name by default
     * @var mixed $order Get customers order
     * @param Request $request Get the request
     * @return Response Return an Inertia Object response with the rendered view
    */
    public function showCustomers(Request $request): Response
    {
        // Create filters for dynamic change on the customers list
        $sortBy = $request->get('sortBy', 'name');
        $order = $request->get('order', 'asc');

        if (!in_array($sortBy, ['id', 'name', 'email', 'created_at'])) {
            $sortBy = 'name';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $customers = Customer::orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/Customers', 
            [
                'customers' => $customers,
            ]
        );
    }
}
