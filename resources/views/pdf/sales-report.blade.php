<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
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
            <img src="{{ public_path('img/logo-kirei-sum.jpg') }}" alt="Logo Kirei Sum" class="img-fluid" style="max-width: 240px;">
        </div>

        <h2 class="text-dark">Laporan Penjualan Harian</h2>

        <p class="mt-4 text-justify" style="font-size: 16px;">
            Dengan hormat, <br><br>
            Laporan ini disusun untuk memberikan gambaran menyeluruh terkait hasil penjualan yang terjadi pada tanggal <strong>{{ \Carbon\Carbon::parse($reportData->first()['date'] ?? '-')->translatedFormat('l, d F Y') }}</strong> di outlet <strong>{{ $reportData->first()['outlet'] ?? '-' }}</strong>. Informasi dalam laporan ini mencakup jumlah total pesanan yang diterima serta total pendapatan yang diperoleh pada periode tersebut. Data ini diambil secara langsung dari sistem dan telah diverifikasi untuk menjaga akurasi dan keandalannya. <br><br>
        </p>

        <table class="info-table border-0">
            <tbody>
                <tr>
                    <th>Nama</th>
                    <td>: {{ $ownerName ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Outlet</th>
                    <td>: {{ $reportData->first()['outlet'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>: {{ \Carbon\Carbon::parse($reportData->first()['date'] ?? '-')->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <th>Total Pesanan</th>
                    <td>: {{ $reportData->first()['total_orders'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Pendapatan</th>
                    <td>: Rp {{ number_format($reportData->first()['total_income'] ?? '-', 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Unduh</th>
                    <td>: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }} WIB</td>
                </tr>
            </tbody>
        </table>

        <p class="mt-4 text-justify" style="font-size: 16px;">
            Berikut adalah rincian menu yang terjual pada periode laporan. Data ini mencakup jumlah tiap menu yang terjual serta total pendapatan yang diperoleh dari penjualan tersebut.
        </p>

        <table class="table table-bordered py-4">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Jumlah Terjual</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($menuSummary as $menu)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $menu['name'] }}</td>
                        <td>{{ $menu['quantity'] }}</td>
                        <td>Rp. {{ number_format($menu['total_price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Pendapatan</th>
                    <th>Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <p class="mt-4 text-justify" style="font-size: 16px;">
            Laporan ini diharapkan dapat digunakan sebagai bahan evaluasi dan pengambilan keputusan strategis demi peningkatan layanan dan performa penjualan di masa yang akan datang.
        </p>

        <div class="note">
            Laporan ini dihasilkan otomatis oleh sistem dan tidak memerlukan tanda tangan.
        </div>

        <div class="footer">
            &copy; Kirei Sum {{ date('Y') }}. Semua hak dilindungi.
        </div>
    </div>

</body>
</html>
