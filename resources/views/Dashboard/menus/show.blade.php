@php

use Carbon\Carbon;

@endphp

@extends('dashboard.layouts.main')

@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/menus" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    {{ $menu->name }}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard/menus" class="text-decoration-none text-black">
                                Menu
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $menu->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">
        <div class="col-lg-8 mb-3 mb-md-0">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-menu">
                            Informasi Lengkap Menu:<span class="fw-bold ms-2">{{ $menu->name }}</span>
                        </button>
                    </h2>
                    <div id="informasi-menu" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="card border-0 w-100 mb-3">
                                <p class="card-text mb-2 mb-md-0">
                                    <small class="text-body-secondary">Ditambahkan pada {{ Carbon::parse($menu->created_at)->locale('id')->translatedFormat('d F Y') }}</small>
                                </p>
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        {{-- <img src="{{ $menu->image }}" class="img-fluid rounded p-3" alt="{{ $menu->name }}"> --}}
                                        @if ($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid rounded" alt="{{ $menu->name }}">
                                        @else
                                            <img src="https://picsum.photos/640/480" class="img-fluid rounded" alt="{{ $menu->name }}">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title mb-0">Nama</h5>
                                            <p class="card-text">{{ $menu->name }}</p>

                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title mb-0">Outlet</h5>

                                                <a href="/dashboard/outlets/{{ $menu->outlet->slug }}" class="text-decoration-none text-black">
                                                    <i class="bi bi-eye mx-2" style="font-size: 16px"></i>
                                                </a>
                                            </div>
                                            <p class="card-text">{{ $menu->outlet->name }}</p>

                                            <h5 class="card-title mb-0">Harga</h5>
                                            <p class="card-text">{{ $menu->price }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mx-3 mx-md-0">
                                        <h5 class="card-title mb-0">Deskripsi</h5>
                                        <p class="card-text">{{ $menu->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-block">
                <div class="col mb-3 bg-white p-3 rounded">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header border-bottom">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-stok">
                                    <small>Stok:<span class="fw-bold ms-2">{{ $menu->name }}</span></small>
                                </button>
                            </h2>
                            <div id="informasi-stok" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-black mb-0">{{ ($menu->stock->current_stock ?? '0') }}</p>

                                        <a href="/dashboard/stocks/create" class="text-decoration-none text-success mb-3" style="font-size: 14px">
                                            <small><i class="bi bi-plus me-1"></i>Tambah Stok</small>
                                        </a>
                                    </div>

                                    <div class="progress mb-3" role="progressbar" aria-valuenow="{{ $menu->stock->current_stock}}" aria-valuemin="0" aria-valuemax="1000" style="height: 20px">
                                        <div class="progress-bar progress-bar-striped bg-success" style="width: {{ ($menu->stock->current_stock) / 10 }}%;"></div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-black mb-0">Kelola:</small>

                                        <div class="d-flex gap-2 ms-auto">
                                            <a href="/dashboard/stocks/edit" class="text-decoration-none">
                                                <span class="badge text-bg-warning">Perbarui</span>
                                            </a>

                                            <a href="/dashboard/stocks/delete" class="text-decoration-none">
                                                <span class="badge text-bg-danger">Reset</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col bg-white p-3 rounded">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header border-bottom">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-diskon">
                                    <small>Potongan Harga:<span class="fw-bold ms-2">{{ $menu->name }}</span></small>
                                </button>
                            </h2>
                            <div id="informasi-diskon" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-end">
                                        <a href="/dashboard/stocks/create" class="text-decoration-none text-success mb-3" style="font-size: 14px">
                                            <small><i class="bi bi-plus me-1"></i>Tambah Diskon</small>
                                        </a>
                                    </div>

                                    @if(isset($menu->pricePromo->price_promo) && isset($menu->pricePromo->promo_start_date) && isset($menu->pricePromo->promo_end_date))
                                        <table class="table table-sm text-center" style="font-size: 10px;">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Harga</th>
                                                    <th>Potongan</th>
                                                    <th>Periode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                                    <td class="text-danger fw-bold">Rp {{ number_format($menu->pricePromo->price_promo, 0, ',', '.') }}</td>
                                                    <td>
                                                        <small>{{ date('d/m', strtotime($menu->pricePromo->promo_start_date)) }} - {{ date('d/m', strtotime($menu->pricePromo->promo_end_date)) }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown mx-auto">
                                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots text-black"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item" href="/dashboard/prices/edit">
                                                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="/dashboard/prices/delete">
                                                                        <i class="bi bi-trash mx-2" style="font-size: 16px"></i>Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <h5 class="h6 text-center mb-3 text-muted">Potongan harga tidak tersedia.</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
