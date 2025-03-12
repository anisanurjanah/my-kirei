@extends('dashboard.layouts.main')

@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/menus" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    Tambah Menu Baru
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">

        <form method="post" action="/dashboard/menus" enctype="multipart/form-data">
            @csrf
            <div class="row p-2">
                <div class="col-lg-12 mb-3 mb-md-0">
                    <div class="accordion accordion-flush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#outlet">
                                    Outlet
                                </button>
                            </h2>
                            <div id="outlet" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <select class="form-select select2" id="outlet_id" name="outlet_id" required autofocus>
                                            <option value="" disabled selected>Pilih Outlet</option>
                                            @foreach ($outlets as $outlet)
                                                <option value="{{ $outlet->id }}" data-slug="{{ $outlet->slug }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                                    {{ $outlet->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row p-2">
                <div class="col-md-6">
                    <div class="row-form {{ $errors->any() ? '' : 'd-none' }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama menu.." value="{{ old('name') }}" autocomplete="off" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="1" placeholder="Deskripsi menu.." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" required>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row-form {{ $errors->any() ? '' : 'd-none' }}">
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ number_format((int) old('price', 0), 0, ',', '.') }}" autocomplete="off" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="0" placeholder="Stok menu.." value="{{ old('stock') }}" required>
                            </div>
                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price_promo" class="form-label">Potongan Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('price_promo') is-invalid @enderror" id="price_promo" name="price_promo" value="{{ number_format((int) old('price_promo', 0), 0, ',', '.') }}" autocomplete="off">
                            </div>
                            @error('price_promo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
