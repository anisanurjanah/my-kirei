@extends('dashboard.layouts.main')

@section('title', 'Detail Outlet')
@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/outlets" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    {{ $outlet->name }}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard/outlets" class="text-decoration-none text-black">
                                Outlet
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $outlet->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">
        <div class="col-lg-12 mb-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap shadow border rounded-3 p-3 bg-white">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>:</td>
                            <td>{{ $outlet->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kode</th>
                            <td>:</td>
                            <td>{{ $outlet->outlet_code }}</td>
                        </tr>
                        <tr>
                            <th scope="row">No. Telepon</th>
                            <td>:</td>
                            <td>{{ $outlet->phone }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat</th>
                            <td>:</td>
                            <td>{{ $outlet->address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-8 mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-menu">
                            <span class="fw-bold">Menu</span>
                        </button>
                    </h2>
                    <div id="informasi-menu" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap border rounded-top-2 p-3 bg-white">
                                <div class="input-group w-50">
                                    <input type="text" class="form-control" placeholder="Cari menu.." style="font-size: 12px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                                </div>
                            </div>

                            @include('dashboard.components.table-menus')

                            <div class="d-flex justify-content-between align-items-center py-3">
                                <small class="text-muted">
                                    Menampilkan {{ $menus->firstItem() }} sampai {{ $menus->lastItem() }} dari {{ $menus->total() }} data
                                </small>
                                {{ $menus->links('vendor.custom-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-pengguna">
                            <span class="fw-bold">Pengguna</span>
                        </button>
                    </h2>
                    <div id="informasi-pengguna" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap border rounded-top-2 p-3 bg-white">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control" placeholder="Cari pengguna.." style="font-size: 12px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                                </div>
                            </div>

                            @include('dashboard.components.table-users')

                            <div class="d-flex justify-content-between align-items-center py-3">
                                <small class="text-muted">
                                    Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
                                </small>
                                {{ $users->links('vendor.custom-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-pesanan">
                            <span class="fw-bold">Pesanan</span>
                        </button>
                    </h2>
                    <div id="informasi-pesanan" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap border rounded-top-2 p-3 bg-white">
                                <div class="input-group w-50">
                                    <input type="text" class="form-control" placeholder="Cari pesanan.." style="font-size: 12px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                                </div>
                            </div>

                            @include('dashboard.components.table-orders')

                            <div class="d-flex justify-content-between align-items-center py-3">
                                <small class="text-muted">
                                    Menampilkan {{ $orders->firstItem() }} sampai {{ $orders->lastItem() }} dari {{ $orders->total() }} data
                                </small>
                                {{ $orders->links('vendor.custom-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
