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
</head>
<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ secure_asset('img/logo-kirei-sum.jpg') }}" alt="Logo {{ $order->outlet->name }}" style="max-width: 180px;">
        </div>

        <h2>Ringkasan Pesanan</h2>
        <table class="info-table border-0">
            <tr>
                <td><strong>Nomor Pesanan:</strong></td>
                <td>: {{ $order->order_number }}</td>
            </tr>
            <tr>
                <td><strong>Outlet</strong></td>
                <td>: {{ $order->outlet->name }}</td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $order->customer->name }}</td>
            </tr>
            <tr>
                <td><strong>Telepon</strong></td>
                <td>: {{ $order->customer->phone }}</td>
            </tr>
            <tr>
                <td><strong>Nomor Bayar</strong></td>
                <td>: {{ $order->payment->payment_number }}</td>
            </tr>
            <tr>
                <td><strong>Metode Bayar</strong></td>
                <td>: {{ $order->payment->payment_method->method->name }}</td>
            </tr>
            <tr>
                <td><strong>Tipe Pesanan</strong></td>
                <td>: {{ $order->order_type }}</td>
            </tr>
            <tr>
                <td><strong>Waktu Pesanan</strong></td>
                <td>: {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('l, d F Y - H:i') }}</td>
            </tr>
        </table>

        <h4>Detail Produk</h4>
        <table>
            <thead>
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
                    <td colspan="3" class="total">Total</td>
                    <td class="total">Rp{{ number_format($order->payment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <p>Terima kasih telah memesan di <strong>{{ $order->outlet->name }}</strong>!</p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ $order->outlet->name }}. All rights reserved.
        </div>
    </div>
</body>
</html>
