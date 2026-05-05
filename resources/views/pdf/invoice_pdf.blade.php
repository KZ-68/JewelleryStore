<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Invoice #{{ $invoice->number }}</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 13px;
                color: #1f2937;
                background: #f3f4f6;
            }

            #invoice {
                max-width: 720px;
                margin: 30px auto;
                padding: 36px 40px;
                background: #ffffff;
                border-radius: 8px;
            }

            /* Header */
            .header-table {
                width: 100%;
                border-collapse: collapse;
            }
            .header-table td {
                vertical-align: top;
                padding: 0;
            }
            .brand-name {
                font-size: 22px;
                font-weight: bold;
                color: #1f2937;
                letter-spacing: 1px;
            }
            .brand-tagline {
                font-size: 11px;
                color: #9ca3af;
                margin-top: 3px;
            }
            .company-info {
                text-align: right;
                font-size: 12px;
                color: #6b7280;
                line-height: 1.6;
            }

            /* Divider */
            .divider {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 24px 0;
            }

            /* Bill-to / Invoice meta */
            .meta-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            .meta-table td {
                vertical-align: top;
                padding: 0;
            }
            .section-label {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #9ca3af;
                margin-bottom: 6px;
            }
            .bill-name {
                font-size: 14px;
                font-weight: bold;
                color: #111827;
                margin-bottom: 4px;
            }
            .bill-detail {
                font-size: 12px;
                color: #6b7280;
                line-height: 1.6;
            }
            .invoice-meta-row {
                margin-bottom: 5px;
                font-size: 12px;
                color: #6b7280;
                text-align: right;
            }
            .invoice-meta-row span {
                font-weight: bold;
                color: #111827;
            }
            .invoice-number-label {
                font-size: 18px;
                font-weight: bold;
                color: #111827;
                text-align: right;
                margin-bottom: 12px;
            }

            /* Products table */
            .products-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 28px;
            }
            .products-table thead th {
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #6b7280;
                border-bottom: 2px solid #e5e7eb;
                padding: 8px 10px;
            }
            .products-table thead th.col-name {
                text-align: left;
            }
            .products-table thead th.col-num {
                text-align: right;
            }
            .products-table tbody td {
                padding: 12px 10px;
                border-bottom: 1px solid #f3f4f6;
                vertical-align: top;
            }
            .products-table tbody td.col-name {
                text-align: left;
                font-size: 13px;
                color: #111827;
            }
            .products-table tbody td.col-num {
                text-align: right;
                font-size: 13px;
                color: #374151;
            }

            /* Totals */
            .totals-table {
                width: 260px;
                margin-left: auto;
                margin-top: 16px;
                border-collapse: collapse;
            }
            .totals-table td {
                padding: 5px 10px;
                font-size: 13px;
            }
            .totals-table td.label {
                text-align: left;
                color: #6b7280;
            }
            .totals-table td.amount {
                text-align: right;
                color: #374151;
            }
            .totals-table tr.total-row td {
                border-top: 2px solid #e5e7eb;
                padding-top: 10px;
                font-size: 14px;
                font-weight: bold;
                color: #111827;
            }

            /* Footer */
            .footer {
                margin-top: 40px;
                text-align: center;
                font-size: 11px;
                color: #9ca3af;
            }
        </style>
    </head>
    <body>
        <div id="invoice">

            {{-- Header --}}
            <table class="header-table">
                <tr>
                    <td style="width:50%">
                        <div class="brand-name">Joaillerie Orient</div>
                        <div class="brand-tagline">Fine Jewellery &amp; Luxury Pieces</div>
                    </td>
                    <td style="width:50%">
                        <div class="company-info">
                            joaillerie-orient.tech<br>
                            contact@joaillerie-orient.tech<br>
                        </div>
                    </td>
                </tr>
            </table>

            <hr class="divider">

            {{-- Bill-to + Invoice meta --}}
            <table class="meta-table">
                <tr>
                    <td style="width:50%">
                        <div class="section-label">Bill to</div>
                        <div class="bill-name">{{ $customer->name }}</div>
                        <div class="bill-detail">
                            {{ $customer->email }}<br>
                            @if($address)
                                {{ $address->address_line_1 }}<br>
                                @if($address->address_line_2)
                                    {{ $address->address_line_2 }}<br>
                                @endif
                                {{ $address->postal_code }} {{ $address->city }}<br>
                                @if($address->region)
                                    {{ $address->region }}<br>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td style="width:50%">
                        <div class="invoice-number-label">Invoice #{{ $invoice->number }}</div>
                        <div class="invoice-meta-row">
                            Date: <span>{{ $invoice->created_at ? \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') : '—' }}</span>
                        </div>
                        @if($invoice->due_date)
                        <div class="invoice-meta-row">
                            Due date: <span>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Products --}}
            <table class="products-table">
                <thead>
                    <tr>
                        <th class="col-name">Product</th>
                        <th class="col-num">Qty</th>
                        <th class="col-num">Unit price</th>
                        <th class="col-num">Line total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($products as $product)
                    @php
                        $qty        = $product->pivot->quantity ?? 1;
                        $unitPrice  = $product->pivot->retail_price ?? 0;
                        $lineTotal  = $qty * $unitPrice;
                        $subtotal  += $lineTotal;
                    @endphp
                    <tr>
                        <td class="col-name">{{ $product->name }}</td>
                        <td class="col-num">{{ $qty }}</td>
                        <td class="col-num">{{ number_format($unitPrice, 2, ',', ' ') }} €</td>
                        <td class="col-num">{{ number_format($lineTotal, 2, ',', ' ') }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="amount">{{ number_format($subtotal, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td class="label">VAT (0 %)</td>
                    <td class="amount">0,00 €</td>
                </tr>
                <tr class="total-row">
                    <td class="label">Total</td>
                    <td class="amount">{{ number_format($subtotal, 2, ',', ' ') }} €</td>
                </tr>
            </table>

            {{-- Footer --}}
            <div class="footer">
                Thank you for your order — Joaillerie Orient
            </div>

        </div>
    </body>
</html>
