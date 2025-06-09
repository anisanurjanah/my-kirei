@extends('dashboard.layouts.main')

@section('title', 'Perbarui Pengguna')
@section('container')

    <div class="row px-md-2" style="background-color: #FFFFFF">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-3">
            <div class="d-block">
                <h1 class="h2">
                    <a href="/dashboard/users" class="text-decoration-none text-danger">
                        <i class="bi bi-arrow-left-circle-fill text-danger me-2" style="font-size: 20px"></i>
                    </a>
                    Perbarui Pengguna {{ $user->name }}
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="/dashboard" class="text-decoration-none text-black">
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="/dashboard/users" class="text-decoration-none text-black">
                                Pengguna
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row px-md-2 py-3">

        <form method="post" action="/dashboard/users/{{ $user->username }}">
            @method('PUT')
            @csrf
            <div class="row p-2">
                <div class="col-lg-12 mb-3 mb-md-0">
                    <div class="accordion accordion-flush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#outlet">
                                    Outlet
                                </button>
                            </h2>
                            <div id="outlet" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <select class="form-select select2" id="outlet_id" name="outlet_id" required autofocus>
                                            <option value="" disabled selected>Pilih Outlet</option>
                                            @foreach ($outlets as $outlet)
                                                <option value="{{ $outlet->id }}" data-slug="{{ $outlet->slug }}" {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>
                                                    {{ $outlet->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row p-2">
                <div class="col-md-6">
                    <div class="row-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama pengguna.." value="{{ old('name', $user->name) }}" autocomplete="off" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email.." value="{{ old('email', $user->email) }}" autocomplete="off" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text">(+62)</span>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $formatted_phone) }}" autocomplete="off" required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row-form">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username.." value="{{ old('username', $user->username) }}" autocomplete="off" required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password.." value="{{ old('password', $user->password) }}" autocomplete="off" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                @foreach ($userRoles as $key => $status)
                                    <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
