@foreach ($users as $user)
    <div class="modal fade" id="{{ $user->username }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-6">
                        Informasi Pengguna:<span class="fw-bold ms-2">{{ $user->name }}</span>
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-0 w-100">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Nama</h5>
                            <p class="card-text">{{ $user->name }}</p>

                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mb-0">Outlet</h5>

                                <a href="/dashboard/outlets/{{ $user->outlet->slug }}" class="text-decoration-none text-black">
                                    <i class="bi bi-eye mx-2" style="font-size: 16px"></i>
                                </a>
                            </div>
                            <p class="card-text">{{ $user->outlet->name }}</p>

                            <h5 class="card-title mb-0">Email</h5>
                            <p class="card-text">{{ $user->email }}</p>

                            <h5 class="card-title mb-0">No. Telepon</h5>
                            <p class="card-text">{{ $user->phone }}</p>

                            <h5 class="card-title mb-0">Username</h5>
                            <p class="card-text">{{ $user->username }}</p>

                            <h5 class="card-title mb-0">Role</h5>
                            <p class="card-text">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
