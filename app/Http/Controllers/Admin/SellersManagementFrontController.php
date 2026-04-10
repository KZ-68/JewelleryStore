<?php
/* 
* Front Controller File for the sellers management page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SellerTaxInformation;
use App\Models\TaxRule;
use App\Models\TaxRuleGroup;
use App\Services\Tax\TaxCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Nette\Utils\Json;

class SellersManagementFrontController extends Controller
{
    public function showSellerList(Request $request) : Response
    {
        $sortBy = $request->input('sortBy', 'seller_code');
        $order = $request->input('order', 'asc');

        if (!in_array($sortBy, ['id', 'seller_code', 'created_at'])) {
            $sortBy = 'seller_code';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $sellers = Seller::orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/sellers/AllSellersList', 
            [
                'sellers' => $sellers,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }

    /**
     * Show sellers with status "waiting approval"
     */
    public function showWaitingApproval(Request $request) : Response
    {
        $sortBy = $request->input('sortBy', 'seller_code');
        $order = $request->input('order', 'asc');

        if (!in_array($sortBy, ['id', 'seller_code', 'created_at'])) {
            $sortBy = 'seller_code';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $sellers = Seller::with("seller_tax_informations")->whereHas("seller_tax_informations", function($q) {
            $q->where("validation_status", "Waiting Approval");
        })->orderBy($sortBy, $order)->get();

        return Inertia::render(
            'admin/sellers/SellersWaitingList', 
            [
                'sellers' => $sellers,
                'filters' => [
                    'sortBy' => $sortBy,
                    'order' => $order,
                ],
            ]
        );
    }

    public function validateSeller(Request $request) : JsonResponse
    {
        $validationRequest = $request->input('validation_request');
        $sellerId = $request->input('seller_id');
        $sellerTaxInfo = SellerTaxInformation::where('seller_id', $sellerId)->firstOrFail();

        if (isset($validationRequest) && $validationRequest == true) {

        } else {
            return response()->json([
                'validated' => false
            ]);
        }

        return response()->json([
            'validated' => true
        ]);
    }
}