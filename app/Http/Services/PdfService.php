<?php

namespace App\Http\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfService {

    public function download(Array $data) {
        $pdf = Pdf::loadView('pdf', ['data' => $data]);
    
        return $pdf->download();
    }

    public function display(Array $data) {
        $pdf = Pdf::loadView('pdf.invoice_pdf', [
            "invoice" => $data['invoice'],
            "address" => $data['address'],
            "customer" => $data['customer'],
            "products" => $data['products']
        ])->setPaper('A4', 'portrait')->setOptions(['isRemoteEnabled' => true,'defaultFont' => 'DejaVu Sans',]);
        $filename = "invoice-{$data['invoice']->number}.pdf";

        if(!file_exists($filename)) {
            $pdf->save($filename, 'invoices');
        }

        return $pdf->stream();
    }
}