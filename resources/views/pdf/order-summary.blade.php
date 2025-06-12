<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-chrome-192x192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/android-chrome-512x512.png">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ public_path('css/pdf-styles.css') }}" rel="stylesheet">
</head>
<body class="py-4">

    <div class="container p-4">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ public_path('img/logo-kirei-sum.jpg') }}" alt="Logo Kirei Sum" class="img-fluid" style="max-width: 180px;">
        </div>

        <h2 class="text-dark">Ringkasan Pesanan</h2>

        <p class="mt-4 text-justify" style="font-size: 16px;">
            Berikut adalah ringkasan pesanan Anda. Mohon periksa kembali informasi berikut untuk memastikan semua sudah sesuai.
        </p>

        <table class="info-table border-0">
            <tbody>
                <tr><th>Nomor Pesanan</th><td>: {{ $order->order_number }}</td></tr>
                <tr><th>Outlet</th><td>: {{ $order->outlet->name }}</td></tr>
                <tr><th>Telepon</th><td>: {{ $order->customer->phone }}</td></tr>
                <tr><th>Metode Bayar</th><td>: {{ $order->payment?->payment_method?->method['name'] ?? 'N/A' }}</td></tr>
                <tr><th>Tipe Pesanan</th><td>: {{ $order->order_type }}</td></tr>
                <tr><th>Waktu Pesanan</th><td>: {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('l, d F Y - H:i') }}</td></tr>
            </tbody>
        </table>

        <h4 class="mt-4">Detail Produk</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->menu->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp. {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2" class="fw-bold">Sub Total</th>
                    <th class="fw-bold">Rp. {{ number_format($order->sub_total, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th colspan="2" class="fw-bold">Diskon</th>
                    <th class="fw-bold">Rp. {{ number_format($order->discount, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th colspan="2" class="fw-bold">Total</th>
                    <th class="fw-bold">Rp. {{ number_format($order->payment->amount, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>

        <p class="mt-4 text-justify" style="font-size: 16px;">
            Terima kasih telah melakukan pemesanan di <strong>{{ $order->outlet->name }}</strong>. Kami menyusun informasi ini untuk memastikan pesanan Anda sesuai dan dapat menjadi bukti transaksi jika diperlukan. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.
        </p>

        <div class="footer">
            &copy; Kirei Sum {{ date('Y') }}. Semua hak dilindungi.
        </div>
    </div>

</body>
</html>
