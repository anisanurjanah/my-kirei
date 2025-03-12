<div class="modal fade" id="{{ $menu->slug }}-promo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-6">
                    Tambah Potongan Harga:<span class="fw-bold ms-2">{{ $menu->name }}</span>
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0 w-100">
                    <div class="card-body">

                        {{-- <form method="post" action="/dashboard/prices/{{ optional($menu->pricePromo)->id }}"> --}}
                        <form method="post" action="/dashboard/prices">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <div class="mb-3">
                                <label for="price_promo" class="form-label">Potongan Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control @error('price_promo') is-invalid @enderror" id="price_promo" name="price_promo" value="{{ number_format((int) old('price_promo', 0), 0, ',', '.') }}" autocomplete="off" required>
                                </div>
                                @error('price_promo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="promo_start_date" class="form-label">Waktu Mulai</label>
                                <input type="date" class="form-control @error('promo_start_date') is-invalid @enderror" id="promo_start_date" name="promo_start_date" value="{{ old('promo_start_date') }}" required>
                                @error('promo_start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="promo_end_date" class="form-label">Waktu Selesai</label>
                                <input type="date" class="form-control @error('promo_end_date') is-invalid @enderror" id="promo_end_date" name="promo_end_date" value="{{ old('promo_end_date') }}" required>
                                @error('promo_end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
