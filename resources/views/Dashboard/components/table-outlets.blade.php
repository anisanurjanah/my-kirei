<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">PHONE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">ADDRESS <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($outlets->isNotEmpty())
                @foreach ($outlets as $outlet)
                    <tr>
                        <td>{{ ($outlets->currentPage() - 1) * $outlets->perPage() + $loop->iteration }}</td>
                        <td>{{ $outlet->name }}</td>
                        <td>{{ $outlet->phone }}</td>
                        <td>{{ $outlet->address }}</td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/outlets/{{ Str::lower($outlet->outlet_code) }}">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/outlets/{{ Str::lower($outlet->outlet_code) }}/edit">
                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Perbarui
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                            data-bs-url="/dashboard/outlets/{{ $outlet->outlet_code }}" data-bs-name="{{ $outlet->name }}" data-action="delete">
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
                    <td colspan="5" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
