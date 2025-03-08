<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
    <table id="table" class="table">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NO <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">NAMA <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col" class="text-secondary" style="font-size: 12px;">OUTLET <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">EMAIL <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">PHONE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                {{-- <th scope="col" class="text-secondary" style="font-size: 12px;">USERNAME <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th> --}}
                <th scope="col" class="text-secondary" style="font-size: 12px;">ROLE <i class="bi bi-arrow-down-up" style="font-size: 10px"></i></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isNotEmpty())
                @foreach ($users as $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->outlet->name }}</td>
                        {{-- <td>{{ $user->email }}</td> --}}
                        {{-- <td>{{ $user->phone }}</td> --}}
                        {{-- <td>{{ $user->username }}</td> --}}
                        <td>{{ $user->role }}</td>
                        <td class="text-center" style="width: 64px">
                            <div class="dropdown mx-auto">
                                <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots text-black"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#{{ $user->username }}" data-bs-toggle="modal">
                                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i> Lihat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/users/edit">
                                            <i class="bi bi-pencil-square mx-2" style="font-size: 16px"></i>Ubah
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/dashboard/users/delete">
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
                    <td colspan="5" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
