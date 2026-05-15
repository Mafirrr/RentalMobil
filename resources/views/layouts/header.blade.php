<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary border-opacity-10 py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">RENTAL<span class="text-primary">MOBIL</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link px-3" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Armada</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Syarat & Ketentuan</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link px-3" href="#">My Bookings</a></li>
                @endauth
            </ul>

            <div class="navbar-nav">
                @auth
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-secondary btn-sm px-3 text-white" href="#"
                            role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-primary btn-sm px-4 rounded-pill fw-bold" href="/login">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
