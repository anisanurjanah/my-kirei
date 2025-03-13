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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menu-information">
                            Informasi Lengkap Menu:<span class="fw-bold ms-2">{{ $menu->name }}</span>
                        </button>
                    </h2>
                    <div id="menu-information" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            @include('dashboard.components.card-menu-information')
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stock-information">
                                    <small>Stok:<span class="fw-bold ms-2">{{ $menu->name }}</span></small>
                                </button>
                            </h2>
                            <div id="stock-information" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-black mb-0">{{ ($menu->stock->current_stock ?? '0') }}</p>

                                        <a href="#{{ $menu->slug }}-stock" data-bs-toggle="modal" class="text-decoration-none text-success mb-3" style="font-size: 14px">
                                            <small><i class="bi bi-plus me-1"></i>Tambah Stok</small>
                                        </a>
                                    </div>

                                    <div class="progress mb-3" role="progressbar" aria-valuenow="{{ $menu->stock->current_stock}}" aria-valuemin="0" aria-valuemax="1000" style="height: 20px">
                                        <div class="progress-bar progress-bar-striped bg-success" style="width: {{ ($menu->stock->current_stock) / 10 }}%;"></div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-black mb-0">Kelola:</small>

                                        <div class="d-flex gap-2 ms-auto">
                                            <a href="#{{ $menu->slug }}-stock-edit" data-bs-toggle="modal" class="text-decoration-none">
                                                <span class="badge text-bg-warning">Perbarui</span>
                                            </a>

                                            <button type="button" class="bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#resetStockModal"
                                                data-bs-url="/dashboard/stocks/{{ $menu->stock->id }}"
                                                data-bs-name="{{ $menu->name }}">
                                                <span class="badge text-bg-danger">Reset</span>
                                            </button>
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#promo-information">
                                    <small>Potongan Harga:<span class="fw-bold ms-2">{{ $menu->name }}</span></small>
                                </button>
                            </h2>
                            <div id="promo-information" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    @if(
                                        optional($menu->pricePromo)->price_promo === null &&
                                        optional($menu->pricePromo)->promo_start_date === null &&
                                        optional($menu->pricePromo)->promo_end_date === null
                                    )
                                        <div class="d-flex justify-content-end">
                                            <a href="#{{ $menu->slug }}-promo" data-bs-toggle="modal" class="text-decoration-none text-success mb-3" style="font-size: 14px">
                                                <small><i class="bi bi-plus me-1"></i>Tambah Potongan Harga</small>
                                            </a>
                                        </div>
                                    @endif

                                    @include('dashboard.components.table-menu-prices')

                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-black mb-0">Kelola:</small>

                                        <div class="d-flex gap-2 ms-auto">
                                            <a href="/dashboard/prices/edit" class="text-decoration-none">
                                                <span class="badge text-bg-warning">Perbarui</span>
                                            </a>

                                            <a href="/dashboard/prices/delete" class="text-decoration-none">
                                                <span class="badge text-bg-danger">Reset</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.modal-create-stock')
    @include('dashboard.components.modal-edit-stock')
    @include('dashboard.components.modal-reset-stock')

    @include('dashboard.components.modal-create-promo')

@endsection
