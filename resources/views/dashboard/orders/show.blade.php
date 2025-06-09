@extends('dashboard.layouts.main')

@section('title', 'Detail Pesanan')
@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="{{ getModuleUrl('orders') }}" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    {{ Str::upper($order->order_number) }}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ getDashboardUrl() }}" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ getModuleUrl('orders') }}" class="text-decoration-none text-black">
                                Pesanan
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::upper($order->order_number) }}</li>
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
                            <td>{{ $order->customer->name ?? "Name" }}</td>

                            <th scope="row">Status Pembayaran</th>
                            <td>:</td>
                            <td>{{ $order->payment_status }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Outlet</th>
                            <td>:</td>
                            <td>{{ $order->outlet->name }}</td>

                            {{-- <th scope="row">Staff</th>
                            <td>:</td>
                            <td>{{ $order->user->name }}</td> --}}
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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order-items-information">
                            <span class="fw-bold">Item Pesanan</span>
                        </button>
                    </h2>
                    <div id="order-items-information" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap border rounded-top-2 p-3 bg-white">
                                <div class="input-group w-50">
                                    <input type="text" class="form-control" placeholder="Cari item pesanan.." style="font-size: 12px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search" name="search" style="font-size: 12px;">Cari</button>
                                </div>
                            </div>

                            @include('dashboard.components.table-order-items')

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

    @include('dashboard.components.modal-show-order-items')

@endsection
