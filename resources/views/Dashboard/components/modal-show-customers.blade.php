@foreach ($customers as $customer)
    <div class="modal fade" id="{{ Str::slug($customer->name) }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-6">
                        Informasi Pelanggan:<span class="fw-bold ms-2">{{ $customer->name }}</span>
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 w-100">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Nama</h5>
                            <p class="card-text">{{ $customer->name }}</p>

                            <h5 class="card-title mb-0">No. Telepon</h5>
                            <p class="card-text">{{ $customer->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
