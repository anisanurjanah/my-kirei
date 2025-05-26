@extends('dashboard.layouts.main')

@section('container')

    <div class="px-md-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
            <div class="d-block">
                <h1 class="h2">Ringkasan Penjualan</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ getDashboardUrl() }}" class="text-decoration-none text-black">
                                <i class="bi bi-bar-chart-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row py-3">
            <div class="col-md-6">
                <div class="row align-items-stretch">
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-coin text-danger h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">Rp. {{ number_format($monthlyRevenue, 0, ',', '.') ?? '0' }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">Rp. {{ number_format($monthlyRevenue, 0, ',', '.') ?? '0' }}</h6>
                                    <small class="card-text m-0">Total Pendapatan Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-cart text-primary h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $monthlyOrderCount }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $monthlyOrderCount }}</h6>
                                    <small class="card-text m-0">Total Transaksi Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row align-items-stretch">
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-bar-chart-line-fill text-success h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">Rp. {{ number_format($averageDailyRevenue, 0, ',', '.') }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">Rp. {{ number_format($averageDailyRevenue, 0, ',', '.') }}</h6>
                                    <small class="card-text m-0">Rata-rata Penjualan Harian</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-shop text-warning h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ Str::limit(optional(optional($topOutlet)->outlet)->name ?? 'none', 12, '...') }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ Str::limit(optional(optional($topOutlet)->outlet)->name ?? 'none', 12, '...') }}</h6>
                                    <small class="card-text m-0">Transaksi Terbanyak Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 mb-md-0">
            <div class="col-lg-8">
                <div class="rounded-top-2 p-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h1 class="h4"><span id="selectedOutletName">{{ $outlets->first()->name ?? 'Outlet' }}</span></h1>

                        <div class="btn-toolbar">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z" />
                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                    <span id="selectedOutletName">{{ $outlets->first()->name ?? 'Outlet' }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($outlets as $outlet)
                                        <li><a class="dropdown-item outlet-filter" href="#" data-outlet-id="{{ $outlet->id }}">{{ $outlet->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.chartOrderLabels = @json($labels);
                        window.chartOrderData = @json($data);
                    </script>

                    <div class="chart-container">
                        <canvas class="w-100" id="orderLineChart" width="420" height="240"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rounded-top-2 p-3">
                    <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                        <table id="table" class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-white" style="font-size: 12px;">NO</th>
                                    <th scope="col" class="text-white" style="font-size: 12px;">TANGGAL</th>
                                    <th scope="col" class="text-white" style="font-size: 12px;">PELANGGAN</th>
                                    @if (auth()->user()->isAdministrator())
                                        <th scope="col" class="text-white" style="font-size: 12px;">OUTLET</th>
                                    @endif
                                    <th scope="col" class="text-white" style="font-size: 12px;">TOTAL</th>
                                    <th scope="col" class="text-white" style="font-size: 12px;">STATUS PESANAN</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $order)
                                        <tr style="font-size: 12px;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>{{ $order->customer->phone }}</td>
                                            @if (auth()->user()->isAdministrator())
                                                <td>{{ $order->outlet->name }}</td>
                                            @endif
                                            <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>{!! \App\Helpers\OrderHelper::badgeOrderStatus($order->order_status) !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">Data tidak tersedia.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-4 p-3 bg-white">
                    <h5 class="h5">Pesanan</h5>

                    <a href="{{ getModuleUrl('orders', null, 'create') }}" class="text-decoration-none text-danger mb-3" style="font-size: 14px">
                        <small><i class="bi bi-plus me-1"></i>Tambah Pesanan</small>
                    </a>
                </div>

                @include('dashboard.components.table-reports')

                <div class="d-flex justify-content-between align-items-center py-3 py-md-0">
                    <small class="text-muted">
                        Menampilkan {{ $reports->firstItem() }} sampai {{ $reports->lastItem() }} dari {{ $reports->total() }} data
                    </small>
                    {{ $reports->links('vendor.custom-pagination') }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center p-4 bg-white">
                    <img src="{{ secure_asset('img/logo-kirei-sum.jpg') }}" alt="Logo Kirei Sum" class="img-fluid opacity-50" style="max-width: 300px;">
                </div>
            </div>
        </div>
    </div>

@endsection
