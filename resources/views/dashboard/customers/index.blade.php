@extends('dashboard.layouts.main')

@section('title', 'Daftar Pelanggan')
@section('container')

    <div class="px-md-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
            <div class="d-block">
                <h1 class="h2">Pelanggan</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
                    </ol>
                </nav>
            </div>

            <a href="/dashboard/customers/create" class="btn btn-danger ms-auto my-3">
                <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Pelanggan
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
                                <i class="bi bi-people text-danger h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalCustomers }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalCustomers }}</h6>
                                    <small class="card-text m-0">Total Pelanggan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-person-plus text-primary h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $newCustomers }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $newCustomers }}</h6>
                                    <small class="card-text m-0">Pelanggan Baru (7 hari terakhir)</small>
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
                                <i class="bi bi-person-lines-fill text-success h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $activeCustomers }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $activeCustomers }}</h6>
                                    <small class="card-text m-0">Pelanggan Aktif (7 hari terakhir)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-receipt text-warning h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalOrders }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalOrders }}</h6>
                                    <small class="card-text m-0">Total Pesanan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-top-2 p-3 bg-white">
                    <div class="input-group w-50">
                        <input type="text" class="form-control" placeholder="Cari pelanggan.." style="font-size: 12px;">
                        <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                    </div>
                </div>

                @include('dashboard.components.table-customers')

                <div class="d-flex justify-content-between align-items-center py-3 py-md-0">
                    <small class="text-muted">
                        Menampilkan {{ $customers->firstItem() }} sampai {{ $customers->lastItem() }} dari {{ $customers->total() }} data
                    </small>
                    {{ $customers->links('vendor.custom-pagination') }}
                </div>
            </div>
        </div>

        @include('dashboard.components.modal-show-customers')

    </div>

@endsection
