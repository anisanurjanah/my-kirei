@extends('dashboard.layouts.main')

@section('container')

    <div class="px-md-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
            <div class="d-block">
                <h1 class="h2">Pesanan</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
                    </ol>
                </nav>
            </div>

            <a href="/dashboard/orders/create" class="btn btn-danger ms-auto my-3">
                <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Pesanan
            </a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success col-lg-12 mt-3" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="row py-3">
            <div class="col-md-6">
                <div class="row align-items-stretch">
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-cart-fill text-danger h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalOrders ?? '0' }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalOrders ?? '0' }}</h6>
                                    <small class="card-text m-0">Total Pesanan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-receipt-cutoff text-primary h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalTransactions ?? '0' }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalTransactions ?? '0' }}</h6>
                                    <small class="card-text m-0">Pesanan Hari Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row align-items-stretch">
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-cash-stack text-success h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">Rp {{ number_format($monthlyRevenue, 0, ',', '.') ?? '0' }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">Rp {{ number_format($monthlyRevenue, 0, ',', '.') ?? '0' }}</h6>
                                    <small class="card-text m-0">Pendapatan Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-shop text-warning h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ Str::limit(optional($topOutlet)->name ?? 'none', 12, '...') }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ Str::limit(optional($topOutlet)->name ?? 'none', 12, '...') }}</h6>
                                    <small class="card-text m-0">Pesanan Terbanyak</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-top-2 p-3 bg-white">
                    <div class="input-group w-25">
                        <input type="text" class="form-control" placeholder="Cari pesanan.." style="font-size: 12px;">
                        <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                    </div>
                    @if (auth()->user()->isAdministrator())
                        <select class="form-select w-25 ms-auto" name="outlet_id" style="font-size: 12px;">
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                    Outlet: {{ $outlet->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                @include('dashboard.components.table-orders')

                <div class="d-flex justify-content-between align-items-center py-3 py-md-0">
                    <small class="text-muted">
                        Menampilkan {{ $orders->firstItem() }} sampai {{ $orders->lastItem() }} dari {{ $orders->total() }} data
                    </small>
                    {{ $orders->links('vendor.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>

@endsection
