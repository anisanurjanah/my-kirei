@extends('dashboard.layouts.main')

@section('container')

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

    <div class="row py-3">
        <div class="col-md-8">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-top-2 p-3 bg-white">
                <div class="input-group w-50">
                    <input type="text" class="form-control" placeholder="Cari pengguna.." style="font-size: 12px;">
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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->isNotEmpty())
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td class="text-center" style="width: 64px">
                                        <div class="dropdown mx-auto">
                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots text-black"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#{{ $customer->username }}" data-bs-toggle="modal">
                                                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i> Lihat
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/customers/edit">
                                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/customers/delete">
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
                    Menampilkan {{ $customers->firstItem() }} sampai {{ $customers->lastItem() }} dari {{ $customers->total() }} data
                </small>
                {{ $customers->links('vendor.custom-pagination') }}
            </div>
        </div>
    </div>

    @foreach ($customers as $customer)
        <div class="modal fade" id="{{ $customer->username }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-6">
                            Informasi Lengkap Pelanggan:<span class="fw-bold ms-2">{{ $customer->name }}</span>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0 w-100">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Nama</h5>
                                <p class="card-text">{{ $customer->name }}</p>

                                <h5 class="card-title mb-0">Phone</h5>
                                <p class="card-text">{{ $customer->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
