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
