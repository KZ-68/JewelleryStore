<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Invoice</title>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 14px;
                color: #111827;
            }

            .w-full {
                width: 100%;
            }

            .min-w-full {
                min-width: 100%;
            }
            #invoice {
                max-width: 768px;
                margin: 24px auto;
                padding: 24px;
                background: #ffffff;
                border-radius: 6px;
            }

            .text-right {
                text-align: right;
            }

            .text-left {
                text-align: left;
            }

            .text-sm {
                font-size: 12px;
            }

            .text-gray {
                color: #6b7280;
            }

            .text-dark {
                color: #111827;
            }

            .text-gray-900 {
                color: #111827;
            }

            .font-bold {
                font-weight: bold;
            }

            .font-semibold {
                font-weight: 600;
            }

            .mt-1 { margin-top: 4px; }
            .mt-6 { margin-top: 24px; }
            .mt-8 { margin-top: 32px; }
            .pt-4 { padding-top: 16px; }
            .pt-6 { padding-top: 24px; }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 24px;
            }

            th, td {
                padding: 8px;
                vertical-align: top;
            }

            thead th {
                border-bottom: 1px solid #d1d5db;
            }

            tbody tr {
                border-bottom: 1px solid #e5e7eb;
            }

            tfoot th, tfoot td {
                padding-top: 12px;
            }

            .w-50 {
                width: 50%;
            }

            .w-16 {
                width: 16.66%;
            }

            .pl-6 {
                padding-left: 24px;
            }

            .pr-3 {
                padding-right: 12px;
            }

            .py-3-5 {
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .pl-4 {
                padding-left: 16px;
            }

            .clearfix::after {
                content: "";
                display: block;
                clear: both;
            }

            .container {
                display: table;
                width: 100%;
            }

            .item-left {
                display: table-cell;
                text-align: left;
            }

            .item-right {
                display: table-cell;
                text-align: right;
            }

            .max-w-3xl {
                max-width: 48rem;
            }

            .mx-auto {
                margin-left: auto;
                margin-right: auto;
            }

            .bg-white {
                 background-color: #ffffff
            }

            .my-6 {
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .shadow-sm {
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }
        </style>
    </head>
    <body>
        <div class="max-w-3xl mx-auto p-6 bg-white shadow-sm my-6" id="invoice">

            <div class="items-center">
                <div>
                    Company Logo Here
                </div>

                <div class="text-right">
                <p>
                    Jewellery Store Inc.
                </p>
                <p class="text-gray text-sm">
                    admin@jewellery-store.com
                </p>
                <p class="text-gray text-sm mt-1">
                    Phone Number here
                </p>
                <p class="text-gray text-sm mt-1">
                    VAT: 7416654165
                </p>
                </div>
            </div>

            <div class="mt-8 container">
                <div class="item-left">
                    <p class="font-bold text-dark">
                        Bill to :
                    </p>
                    <p class="text-gray">
                        {{ $customer->name }}
                        <br />
                        {{ $address->address_line_1 }}
                    </p>
                </div>

                <div class="item-right">
                    <p>
                        Invoice number:
                        <span class="text-gray">{{ $invoice->number }}</span>
                    </p>
                    <p>
                        Invoice date: <span class="text-gray">{{ $invoice->created_at }}</span>
                        <br />
                        Due date: <span class="text-gray">{{ $invoice->due_date }}</span>
                    </p>
                </div>
            </div>

            <div class="mx-4 mt-8 clearfix">
                <table class="min-w-full">
                    <colgroup>
                        <col class="w-full">
                        <col>
                        <col>
                    </colgroup>
                    <thead class="border-b border-gray-300 text-gray-900">
                        <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Product Name</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Quantity</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b border-gray-200">
                            <td class="hidden px-3 py-5 text-right text-sm text-gray">{{ $product->name }}</td>
                            <td class="hidden px-3 py-5 text-right text-sm text-gray">{{ $product->quantity }}</td>
                            <td class="hidden px-3 py-5 text-right text-sm text-gray">{{ $product->cost_price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-6 text-right text-sm font-normal text-gray">Subtotal</th>
                            <td class="pl-3 pr-6 pt-6 text-right text-sm text-gray"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-4 text-right text-sm font-normal text-gray">Tax</th>
                            <td class="pl-3 pr-6 pt-4 text-right text-sm text-gray"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-4 text-right text-sm font-normal text-gray">Discount</th>
                            <td class="pl-3 pr-6 pt-4 text-right text-sm text-gray"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3" class="hidden pl-4 pr-3 pt-4 text-right text-sm font-semibold text-gray-900">Total</th>
                            <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
</html>