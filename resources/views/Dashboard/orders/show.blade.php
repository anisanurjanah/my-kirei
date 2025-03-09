@extends('dashboard.layouts.main')

@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/orders" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-3" style="font-size: 20px"></i>{{ $order->slug }}
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
                            <a href="/dashboard/orders" class="text-decoration-none text-black">
                                Pesanan
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $order->slug }}</li>
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
                            <th scope="row" style="width: 25%">Tanggal</th>
                            <td>:</td>
                            <td>{{ $order->order_date }}</td>

                            <th scope="row" style="width: 25%">Status Pesanan</th>
                            <td>:</td>
                            <td>{{ $order->order_status }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>:</td>
                            <td>{{ $order->customer->name }}</td>

                            <th scope="row">Status Pembayaran</th>
                            <td>:</td>
                            <td>{{ $order->payment_status }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Outlet</th>
                            <td>:</td>
                            <td>{{ $order->outlet->name }}</td>

                            <th scope="row">Staff</th>
                            <td>:</td>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Total</th>
                            <td>:</td>
                            <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-8 mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informasi-item-pesanan">
                            <span class="fw-bold">Item Pesanan</span>
                        </button>
                    </h2>
                    <div id="informasi-item-pesanan" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap border rounded-top-2 p-3 bg-white">
                                <div class="input-group w-50">
                                    <input type="text" class="form-control" placeholder="Cari item pesanan.." style="font-size: 12px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                                <table id="table" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                            <th scope="col" class="text-secondary" style="font-size: 12px;">MENU <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                            <th scope="col" class="text-secondary" style="font-size: 12px;">QUANTITY <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                            <th scope="col" class="text-secondary w-25" style="font-size: 12px;">SUB TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orderItems->isNotEmpty())
                                            @foreach ($orderItems as $orderItem)
                                                <tr>
                                                    <td>{{ ($orderItems->currentPage() - 1) * $orderItems->perPage() + $loop->iteration }}</td>
                                                    <td>{{ $orderItem->menu->name }}</td>
                                                    <td>{{ $orderItem->quantity }}</td>
                                                    <td>Rp. {{ number_format($orderItem->sub_total, 0, ',', '.') }}</td>
                                                    <td class="text-center" style="width: 64px">
                                                        <div class="dropdown mx-auto">
                                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots text-black"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item" href="#{{ $order->slug }}" data-bs-toggle="modal">
                                                                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i> Lihat
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="/dashboard/orderItems/edit">
                                                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                                                    </a>
                                                                </li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item" href="/dashboard/orderItems/delete">
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
                            <div class="d-flex justify-content-between align-items-center py-3">
                                <small class="text-muted">
                                    Menampilkan {{ $orderItems->firstItem() }} sampai {{ $orderItems->lastItem() }} dari {{ $orderItems->total() }} data
                                </small>
                                {{ $orderItems->links('vendor.custom-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @foreach ($orderItems as $orderItem)
        <div class="modal fade" id="{{ $order->slug }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-6">
                            Informasi Item Pesanan:<span class="fw-bold ms-2">{{ $order->slug }}</span>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0 w-100">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Menu</h5>
                                <p class="card-text">{{ $orderItem->menu->name }}</p>

                                <h5 class="card-title mb-0">Quantity</h5>
                                <p class="card-text">{{ $orderItem->quantity }}</p>

                                <h5 class="card-title mb-0">Sub Total</h5>
                                <p class="card-text">{{ $orderItem->sub_total }}</p>
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
