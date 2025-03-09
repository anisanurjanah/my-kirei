@extends('dashboard.layouts.main')

@section('container')

    <div class="px-md-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
            <div class="d-block">
                <h1 class="h2">Outlet</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Outlet</li>
                    </ol>
                </nav>
            </div>

            <a href="/dashboard/outlets/create" class="btn btn-danger ms-auto my-3">
                <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Outlet
            </a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success col-lg-12" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="row py-3">
            <div class="col-md-6">
                <div class="row align-items-stretch">
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-shop text-danger h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalOutlets }}</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalOutlets }}</h6>
                                    <small class="card-text m-0">Total Outlet</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-cart-check-fill text-primary h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">120</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">120</h6>
                                    <small class="card-text m-0">Transaksi Hari Ini</small>
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
                                <i class="bi bi-graph-up-arrow text-success h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">Rp 24.300.000</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">Rp 24.300.000</h6>
                                    <small class="card-text m-0">Pendapatan Bulan Ini</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 mb-3 mb-md-0">
                        <div class="card shadow border-0 w-100 h-100">
                            <div class="card-body d-flex align-items-start">
                                <i class="bi bi-trophy-fill text-warning h3 mx-2 mb-auto"></i>
                                <div class="ms-4 border-start ps-3">
                                    <h5 class="card-title fw-bold m-0 d-none d-sm-block">Outlet A</h5>
                                    <h6 class="card-title fw-bold m-0 d-block d-sm-none">Outlet A</h6>
                                    <small class="card-text m-0">Penjualan Terbanyak</small>
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
                    <div class="input-group w-50">
                        <input type="text" class="form-control" placeholder="Cari outlet.." style="font-size: 12px;">
                        <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                    </div>
                </div>

                <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                    <table id="table" class="table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                <th scope="col" class="text-secondary" style="font-size: 12px;">PHONE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                <th scope="col" class="text-secondary" style="font-size: 12px;">ADDRESS <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($outlets->isNotEmpty())
                                @foreach ($outlets as $outlet)
                                    <tr>
                                        <td>{{ ($outlets->currentPage() - 1) * $outlets->perPage() + $loop->iteration }}</td>
                                        <td>{{ $outlet->name }}</td>
                                        <td>{{ $outlet->phone }}</td>
                                        <td>{{ $outlet->address }}</td>
                                        <td class="text-center" style="width: 64px">
                                            <div class="dropdown mx-auto">
                                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots text-black"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="/dashboard/outlets/{{ $outlet->slug }}">
                                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="/dashboard/outlets/edit">
                                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="/dashboard/outlets/delete">
                                                            <i class="bi bi-trash mx-2" style="font-size: 16px"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak tersedia.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 py-md-0">
                    <small class="text-muted">
                        Menampilkan {{ $outlets->firstItem() }} sampai {{ $outlets->lastItem() }} dari {{ $outlets->total() }} data
                    </small>
                    {{ $outlets->links('vendor.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>

@endsection
