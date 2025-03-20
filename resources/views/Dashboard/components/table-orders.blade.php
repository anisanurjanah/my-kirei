<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TANGGAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">DISKON <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">STATUS PESANAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">STATUS PEMBAYARAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                <th scope="col" class="text-secondary" style="font-size: 12px;">STAFF <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($orders->isNotEmpty())
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->outlet->name }}</td>
                        {{-- <td>Rp. {{ number_format($order->discount, 0, ',', '.') }}</td> --}}
                        <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ $order->order_status }}</td>
                        {{-- <td>{{ $order->payment_status }}</td> --}}
                        <td>{{ $order->user->name }}</td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/orders/{{ Str::lower($order->order_number) }}">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/orders/{{ Str::lower($order->order_number) }}/edit">
                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Perbarui
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            data-bs-url="/dashboard/orders/{{ $order->order_number }}" data-bs-name="{{ $order->order_number }}" data-action="delete">
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
