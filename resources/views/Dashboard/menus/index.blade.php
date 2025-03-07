@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
        <div class="d-block">
            <h1 class="h2">Menu</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/dashboard" class="text-decoration-none text-black">
                            <i class="bi bi-house-fill"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Menu</li>
                </ol>
            </nav>
        </div>

        <a href="/dashboard/menus/create" class="btn btn-danger ms-auto my-3">
            <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Menu
        </a>
    </div>

    <div class="row py-3">
        <div class="col-md-6">
            <div class="row align-items-stretch">
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-fire text-danger h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                {{-- <h5 class="card-title fw-bold m-0 d-none d-sm-block">Siu Mai Ayam</h5> --}}
                                <h6 class="card-title fw-bold m-0 d-block">Siu Mai Ayam</h6>
                                <small class="card-text m-0">Paling Banyak Diminati</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-cart-check-fill text-primary h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                {{-- <h5 class="card-title fw-bold m-0 d-none d-sm-block">120</h5> --}}
                                <h6 class="card-title fw-bold m-0 d-block">120</h6>
                                <small class="card-text m-0">Terjual Hari Ini</small>
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
                            <i class="bi bi-graph-up-arrow text-success h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                {{-- <h5 class="card-title fw-bold m-0 d-none d-sm-block">2.430</h5> --}}
                                <h6 class="card-title fw-bold m-0 d-block">2.430</h6>
                                <small class="card-text m-0">Terjual Bulan Ini</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100 d-flex flex-column">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-exclamation-diamond-fill text-warning h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                {{-- <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $emptyStock->menu->name }}</h5> --}}
                                <h6 class="card-title fw-bold m-0 d-block">{{ $emptyStock->menu->name }}</h6>
                                <small class="card-text m-0">Stok Hampir Habis</small>
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
                    <input type="text" class="form-control" placeholder="Cari menu.." style="font-size: 12px;">
                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                </div>
                <select class="form-select w-25 ms-auto" name="outlet_id" style="font-size: 12px;">
                    @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                            Outlet: {{ $outlet->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                <table id="table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">DESKRIPSI <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                            <th scope="col" class="text-secondary" style="font-size: 12px;">HARGA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col" class="text-secondary" style="font-size: 12px;">POTONGAN HARGA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col" class="text-secondary w-25" style="font-size: 12px;">STOK <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($menus->isNotEmpty())
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->outlet->name }}</td>
                                    {{-- <td>{{ Str::limit($menu->description, 20, '...') }}</td> --}}
                                    <td>Rp. {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format(optional($menu->pricePromo)->price_promo ?? 0, 0, ',', '.') }}</td>
                                    @php
                                        $total = $menu->price - optional($menu->pricePromo)->price_promo
                                    @endphp
                                    <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                                    <td class="w-25 align-middle">
                                        <div class="progress" role="progressbar" aria-valuenow="{{ $menu->stock->current_stock}}" aria-valuemin="0" aria-valuemax="1000" style="height: 20px">
                                            <div class="progress-bar bg-success" style="width: {{ ($menu->stock->current_stock) / 10 }}%;">
                                                {{ ($menu->stock->current_stock ?? '0') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 64px">
                                        <div class="dropdown mx-auto">
                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots text-black"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/menus/{{ $menu->slug }}">
                                                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/menus/edit">
                                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/menus/delete">
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
                                <td colspan="7" class="text-center">Data tidak tersedia.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center py-3 py-md-0">
                <small class="text-muted">
                    Menampilkan {{ $menus->firstItem() }} sampai {{ $menus->lastItem() }} dari {{ $menus->total() }} data
                </small>
                {{ $menus->links('vendor.custom-pagination') }}
            </div>
        </div>
    </div>

@endsection
