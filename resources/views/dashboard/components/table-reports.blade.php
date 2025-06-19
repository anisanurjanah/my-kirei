<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @if (auth()->user()->isAdministrator())
                    <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                @endif
                <th scope="col" class="text-secondary" style="font-size: 12px;">TANGGAL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL PESANAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL PENDAPATAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL PPN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">TOTAL KEUNTUNGAN <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">PDF <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
            </tr>
        </thead>
        <tbody>
            @if ($reports->isNotEmpty())
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if (auth()->user()->isAdministrator())
                            <td>{{ $report->outlet->name }}</td>
                        @endif
                        <td>{{ $report->formatted_date }}</td>
                        <td>{{ $report->total_order }} Pesanan</td>
                        <td class="text-success fw-bold">Rp. {{ number_format($report->total_income, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($report->total_ppn, 0, ',', '.') }}</td>
                        <td><span class="badge bg-danger">Rp. {{ number_format($report->total_profit, 0, ',', '.') }}</span></td>
                        <td>
                            <a href="{{
                                    secure_url('/sales-report/' . Str::lower($report->outlet->outlet_code) . '/' . $report->download_date . '/pdf') .
                                    '?filter=' . trim(request('filter', 'daily')) .
                                    (request('start') ? '&start=' . trim(request('start')) : '') .
                                    (request('end') ? '&end=' . trim(request('end')) : '')
                                }}"
                                class="text-danger" target="_blank"
                            >
                                <i class="bi bi-filetype-pdf"></i>
                            </a>
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
