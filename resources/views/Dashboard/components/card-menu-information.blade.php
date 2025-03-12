@php

use Carbon\Carbon;

@endphp

<div class="card border-0 w-100 mb-3">
    <p class="card-text mb-2 mb-md-0">
        <small class="text-body-secondary">Ditambahkan pada {{ Carbon::parse($menu->created_at)->locale('id')->translatedFormat('d F Y') }}</small>
    </p>
    <div class="row g-0">
        <div class="col-md-4 d-flex align-items-center justify-content-center">
            @if ($menu->image && file_exists(storage_path('app/public/' . $menu->image)))
                <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid rounded" alt="{{ $menu->name }}">
            @else
                <img src="{{ asset('img/dimsum-placeholder.jpg') }}" class="img-fluid rounded" alt="{{ $menu->name }}">
            @endif
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title mb-0">Nama</h5>
                <p class="card-text">{{ $menu->name }}</p>

                <div class="d-flex justify-content-between">
                    <h5 class="card-title mb-0">Outlet</h5>

                    <a href="/dashboard/outlets/{{ $menu->outlet->slug }}" class="text-decoration-none text-black">
                        <i class="bi bi-eye mx-2" style="font-size: 16px"></i>
                    </a>
                </div>
                <p class="card-text">{{ $menu->outlet->name }}</p>

                <h5 class="card-title mb-0">Harga</h5>
                <p class="card-text">{{ $menu->price }}</p>
            </div>
        </div>
        <div class="col-lg-12 mx-3 mx-md-0">
            <h5 class="card-title mb-0">Deskripsi</h5>
            <p class="card-text">{{ $menu->description }}</p>
        </div>
    </div>
</div>
