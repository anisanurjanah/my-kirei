@if(isset($menu->pricePromo->price_promo) && isset($menu->pricePromo->promo_start_date) && isset($menu->pricePromo->promo_end_date))
    <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
        <table class="table table-sm text-center" style="font-size: 10px;">
            <thead class="table-dark">
                <tr>
                    <th>Harga</th>
                    <th>Potongan</th>
                    <th>Periode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="text-danger fw-bold">Rp {{ number_format($menu->pricePromo->price_promo, 0, ',', '.') }}</td>
                    <td>
                        <small>{{ date('d/m', strtotime($menu->pricePromo->promo_start_date)) }} - {{ date('d/m', strtotime($menu->pricePromo->promo_end_date)) }}</small>
                    </td>
                    <td class="text-center">
                        <div class="dropdown mx-auto">
                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots text-black"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="/dashboard/prices/edit">
                                        <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/dashboard/prices/delete">
                                        <i class="bi bi-trash mx-2" style="font-size: 16px"></i>Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <h5 class="h6 text-center mb-3 text-muted">Potongan harga tidak tersedia.</h5>
@endif
