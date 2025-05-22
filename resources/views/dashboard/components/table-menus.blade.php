<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @if (auth()->user()->isAdministrator())
                    <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @endif
                <th scope="col" class="text-secondary" style="font-size: 12px;">HARGA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">POTONGAN HARGA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary w-25" style="font-size: 12px;">STOK <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($menus->isNotEmpty())
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                        <td>{{ $menu->name }}</td>
                        @if (auth()->user()->isAdministrator())
                            <td>{{ $menu->outlet->name }}</td>
                        @endif
                        <td>Rp. {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format(optional($menu->pricePromo)->price_promo ?? 0, 0, ',', '.') }}</td>
                        @php
                            $total = $menu->price - optional($menu->pricePromo)->price_promo
                        @endphp
                        <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        <td class="w-25 align-middle">
                            <div style="position: relative; display: inline-block; width: 100%;" data-bs-toggle="tooltip" title="Stok saat ini: {{ $menu->stock->current_stock }}">
                                <div class="progress" role="progressbar" aria-valuenow="{{ $menu->stock->current_stock }}" aria-valuemin="0" aria-valuemax="1000" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($menu->stock->current_stock) / 10 }}%;">
                                        {{ ($menu->stock->current_stock ?? '0') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ getModuleUrl('menus', $menu->slug) }}">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ getModuleUrl('menus', $menu->slug, 'edit') }}">
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
                                            data-bs-url="{{ getModuleUrl('menus', $menu->slug) }}"
                                            data-bs-name="{{ $menu->name }}"
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
                    <td colspan="8" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
