@if(isset($menu->pricePromo->price_promo) && isset($menu->pricePromo->promo_start_date) && isset($menu->pricePromo->promo_end_date))
    <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
        <table class="table table-sm text-center" style="font-size: 10px;">
            <thead class="table-dark">
                <tr>
                    <th>Harga</th>
                    <th>Potongan</th>
                    <th>Periode</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="text-danger fw-bold">Rp {{ number_format($menu->pricePromo->price_promo, 0, ',', '.') }}</td>
                    <td>
                        <small>{{ date('d/m', strtotime($menu->pricePromo->promo_start_date)) }} - {{ date('d/m', strtotime($menu->pricePromo->promo_end_date)) }}</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <h5 class="h6 text-center mb-3 text-muted">Potongan harga tidak tersedia.</h5>
@endif
