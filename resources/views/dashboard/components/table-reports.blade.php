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
            </tr>
        </thead>
        <tbody>
            @if ($reports->isNotEmpty())
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                        @if (auth()->user()->isAdministrator())
                            <td>{{ $report->outlet->name }}</td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</td>
                        <td>{{ $report->total_order }} Pesanan</td>
                        <td>Rp{{ number_format($report->total_revenue, 0, ',', '.') }}</td>
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
