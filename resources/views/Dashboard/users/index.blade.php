@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3 border-bottom">
        <div class="d-block">
            <h1 class="h2">Pengguna</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/dashboard" class="text-decoration-none text-black">
                            <i class="bi bi-house-fill"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                </ol>
            </nav>
        </div>

        <a href="/dashboard/users/create" class="btn btn-danger ms-auto my-3">
            <i class="bi bi-plus-circle-fill fs-6 me-2"></i>Tambah Pengguna
        </a>
    </div>

    <div class="row py-3">
        <div class="col-md-6">
            <div class="row align-items-stretch">
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-people text-danger h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $users->count() }}</h5>
                                <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $users->count() }}</h6>
                                <small class="card-text m-0">Total Pengguna</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-shop text-primary h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                <h5 class="card-title fw-bold m-0"></h5>
                                <small class="card-text m-0"></small>
                                <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $outlets->count() }}</h5>
                                <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $outlets->count() }}</h6>
                                <small class="card-text m-0">Total Outlet</small>
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
                            <i class="bi bi-cash text-success h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalCashiers }}</h5>
                                <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalCashiers }}</h6>
                                <small class="card-text m-0">Total Kasir</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 mb-3 mb-md-0">
                    <div class="card shadow border-0 w-100 h-100">
                        <div class="card-body d-flex align-items-start">
                            <i class="bi bi-tools text-warning h3 mx-2 mb-auto"></i>
                            <div class="ms-4 border-start ps-3">
                                <h5 class="card-title fw-bold m-0 d-none d-sm-block">{{ $totalProduction }}</h5>
                                <h6 class="card-title fw-bold m-0 d-block d-sm-none">{{ $totalProduction }}</h6>
                                <small class="card-text m-0">Total Produksi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap rounded-top-2 p-3 bg-white">
                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Cari pengguna.." style="font-size: 12px;">
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
                            {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">EMAIL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                            {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">PHONE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                            {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">USERNAME <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                            <th scope="col" class="text-secondary" style="font-size: 12px;">ROLE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->outlet->name }}</td>
                                    {{-- <td>{{ $user->email }}</td> --}}
                                    {{-- <td>{{ $user->phone }}</td> --}}
                                    {{-- <td>{{ $user->username }}</td> --}}
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center" style="width: 64px">
                                        <div class="dropdown mx-auto">
                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots text-black"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#{{ $user->username }}" data-bs-toggle="modal">
                                                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i> Lihat
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/users/edit">
                                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/users/delete">
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
                    Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
                </small>
                {{ $users->links('vendor.custom-pagination') }}
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <div class="modal fade" id="{{ $user->username }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-6">
                            Informasi Lengkap Pengguna:<span class="fw-bold ms-2">{{ $user->name }}</span>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0 w-100">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Nama</h5>
                                <p class="card-text">{{ $user->name }}</p>

                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title mb-0">Outlet</h5>

                                    <a href="/dashboard/outlets/{{ $user->outlet->slug }}" class="text-decoration-none text-black">
                                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i>
                                    </a>
                                </div>
                                <p class="card-text">{{ $user->outlet->name }}</p>

                                <h5 class="card-title mb-0">Email</h5>
                                <p class="card-text">{{ $user->email }}</p>

                                <h5 class="card-title mb-0">Phone</h5>
                                <p class="card-text">{{ $user->phone }}</p>

                                <h5 class="card-title mb-0">Username</h5>
                                <p class="card-text">{{ $user->username }}</p>

                                <h5 class="card-title mb-0">Role</h5>
                                <p class="card-text">{{ $user->role }}</p>
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
