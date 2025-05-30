<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        h2 {
            color: #333333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table td {
            padding: 6px 8px;
            border: none;
        }

        .info-table th {
            border: none;
        }

        .info-table.border-0,
        .info-table.border-0 td,
        .info-table.border-0 th {
            border: none !important;
        }

        .total {
            font-weight: bold;
            color: #000;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            table, thead, tbody, th, td, tr {
                font-size: 14px;
            }
        }
    </style>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class="bg-light py-4">

    <div class="container bg-white rounded shadow-sm p-4" style="max-width: 600px;">
        <div class="text-center mb-4">
            <img src="{{ public_path('img/logo-kirei-sum.jpg') }}" alt="Logo Kirei Sum" class="img-fluid" style="max-width: 180px;">
        </div>

        <h2 class="text-dark">Ringkasan Pesanan</h2>

        <table class="table table-borderless">
            <tbody>
                <tr><th>Nomor Pesanan</th><td>: {{ $order->order_number }}</td></tr>
                <tr><th>Outlet</th><td>: {{ $order->outlet->name }}</td></tr>
                <tr><th>Telepon</th><td>: {{ $order->customer->phone }}</td></tr>
                <tr><th>Nomor Bayar</th><td>: {{ $order->payment->payment_number }}</td></tr>
                <tr><th>Metode Bayar</th><td>: {{ $order->payment?->payment_method?->method['name'] ?? 'N/A' }}</td></tr>
                <tr><th>Tipe Pesanan</th><td>: {{ $order->order_type }}</td></tr>
                <tr><th>Waktu Pesanan</th><td>: {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('l, d F Y - H:i') }}</td></tr>
            </tbody>
        </table>

        <h4 class="mt-4">Detail Produk</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menu->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->menu->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="fw-bold">Total</td>
                    <td class="fw-bold">Rp{{ number_format($order->payment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="mt-3">Terima kasih telah memesan di <strong>{{ $order->outlet->name }}</strong>!</p>

        <div class="text-center text-muted mt-4">
            &copy; Kirei Sum {{ date('Y') }}. All rights reserved.
        </div>
    </div>

</body>
</html>
