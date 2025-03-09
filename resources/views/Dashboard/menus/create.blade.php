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
        <div class="col-lg-12">
            <div class="shadow border rounded-3 p-3">
                <div class="row">
                    <div class="col-12">

                        <form method="post" action="/dashboard/menus" enctype="multipart/form-data">
                            @csrf
                            <div class="row p-2">
                                <div class="col-md-6">
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
                                        <label for="outlet_id" class="form-label">Outlet</label>
                                        <select class="form-select" id="outlet_id" name="outlet_id" required>
                                            @foreach ($outlets as $outlet)
                                                @if (old('outlet_id') == $outlet->id)
                                                    <option value="{{ $outlet->id }}" selected>{{ $outlet->name }}</option>
                                                @else
                                                    <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()" required>
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
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
                                            <input type="text" class="form-control @error('price_promo') is-invalid @enderror" id="price_promo" name="price_promo" value="{{ number_format((int) old('price_promo', 0), 0, ',', '.') }}">
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
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function formatPrice(input) {
                input.addEventListener("input", function () {
                    let value = this.value.replace(/\./g, "").replace(/\D/g, "");
                    this.value = value ? parseInt(value, 10).toLocaleString("id-ID") : "";
                });
            }

            formatPrice(document.getElementById("price"));
            formatPrice(document.getElementById("price_promo"));
        });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>

@endsection
