<nav class="navbar-capstone" id="navbar">
    <div class="{{ isset($detailPage) && $detailPage ? 'container-detail' : 'container' }}">
        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="nav-brand">CAP<span>STONE</span></a>
            <div class="d-none d-lg-flex align-items-center gap-4">
                <a href="{{ route('landing') }}#fleet" class="nav-link-capstone">Mobil</a>
                <a href="{{ route('landing') }}#why" class="nav-link-capstone">Layanan</a>
                <a href="{{ route('landing') }}#how" class="nav-link-capstone">Cara Sewa</a>
                <a href="{{ route('landing') }}#testi" class="nav-link-capstone">Ulasan</a>
            </div>
            <div class="d-none d-md-flex align-items-center gap-2">
                @if (isset($detailPage) && $detailPage)
                    <a href="{{ route('category') }}" class="nav-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                @else
                    @auth
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-outline-secondary btn-sm px-3 text-white"
                                href="#" role="button" data-bs-toggle="dropdown">
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
                        <a href="{{ route('login') }}" class="btn-nav-login">
                            <i class="bi bi-person"></i> LOGIN
                        </a>
                    @endauth
                    <a href="#booking" class="btn-nav">PESAN SEKARANG</a>

                @endauth
        </div>
    </div>
</div>
</nav>
