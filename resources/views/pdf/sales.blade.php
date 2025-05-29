@php
$rows = count($sales);
$minRow = 12;
$isEnoughRow = $rows >= $minRow;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>

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
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .bold {
            font-weight: bold;
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
            <p class="bold">Sales report</p>
            @if (!empty($start) && !empty($end))
            <p>From: <span class="bold">{{ $start }}</span> to <span class="bold">{{ $end }}</span></p>
            @endif

            @if (isset($sort))
            <p>Sorting by: <span class="bold">{{ ucfirst($sort) }}</span></p>
            @endif
        </table>

        <hr>

        <div class="spacing">

            <table class="items">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cashier</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Datetime</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sale['cashier']['username'] }}</td>
                        <td>{{ $sale['customer']['name'] }}</td>
                        <td>${{ number_format($sale['detail']['total'],2) }}</td>
                        <td>{{ $sale['order_date']}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="bold">INVALID</td>
                    </tr>
                    @endforelse
                    @if (! $isEnoughRow && count($sales) < 1)
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