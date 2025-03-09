<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">MENU <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">QUANTITY <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary w-25" style="font-size: 12px;">SUB TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($orderItems->isNotEmpty())
                @foreach ($orderItems as $orderItem)
                    <tr>
                        <td>{{ ($orderItems->currentPage() - 1) * $orderItems->perPage() + $loop->iteration }}</td>
                        <td>{{ $orderItem->menu->name }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>Rp. {{ number_format($orderItem->sub_total, 0, ',', '.') }}</td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#{{ $order->slug }}" data-bs-toggle="modal">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i> Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/orderItems/edit">
                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/orderItems/delete">
                                            <i class="bi bi-trash mx-2" style="font-size: 16px"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
