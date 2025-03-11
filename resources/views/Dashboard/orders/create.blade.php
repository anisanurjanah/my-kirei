@extends('dashboard.layouts.main')

@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/orders" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    Tambah Pesanan Baru
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pesanan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">

        <form method="post" action="/dashboard/orders">
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
                                                <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
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
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="order-form d-none">
                        <div class="accordion accordion-flush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order-items-information">
                                        Item Pesanan
                                    </button>
                                </h2>
                                <div id="order-items-information" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="row align-items-end mb-3">
                                            <div class="col-lg-7 col-md-6 col-7">
                                                <div class="mb-3">
                                                    <label for="menu_id" class="form-label">Menu</label>
                                                    <select class="form-select select2 menu-select" id="menu_id" name="menu_id" required>
                                                        <option value="" disabled selected>Pilih Menu</option>
                                                        @foreach ($menus as $menu)
                                                            <option value="{{ $menu->id }}" data-price="{{ $menu->price }}" {{ in_array($menu->id, old('menu_id', [])) ? 'selected' : '' }}>
                                                                {{ $menu->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-4 col-3">
                                                <div class="mb-3">
                                                    <label for="quantity" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control menu-quantity @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="1" placeholder="Quantity.." value="{{ old('quantity') }}" required>
                                                    @error('quantity')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-2 d-none text-md-center text-end">
                                                <div class="mb-3">
                                                    <button type="button" class="btn btn-transparent btn-remove-menu">
                                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="menu-container"></div>

                                            <div class="col-12 d-none text-end mb-3" id="add-menu-btn-container">
                                                <button type="button" class="btn btn-danger" id="add-menu-btn">
                                                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Menu
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="sub_total" class="form-label">Sub Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control @error('sub_total') is-invalid @enderror" id="sub_total" name="sub_total" value="{{ number_format((int) old('sub_total', 0), 0, ',', '.') }}" autocomplete="off" required>
                                            </div>
                                            @error('sub_total')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="order-form d-none">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">No. Telepon Pelanggan</label>
                            <select class="form-select select2" id="customer_id" name="customer_id" required>
                                <option value="" disabled selected>Pilih Pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="customer_name_wrapper" class="mb-3 d-none">
                            <label for="customer_name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Staff</label>
                            <select class="form-select select2" id="user_id" name="user_id" required>
                                <option value="" disabled selected>Pilih Staff</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date') }}" required>
                            @error('order_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="mt-4">

                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ number_format((int) old('total_price', 0), 0, ',', '.') }}" required readonly>
                            </div>
                            @error('total_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Status Pesanan</label>
                            <select class="form-select" id="order_status" name="order_status" required>
                                @foreach ($orderStatuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('order_status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                @foreach ($paymentStatuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('payment_status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-center w-100">
                            <button type="submit" class="btn btn-dark w-100">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
