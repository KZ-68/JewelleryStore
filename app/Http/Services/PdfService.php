<?php

namespace App\Http\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfService {

    public function download(Array $data) {
        $pdf = Pdf::loadView('pdf', ['data' => $data]);
    
        return $pdf->download();
    }

    public function display(Array $data) {
        $pdf = Pdf::loadView('pdf.invoice_pdf', [[
            "invoice" => $data['invoice'],
            "address" => $data['address'],
            "customer" => $data['customer'],
            "products" => $data['products']
        ]]);
    
        return $pdf->stream('invoice_pdf.pdf');
    }
}