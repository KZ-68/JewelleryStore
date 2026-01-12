<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                
            </td>
            <td class="w-half">
                <h2>Invoice ID: {{ $invoice->number }}</h2>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>{{ $customer->name }}</div>
                    <div>{{ $address->address_line_1 }}</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Quantity</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
 
           @foreach($products as $product)
                 <tr class="items">
                    <td>
                        {{ $product->quantity }}
                    </td>
                    <td>
                        {{ $product->description }}
                    </td>
                    <td>
                        {{ $product->price }}
                    </td>
                 </tr>
           @endforeach
        </table>
    </div>
 
    <div class="total">
        Total: 
    </div>
</body>
</html>