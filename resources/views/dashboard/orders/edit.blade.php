@extends('dashboard.layouts.main')

@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="{{ getModuleUrl('orders') }}" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    Perbarui Pesanan {{ $order->order_number }}
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
                        <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">

        <form method="post" action="{{ getModuleUrl('orders', $order->order_number) }}">
            @method('PUT')
            @csrf

            {{-- <input type="hidden" id="selectedUserId" value="{{ old('selectedUserId', $order->user_id ?? '') }}"> --}}

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
                                        <select class="form-select select2 outlet-order" id="outlet_id" name="outlet_id" required autofocus>
                                            <option value="" disabled selected>Pilih Outlet</option>
                                            @foreach ($outlets as $outlet)
                                                <option value="{{ $outlet->id }}" data-code="{{ $outlet->outlet_code }}" {{ old('outlet_id', $order->outlet_id) == $outlet->id ? 'selected' : '' }}>
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
                    <div class="row-form">
                        <div class="accordion accordion-flush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order-items-information">
                                        Item Pesanan
                                    </button>
                                </h2>
                                <div id="order-items-information" class="accordion-collapse collapse show">
                                    <div class="accordion-body">

                                        @foreach($order->orderItems as $index => $orderItem)

                                            <input type="hidden" class="selectedMenuId" value="{{ $orderItem->menu_id }}">
                                            <input type="hidden" class="selectedQuantity" value="{{ $orderItem->quantity }}">

                                            <div class="row align-items-end mb-3">
                                                <div class="col-lg-8 col-md-6 col-8">
                                                    <div class="mb-3">
                                                        <label for="menu_id_{{ $index }}" class="form-label">Menu</label>
                                                        <select class="form-select select2 {{ $index == 0 ? 'first-menu' : '' }} menu-select" id="menu_id[{{ $index }}]" name="menu_id[{{ $index }}]" required>
                                                            <option value="" disabled selected>Pilih Menu</option>
                                                            @foreach ($menus as $menu)
                                                                <option value="{{ $menu->id }}" data-price="{{ $menu->price }}" data-discount="{{ optional($menu->price_promo)->price_promo }}"  {{ old('menu_id.' . $index, $orderItem->menu_id) == $menu->id ? 'selected' : '' }}>
                                                                    {{ $menu->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-4">
                                                    <div class="mb-3">
                                                        <label for="quantity_{{ $index }}" class="form-label">Quantity</label>
                                                        <input type="number" class="form-control {{ $index == 0 ? 'first-quantity' : '' }} menu-quantity @error('quantity.' . $index) is-invalid @enderror" id="quantity[{{ $index }}]" name="quantity[{{ $index }}]" min="1" value='{{ old('quantity.' . $index, $orderItem->quantity) }}' required>
                                                        @error('quantity.' . $index)
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-10 col-md-6 col-10">
                                                    <div class="mb-3">
                                                        <label for="price_{{ $index }}" class="form-label">Harga</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="text" class="form-control {{ $index == 0 ? 'first-price' : '' }} price-input @error('price.' . $index) is-invalid @enderror" id="price[{{ $index }}]" name="price[{{ $index }}]" value="{{ number_format((int) old('price.' . $index, $orderItem->price), 0, ',', '.') }}" required readonly>
                                                        </div>
                                                        @error('price.' . $index)
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-2 text-md-center text-end">
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-transparent {{ $index == 0 ? 'btn-remove-first-menu' : 'btn-remove-menu' }}">
                                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div id="menu-container"></div>

                                        <div class="col-12 d-none text-end mb-3" id="add-menu-btn-container">
                                            <button type="button" class="btn btn-danger" id="add-menu-btn">
                                                <i class="bi bi-plus-circle-fill me-2"></i>Tambah Menu
                                            </button>
                                        </div>

                                        <hr class="mt-4">

                                        <div class="mb-3">
                                            <label for="sub_total" class="form-label">Sub Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control @error('sub_total') is-invalid @enderror" id="sub_total" name="sub_total" value="{{ number_format((int) old('sub_total', $order->sub_total), 0, ',', '.') }}" required readonly>
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
                    <div class="row-form">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">No. Telepon Pelanggan</label>
                            <select class="form-select select2" id="customer_id" name="customer_id" required>
                                <option value="" disabled selected>Pilih Pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="customer_name_wrapper" class="mb-3">
                            <label for="customer_name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer->name) }}" readonly>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="user_id" class="form-label">Staff</label>
                            <select class="form-select select2" id="user_id" name="user_id" required>
                                <option value="" disabled selected>Pilih Staff</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal</label>
                            <input type="datetime-local" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date', $order->order_date) }}" required>
                            @error('order_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="mt-4">

                        <div class="mb-3">
                            <label for="discount" class="form-label">Diskon</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') !== null ? number_format((int) old('discount'), 0, ',', '.') : number_format((int) $order->discount, 0, ',', '.') }}">
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ number_format((int) old('total_price', $order->total_price), 0, ',', '.') }}" required readonly>
                            </div>
                            @error('total_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="order_type" class="form-label">Tipe Pesanan</label>
                            <select class="form-select" id="order_type" name="order_type" required>
                                @foreach ($orderTypes as $key => $status)
                                    <option value="{{ $key }}" {{ old('order_type', $order->order_type) == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Status Pesanan</label>
                            <select class="form-select" id="order_status" name="order_status" required>
                                @foreach ($orderStatuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('order_status', $order->order_status) == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                @foreach ($paymentStatuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('payment_status', $order->payment_status) == $key ? 'selected' : '' }}>
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
