<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .info-table {
            margin: 20px 0;
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
        }

        .note {
            margin-top: 20px;
            font-size: 12px;
            font-style: italic;
            text-align: center;
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
    </style>
</head>
<body>

    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ public_path('img/logo-kirei-sum.jpg') }}" alt="Logo Kirei Sum" style="max-width: 180px;">
    </div>

    <h2>Laporan Penjualan</h2>
    <h4>{{ $reportTitle }}</h4>

    <table class="info-table border-0">
        <tr>
            <td><strong>Nama Pengguna</strong></td>
            <td>: {{ $ownerName ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Periode Laporan</strong></td>
            <td>: {{ $reportPeriod ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Unduh</strong></td>
            <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>OUTLET</th>
                <th>TANGGAL</th>
                <th>TOTAL PESANAN</th>
                <th>TOTAL PENDAPATAN</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($reportData as $data)
                <tr>
                    <td class="center">{{ $no++ }}</td>
                    <td>{{ $data['outlet'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($data['date'])->translatedFormat('d F Y') }}</td>
                    <td>{{ $data['total_orders'] }} Pesanan</td>
                    <td class="right">Rp{{ number_format($data['total_income'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="right">Total</th>
                <th>{{ $reportData->sum('total_orders') }} Pesanan</th>
                <th class="right">Rp{{ number_format($reportData->sum('total_income'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="note">
        Laporan ini dihasilkan otomatis oleh sistem dan tidak memerlukan tanda tangan.
    </div>

    <div class="footer">
        &copy; {{ date('Y') }}. Semua hak dilindungi.
    </div>

</body>
</html>
