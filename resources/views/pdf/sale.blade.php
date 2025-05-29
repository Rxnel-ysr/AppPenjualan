@php
$rows = count($sale->detail->items);
$minRow = 12;
$isEnoughRow = $rows >= $minRow;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sale ID: {{ $sale->id }} Report</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        .container {
            padding: 40px;
            border: 1px solid #000;
        }

        .header,
        .footer {
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 0;
        }

        .subtext {
            font-size: 16px;
            margin-top: 5px;
        }

        .info {
            border-style: hidden;
        }

        .info td {
            border-style: hidden;
            border: none;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: 2px solid black;
            margin: 20px 0;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            user-select: none;
        }

        .items th,
        td {
            border: 1px solid #000;
            text-align: center;
            padding: 6px;
        }

        .placeholder {
            padding: 1rem;
        }

        .spacing {
            min-height: 28rem;
            margin-bottom: 5rem;
        }

        .footer-note {
            margin-top: 30px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header text-center">
            <h1 class="title">Ron Complex Store</h1>
            <p class="subtext">234 Redwood, St Nicolas</p>
        </div>

        <hr>

        <table class="info">
            <tbody>
                <tr>
                    <td class="text-left">Cashier</td>
                    <td class="text-left">: <span class="bold">{{ $sale->cashier->username }}</span></td>
                </tr>
                <tr>
                    <td class="text-left">Customer</td>
                    <td class="text-left">: <span class="bold">{{ $sale->customer->name }}</span></td>
                </tr>
                <tr>
                    <td class="text-left">Date/time</td>
                    <td class="text-left">: <span class="bold">{{ $sale->order_date }}</span></td>
                </tr>
                <tr>
                    <td class="text-left">Method</td>
                    <td class="text-left">: <span class="bold">Cash</span></td>
                </tr>
            </tbody>
        </table>

        <hr>

        <div class="spacing">

            <table class="items">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sale->detail->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>${{ number_format($item->price,2) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->subtotal,2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="bold">INVALID</td>
                    </tr>
                    @endforelse
                    @if (! $isEnoughRow)
                    @for ($i = $rows; $i < $minRow; $i ++)
                        <tr>
                        <td class="placeholder"></td>
                        <td class="placeholder"></td>
                        <td class="placeholder"></td>
                        <td class="placeholder"></td>
                        <td class="placeholder"></td>
                        </tr>
                        @endfor
                        @endif

                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                            <td><strong>${{ number_format($sale->detail->total,2) }}</strong></td>
                        </tr>
                </tbody>
            </table>

        </div>

        <hr>

        <div class="footer">
            <p class="footer-note">Thank you for buying on our store!</p>
        </div>
    </div>
</body>

</html>