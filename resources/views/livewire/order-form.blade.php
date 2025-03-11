<form wire:submit.prevent="save">
    @csrf
    <div class="row p-2">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="shadow border rounded-3 p-3">
                <div class="mb-3">
                    <label for="outlet_id" class="form-label">Outlet</label>
                    <select class="form-select select2" wire:model="outlet_id" required autofocus>
                        <!-- THIS ONE WAS GOOD -->
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="customer_id" class="form-label">No. Telepon Pelanggan</label>
                    <select class="form-select select2" wire:model="customer_id" required>
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
                    <select class="form-select select2" wire:model="user_id" required>
                        @foreach ($users as $user)
                            @if (old('user_id') == $user->id)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="order_date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('order_date') is-invalid @enderror" wire:model="order_date" value="{{ old('order_date') }}" required>
                    @error('order_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
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
                            <div class="row align-items-end mb-3">
                                <div class="col-lg-7 col-md-6 col-7">
                                    <div class="mb-3">
                                        <label for="menu_id" class="form-label">Menu</label>
                                        <select class="form-select select2 menu-select" wire:model="menu_id" required>
                                            <option value="" disabled selected>Pilih menu</option>
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
                                        <input type="number" class="form-control menu-quantity @error('quantity') is-invalid @enderror" wire:model="quantity" min="1" placeholder="Quantity.." value="{{ old('quantity') }}" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-2 text-md-center text-end">
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
                                    <input type="text" class="form-control @error('sub_total') is-invalid @enderror" wire:model="sub_total" value="{{ number_format((int) old('sub_total', 0), 0, ',', '.') }}" autocomplete="off" required>
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

    <hr class="mt-3">

    <div class="row p-2 d-flex justify-content-end">
        <div class="col-md-6">

            {{-- @livewire('total-price-component') --}}

            <div class="mb-3">
                <label for="total_price" class="form-label">Total Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control @error('total_price') is-invalid @enderror" wire:model="total_price" value="{{ number_format((int) old('total_price', 0), 0, ',', '.') }}" required readonly>
                </div>
                @error('total_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="order_status" class="form-label">Status Pesanan</label>
                <select class="form-select" wire:model="order_status" required>
                    @foreach ($orderStatuses as $key => $status)
                        <option value="{{ $key }}" {{ old('order_status') == $key ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="payment_status" class="form-label">Status Pembayaran</label>
                <select class="form-select" wire:model="payment_status" required>
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
</form>
