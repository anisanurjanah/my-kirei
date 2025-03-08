@php
    use Carbon\Carbon;
@endphp

<!doctype html>
<html lang="en" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title>My Kirei | {{ $outlet->name }}</title>

        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- CSS Styling -->
        <link href="/css/dashboard-styles.css" rel="stylesheet">
        <link href="/css/dashboard.css" rel="stylesheet">
    </head>
    <body class="bg-light">

        @include('dashboard.layouts.header')

        <div class="container-fluid">
            <div class="row">
                @include('dashboard.layouts.sidebar')

                <main class="col-md-9 ms-sm-auto col-lg-10">
                    <div class="row px-md-2" style="background-color: #FFFFFF">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
                            <div class="d-block">
                                <h1 class="h2">
                                    <a href="/dashboard/outlets" class="text-decoration-none text-danger">
                                        <i class="bi bi-arrow-left-circle-fill text-danger me-3" style="font-size: 20px"></i>{{ $outlet->name }}
                                    </a>
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

                    @include('dashboard.components.show-users')

                    @include('dashboard.layouts.footer')
                </main>

            </div>
        </div>

    <!-- Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="/js/dashboard.js"></script>

</body>
</html>
