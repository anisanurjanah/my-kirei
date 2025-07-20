@php

use Carbon\Carbon;
use Illuminate\Support\Str;

$user = auth()->user();
$role = $user->role;
$outletCode = strtolower(optional($user->outlet)->outlet_code ?? '');

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

                    @if (auth()->user()->isAdministrator())
                        <a href="/dashboard/outlets/{{ Str::lower($menu->outlet->outlet_code) }}" class="text-decoration-none text-black">
                            <i class="bi bi-eye mx-2" style="font-size: 16px"></i>
                        </a>
                    @endif
                </div>
                <p class="card-text">{{ $menu->outlet->name }}</p>

                <h5 class="card-title mb-0">Harga Pokok</h5>
                <p class="card-text">Rp. {{ number_format($menu->cost_price, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="col-lg-12 mx-3 mx-md-0">
            <h5 class="card-title mb-0">Harga</h5>
            <p class="card-text">Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>

            <h5 class="card-title mb-0">Deskripsi</h5>
            <p class="card-text">{{ $menu->description }}</p>
        </div>
    </div>
</div>
