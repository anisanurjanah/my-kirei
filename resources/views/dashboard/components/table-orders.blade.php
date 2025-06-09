<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NOMOR PESANAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TANGGAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TELEPON <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @if (auth()->user()->isAdministrator())
                    <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @endif
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">STATUS PESANAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">STATUS PEMBAYARAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">PDF <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($orders->isNotEmpty())
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->customer->phone }}</td>
                        @if (auth()->user()->isAdministrator())
                            <td>{{ $order->outlet->name }}</td>
                        @endif
                        <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{!! \App\Helpers\OrderHelper::badgeOrderStatus($order->order_status) !!}</td>
                        <td>{!! \App\Helpers\OrderHelper::badgePaymentStatus($order->payment->payment_status) !!}</td>
                        <td>
                            <a
                                data-bs-toggle="tooltip"
                                title="Lihat PDF"
                                class="text-danger"
                                href="{{ secure_url('/order/preview/' . Str::lower($order->order_number) . '/pdf') }}"
                                target="_blank"
                            >
                                <i class="bi bi-filetype-pdf"></i>
                            </a>
                        </td>
                        <td>
                            @if ($order->order_status === 'Selesai')
                                <i class="bi bi-check2-square text-muted"></i>
                            @else
                                <div data-bs-toggle="tooltip" title="Tandai pesanan ini sudah selesai">
                                    <form action="{{ secure_url('/order/' . $order->order_number . '/complete') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-success">
                                            <i class="bi bi-check2-square"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ getModuleUrl('orders', Str::slug($order->order_number)) }}">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/orders/{{ getModuleUrl('orders', Str::slug($order->order_number), 'edit') }}/edit">
                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Perbarui
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmModal"
                                            data-bs-url="{{ getModuleUrl('orders', $order->order_number) }}"
                                            data-bs-name="{{ $order->order_number }}"
                                            data-action="delete">
                                            <i class="bi bi-trash mx-2" style="font-size: 16px"></i>Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
