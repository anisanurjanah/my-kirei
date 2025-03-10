<div class="row p-2">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="outlet_id" class="form-label">Outlet</label>
            <select class="form-select select2" id="outlet_id" name="outlet_id" required autofocus>
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
            <label for="customer_id" class="form-label">No. Telepon Pelanggan</label>
            <select class="form-select select2" id="customer_id" name="customer_id" required>
                @foreach ($customers as $customer)
                    @if (old('customer_id') == $customer->id)
                        <option value="{{ $customer->id }}" selected>{{ $customer->phone }}</option>
                    @else
                        <option value="{{ $customer->id }}">{{ $customer->phone }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Staff</label>
            <select class="form-select select2" id="user_id" name="user_id" required>
                @foreach ($users as $user)
                    @if (old('user_id') == $user->id)
                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="order_date" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date') }}" required>
            @error('order_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <!-- ORDER DETAILS -->
    </div>

    <div class="col-md-6">
        <div class="accordion accordion-flush">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order-items-information">
                        Item Pesanan
                    </button>
                </h2>
                <div id="order-items-information" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="menu_id" class="form-label">Menu</label>
                            <select class="form-select select2" id="menu_id" name="menu_id" required>
                                @foreach ($menus as $menu)
                                    @if (old('menu_id') == $menu->id)
                                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                                    @else
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mb-3 d-none" id="add-menu-btn-container">
                            <button type="button" class="btn btn-danger" id="add-menu-btn">
                                <i class="bi bi-plus-circle-fill me-2"></i>Tambah Menu
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="0" placeholder="Quantity.." value="{{ old('quantity') }}" required>
                            </div>
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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

                        <hr class="my-3">

                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ number_format((int) old('total_price', 0), 0, ',', '.') }}" autocomplete="off" required>
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
                                @foreach ($orders as $order)
                                    @if (old('order_status') == $order->order_status)
                                        <option value="{{ $order->id }}" selected>{{ $order->order_status }}</option>
                                    @else
                                        <option value="{{ $order->id }}">{{ $order->order_status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                @foreach ($orders as $order)
                                    @if (old('payment_status') == $order->payment_status)
                                        <option value="{{ $order->id }}" selected>{{ $order->payment_status }}</option>
                                    @else
                                        <option value="{{ $order->id }}">{{ $order->payment_status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
