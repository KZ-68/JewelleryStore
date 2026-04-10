<?php

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Services\PdfService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class InvoiceFrontController extends Controller
{
    /**
    * Show customer invoices list view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function showInvoices(Request $request): Response|RedirectResponse
    {
        $user = $request->user("web");
        $customer = Customer::where('email', $user->email)->first();
        $orders = Order::where('customer_id', $customer->id)->get();
        $invoices = [];

        foreach ($orders as $order) {
            foreach($order->invoices as $invoice) {
                array_push($invoices, $invoice);
            }
        }

        if(!$invoices) {
            redirect('not-found', 404);
        }

        return Inertia::render('settings/Invoices', [
            'invoices' => $invoices
        ]);
    }

    public function downloadPdf(Request $request, PdfService $pdfService) {

        $invoice = $request->input('invoice');
        $orders = $invoice->orders;

        foreach($orders as $order) {
            $customer = Customer::where('customer_id', $order->customer_id)->first();
            $carrier = $order->carrier;
            $delivery = Delivery::where('carrier_id', $carrier->id)->first();
            $latestDeliveryAddress = $delivery->latestAddress;
        }

        $data = [
            "invoice" => $invoice,
            "address" => $latestDeliveryAddress,
            "customer" => $customer,
            "products" => $order->products
        ];

        $pdfService->download($data);
    }

    public function displayPdf(Request $request, PdfService $pdfService) {

        $invoice = Invoice::where('number', $request->input('number'))->first();
        $orders = $invoice->orders;
        foreach($orders as $order) {
            $customer = Customer::where('id', $order->customer_id)->first();
            $carrier = $order->carrier;
            $delivery = Delivery::where('carrier_id', $carrier->id)->first();
            $latestDeliveryAddress = $delivery->latestAddress()->firstOrFail();
        }
        
        $data = [
            "invoice" => $invoice,
            "address" => $latestDeliveryAddress,
            "customer" => $customer,
            "products" => $order->products
        ];

        return $pdfService->display($data);
    }
}