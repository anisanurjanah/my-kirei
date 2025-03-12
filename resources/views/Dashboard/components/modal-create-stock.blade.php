<div class="modal fade" id="{{ $menu->slug }}-stock" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-6">
                    Tambah Stok:<span class="fw-bold ms-2">{{ $menu->name }}</span>
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0 w-100">
                    <div class="card-body">

                        <form method="post" action="/dashboard/stocks/{{ $menu->stock->id }}">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="0" placeholder="Stok menu.." value="{{ old('stock') }}" required>
                                </div>
                                @error('stock')
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
