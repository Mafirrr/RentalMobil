<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-base: #050505;
            --bg-surface: #0b0b0b;
            --bg-card: #111111;
            --bg-card-hover: #151515;

            --text-primary: #f5f5f5;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;

            --accent: #c8ff00;
            --accent-glow: rgba(200, 255, 0, 0.35);
            --accent-dim: rgba(200, 255, 0, 0.08);

            --border: rgba(255, 255, 255, 0.06);
            --border-accent: rgba(200, 255, 0, 0.2);

            --gradient-hero:
                radial-gradient(circle at top left, rgba(200, 255, 0, 0.08), transparent 35%),
                radial-gradient(circle at bottom right, rgba(100, 120, 255, 0.06), transparent 30%),
                #050505;
        }

        body {
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border);
            padding: 32px 24px;
        }

        .navbar-brand {
            font-size: 2rem;
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.08em;
            color: var(--text-primary) !important;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        /* NAVIGATION */
        .nav-link {
            color: var(--text-secondary);
            border: 1px solid transparent;
            border-radius: 4px;
            padding: 14px 18px;
            margin-bottom: 8px;
            transition: all .25s ease;
            font-size: .92rem;
            letter-spacing: .04em;
        }

        .nav-link i {
            color: var(--accent);
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--accent-dim);
            border-color: var(--border-accent);
            color: var(--text-primary);
            transform: translateX(4px);
            box-shadow: 0 0 25px rgba(200, 255, 0, 0.08);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
            background: var(--gradient-hero);
            position: relative;
        }

        /* HEADER */
        h4 {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: .06em;
            font-size: 2.2rem;
        }

        /* CARDS */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            transition: all .3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--accent), transparent);
            opacity: 0;
            transition: opacity .3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-accent);
            background: var(--bg-card-hover);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        /* ICONS */
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 4px;
            background: var(--accent-dim) !important;
            border: 1px solid var(--border-accent);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            color: var(--accent) !important;
        }

        /* TEXT */
        .text-secondary {
            color: var(--text-secondary) !important;
        }

        h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.4rem;
            letter-spacing: .04em;
        }

        /* FORM */
        .form-select {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: 2px;
        }

        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 .15rem rgba(200, 255, 0, 0.12);
        }

        /* CHART CONTAINER */
        canvas {
            margin-top: 10px;
        }

        /* PROFILE */
        .rounded-circle {
            border: 2px solid var(--accent);
            box-shadow: 0 0 20px rgba(200, 255, 0, 0.15);
        }

        /* LOGOUT */
        .btn-link {
            color: #ff6b6b !important;
            transition: .2s;
        }

        .btn-link:hover {
            color: #ff8787 !important;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #222;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #333;
        }

        hr {
            border-color: var(--border);
        }

        /* GLOBAL THEME OVERRIDE */
        .card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
        }

        .card-body {
            color: var(--text-primary);
        }

        .bg-secondary,
        .bg-dark {
            background: var(--bg-card) !important;
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 1 !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .border-secondary {
            border-color: var(--border) !important;
        }

        .btn-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #000 !important;
        }

        .btn-primary:hover {
            background: #d8ff4d !important;
            border-color: #d8ff4d !important;
        }

        .btn-outline-secondary,
        .btn-outline-primary {
            background: transparent !important;
            border: 1px solid var(--border) !important;
            color: var(--text-secondary) !important;
        }

        .btn-outline-secondary:hover,
        .btn-outline-primary:hover {
            background: var(--accent-dim) !important;
            border-color: var(--border-accent) !important;
            color: var(--accent) !important;
        }

        .form-control,
        .form-select,
        input,
        select {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        .modal-content {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
        }

        .badge {
            border-radius: 2px;
            padding: 6px 10px;
        }

        .pagination .page-link {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .pagination .page-item.active .page-link {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
        }

        /* SEMUA ICON */
        .bi {
            color: var(--accent) !important;
        }

        /* ICON EDIT */
        .btn-primary .bi,
        .bi-pencil {
            color: #ffffff !important;
        }

        /* ICON DELETE */
        .btn-danger .bi,
        .bi-trash {
            color: #ff6b6b !important;
        }

        /* ICON MAINTENANCE */
        .btn-warning .bi,
        .bi-tools,
        .bi-gear {
            color: #facc15 !important;
        }

        /* ICON INFO */
        .btn-outline-info .bi,
        .bi-info-circle {
            color: #38bdf8 !important;
        }

        /* ICON SEARCH */
        .bi-search {
            color: var(--accent) !important;
        }

        /* ICON SIDEBAR */
        .nav-link .bi {
            color: var(--accent) !important;
        }

        /* ICON MOTOR */
        .bi-bicycle {
            color: #8b5cf6 !important;
        }

        /* ICON MOBIL */
        .bi-car-front {
            color: #22c55e !important;
        }
    </style>
</head>

<body>

    <div class="sidebar d-flex flex-column p-4">
        <a class="navbar-brand mb-5" href="#">
            CAP<span>STONE</span>
        </a>

        <ul class="nav nav-pills flex-column mb-auto">
            <li><a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i
                        class="bi bi-speedometer2 me-3"></i>Dashboard
                </a></li>

            <a href="{{ route('admin.vehicles') }}" class="nav-link {{ Route::is('admin.vehicles*') ? 'active' : '' }}">
                <i class="bi bi-car-front me-3"></i>Armada
            </a>
            <li><a href="{{ route('admin.rentals') }}"
                    class="nav-link {{ Route::is('admin.rentals*') ? 'active' : '' }}"><i
                        class="bi bi-person-check me-3"></i>Penyewaan</a></li>
            <li><a href="{{ route('admin.report') }}"
                    class="nav-link {{ Route::is('admin.report') ? 'active' : '' }}"><i
                        class="bi bi-person-check me-3"></i>Laporan
                </a></li>
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
                @elseif(Route::is('admin.vehicles*'))
                    Manajemen Armada
                @elseif(Route::is('admin.rentals*'))
                    Input Penyewaan
                @elseif(Route::is('admin.report*'))
                    Laporan Penyewaan
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
