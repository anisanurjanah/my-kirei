<header class="navbar flex-md-nowrap shadow bg-light">
    <a class="ms-3 m-0 p-2 fs-6 text-black text-decoration-none d-none d-md-block" href="/dashboard">
        <h1 class="h3 fw-bold text-center">My<span style="color: #C60E2A">Kirei</span></h1>
    </a>

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-black" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3" style="color: #C60E2A;"></i>
            </button>
        </li>
        {{-- <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                <svg class="bi"><use xlink:href="#search"/></svg>
            </button>
        </li> --}}
    </ul>

    {{-- <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
    </div> --}}

    <div class="dropdown ms-auto me-3 p-2">
        <a href="" class="d-flex align-items-center text-black text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex flex-column align-items-start">
                <span class="dropdown-toggle fs-6 fw-bold">{{ auth()->user()->isAdministrator() ? 'Administrator' : auth()->user()->outlet->name }}</span>
                <small class="text-secondary" style="font-size: 10px;">{{ auth()->user()->isAdministrator() ? 'My Kirei' : auth()->user()->role }}</small>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
