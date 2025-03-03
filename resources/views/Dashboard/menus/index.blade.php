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

        <button type="button" class="btn btn-danger ms-auto my-3">
            <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Menu
        </button>
    </div>

    <div class="row py-3">
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card shadow border-0 w-100 h-100 ">
                <div class="card-body d-flex align-items-start">
                    <i class="bi bi-cart-check-fill text-primary h3 mx-2 mb-auto"></i>
                    <div class="ms-4 border-start ps-3">
                        <h5 class="card-title fw-bold m-0">120</h5>
                        <small class="card-text m-0">Terjual Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card shadow border-0 w-100 h-100 ">
                <div class="card-body d-flex align-items-start">
                    <i class="bi bi-graph-up-arrow text-success h3 mx-2 mb-auto"></i>
                    <div class="ms-4 border-start ps-3">
                        <h5 class="card-title fw-bold m-0">2.430</h5>
                        <small class="card-text m-0">Terjual Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card shadow border-0 w-100 h-100 ">
                <div class="card-body d-flex align-items-start">
                    <i class="bi bi-exclamation-diamond-fill text-warning h3 mx-2 mb-auto"></i>
                    <div class="ms-4 border-start ps-3">
                        <h5 class="card-title fw-bold m-0">Siu Mai Ayam</h5>
                        <small class="card-text m-0">Stok Hampir Habis</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow border-0 w-100 h-100 ">
                <div class="card-body d-flex align-items-start">
                    <i class="bi bi-fire text-danger h3 mx-2 mb-auto"></i>
                    <div class="ms-4 border-start ps-3">
                        <h5 class="card-title fw-bold m-0">Siu Mai Ayam</h5>
                        <small class="card-text m-0">Paling Banyak Diminati</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-top-2 p-3 bg-white">
                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Cari menu.." style="font-size: 12px;">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" style="font-size: 12px;">Cari</button>
                </div>
                <select class="form-select w-25 ms-auto" style="font-size: 12px;">
                    <option selected>Outlet:</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
            </div>
            <div class="table-responsive">
                <table class="table">
                  <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up"></i></th>
                        <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up"></th>
                        <th scope="col" class="text-secondary" style="font-size: 12px;">DESKRIPSI <i class="bi bi-arrow-down-up"></th>
                        <th scope="col" class="text-secondary" style="font-size: 12px;">HARGA <i class="bi bi-arrow-down-up"></th>
                        {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">GAMBAR <i class="bi bi-arrow-down-up"></th> --}}
                        <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($menus->isNotEmpty())
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="/dashboard/menus/{{ $menu->slug }}" class="text-decoration-none text-black">{{ $menu->name }}</td>
                                <td><a href="/dashboard/menus/{{ $menu->slug }}" class="text-decoration-none text-black">{{ Str::limit($menu->description, 20, '...') }}</td>
                                <td><a href="/dashboard/menus/{{ $menu->slug }}" class="text-decoration-none text-black">{{ $menu->price }}</td>
                                {{-- <td><a href="/dashboard/menus/{{ $menu->slug }}" class="text-decoration-none text-black">{{ $menu->image }}</td> --}}
                                <td><a href="/dashboard/menus/{{ $menu->slug }}"><i class="bi bi-arrow-right-circle-fill text-danger"></i></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No data available.</td>
                        </tr>
                    @endif
                  </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <div class="table-responsive small">
                <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                        <th scope="col">Header</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1,001</td>
                        <td>random</td>
                        <td>data</td>
                        <td>placeholder</td>
                        <td>text</td>
                      </tr>
                      <tr>
                        <td>1,002</td>
                        <td>placeholder</td>
                        <td>irrelevant</td>
                        <td>visual</td>
                        <td>layout</td>
                      </tr>
                      <tr>
                        <td>1,003</td>
                        <td>data</td>
                        <td>rich</td>
                        <td>dashboard</td>
                        <td>tabular</td>
                      </tr>
                      <tr>
                        <td>1,003</td>
                        <td>information</td>
                        <td>placeholder</td>
                        <td>illustrative</td>
                        <td>data</td>
                      </tr>
                      <tr>
                        <td>1,004</td>
                        <td>text</td>
                        <td>random</td>
                        <td>layout</td>
                        <td>dashboard</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>



@endsection
