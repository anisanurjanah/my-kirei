<nav class="navbar navbar-expand-md fixed-top bg-light">
    <div class="container-fluid my-2">
        <a class="navbar-brand ms-3" href="#">My Kirei</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto mb-2 mb-md-0">
                <li class="nav-item mx-4">
                    <a class="nav-link" href="/">Beranda</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="#about">Tentang</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="#menu">Menu</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="#location">Lokasi</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="#contact">Kontak</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link me-3" href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                </li>

                {{-- @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Welcome back, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ ($active === "login" ? "active" : "") }}" href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                @endauth --}}
            </ul>
        </div>
    </div>
</nav>
