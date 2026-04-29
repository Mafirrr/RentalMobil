<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #0b0c10;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            background: #121212;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
        }

        .nav-link {
            color: #8a8a8a;
            border-radius: 12px;
            margin-bottom: 5px;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #0d6efd;
            color: #fff;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column p-4">
        <a class="navbar-brand fw-bold mb-5 fs-4" href="#">RENTAL<span class="text-primary">MOBIL</span></a>

        <ul class="nav nav-pills flex-column mb-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('admin.cars') }}" class="nav-link {{ Route::is('admin.cars*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i> Armada
            </a>
            <li><a href="#" class="nav-link"><i class="bi bi-person-check me-3"></i> Persetujuan Sewa</a></li>
            <li>
                <a href="#userSubmenu" data-bs-toggle="collapse"
                    class="nav-link d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-3"></i> Daftar Pengguna</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse ms-4" id="userSubmenu">
                    <ul class="nav flex-column">
                        <li><a href="#" class="nav-link small py-2">Penyewa</a></li>
                        <li><a href="#" class="nav-link small py-2">Admin</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <hr class="text-secondary opacity-25">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0"><i
                    class="bi bi-box-arrow-left me-2"></i> Logout</button>
        </form>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                @if (Route::is('admin.dashboard'))
                    Dashboard
                @elseif(Route::is('admin.cars*'))
                    Manajemen Armada
                    {{-- @elseif(Route::is('admin.categories*'))
                    Kategori Mobil --}}
                @else
                    Panel Admin
                @endif
            </h4>
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=0d6efd&color=fff"
                    class="rounded-circle" width="40" alt="Profile">
            </div>
        </div>

        @yield('admin_content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
