@extends('layouts.app')

@section('title', 'Semua Kendaraan - Capstone')
@php $hideFooter = true; @endphp

@push('styles')
    <style>
        .navbar-capstone {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.4s ease;
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-capstone.scrolled {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.4s ease;
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        /* PAGE HEADER */
        .page-header {
            padding: 140px 0 60px;
            background: var(--bg-base);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(200, 255, 0, 0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(200, 255, 0, 0.025) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .page-header-orb {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 255, 0, 0.06) 0%, transparent 70%);
            filter: blur(100px);
            top: -100px;
            right: -50px;
            pointer-events: none;
        }

        .breadcrumb-velox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .breadcrumb-velox a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-velox a:hover {
            color: var(--accent);
        }

        .breadcrumb-velox .sep {
            color: var(--border-accent);
        }

        .breadcrumb-velox .current {
            color: var(--accent);
        }

        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 6vw, 5.5rem);
            line-height: 0.95;
            letter-spacing: 0.03em;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .page-title span {
            color: var(--accent);
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.75;
            max-width: 500px;
        }

        .vehicle-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            padding: 6px 14px;
            background: var(--accent-dim);
            border: 1px solid var(--border-accent);
            border-radius: 2px;
            color: var(--accent);
            margin-top: 20px;
        }

        .filter-bar {
            background: var(--bg-surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            position: sticky;
            top: 65px;
            z-index: 100;
        }

        .filter-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .filter-select {
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            padding: 10px 36px 10px 16px;
            /* Dityesuaikan jarak kanannya agar tidak menabrak teks */
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            /* Sudut sedikit melengkung agar modern */
            color: var(--text-secondary);
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 2px rgba(var(--accent-rgb), 0.1);
            /* Efek glow halus saat fokus */
        }

        /* Style ikon panah drop-down kustom */
        .filter-select-wrapper .select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.75rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .filter-select-wrapper:hover .select-icon {
            color: var(--text-primary);
        }

        /* INPUT PENCARIAN */
        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .search-input-category {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            padding: 10px 16px 10px 40px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--text-primary);
            width: 240px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-input-category:focus {
            outline: none;
            border-color: var(--accent);
            width: 300px;
            /* Melebar dengan transisi halus saat diklik */
            background: var(--bg-surface);
        }

        .search-input-category::placeholder {
            color: var(--text-muted);
        }

        /* SECTION DIVIDER */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 48px 0 32px;
        }

        .section-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-divider-label {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .section-divider-label i {
            color: var(--accent);
            font-size: 1rem;
        }

        .section-divider-count {
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            padding: 3px 8px;
            background: var(--accent-dim);
            border: 1px solid var(--border-accent);
            border-radius: 2px;
            color: var(--accent);
        }

        /* VEHICLE CARDS */
        .vehicle-grid {
            padding: 40px 0 80px;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
            cursor: pointer;
        }

        .car-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            transition: all 0.35s ease;
            position: relative;
            height: 100%;
        }

        .car-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }

        .card-link:hover .car-card {
            border-color: var(--border-accent);
            background: var(--bg-card-hover);
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .card-link:hover .car-card::before {
            transform: scaleX(1);
        }

        .motor-card::before {
            background: #00d4ff;
        }

        .card-link:hover .motor-card {
            border-color: rgba(0, 212, 255, 0.3);
        }

        .motor-card .car-badge {
            background: #00d4ff;
            color: #000;
        }

        .motor-card .btn-rent {
            border-color: #00d4ff;
            color: #00d4ff;
        }

        .card-link:hover .motor-card .btn-rent {
            background: #00d4ff;
            color: #000;
        }

        .car-img-wrap {
            background: var(--bg-surface);
            padding: 28px;
            position: relative;
            overflow: hidden;
            height: 175px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .car-img-wrap::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: linear-gradient(transparent, var(--bg-card));
            pointer-events: none;
        }

        .car-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            font-family: 'Space Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.12em;
            padding: 4px 9px;
            background: var(--accent);
            color: #000;
            border-radius: 1px;
            font-weight: 700;
            z-index: 2;
        }

        .avail-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            font-family: 'Space Mono', monospace;
            font-size: 0.55rem;
            letter-spacing: 0.1em;
            padding: 3px 8px;
            border-radius: 1px;
            font-weight: 700;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .avail-badge.available {
            background: rgba(0, 200, 80, 0.15);
            border: 1px solid rgba(0, 200, 80, 0.4);
            color: #00c850;
        }

        .avail-badge.booked {
            background: rgba(255, 80, 80, 0.12);
            border: 1px solid rgba(255, 80, 80, 0.3);
            color: #ff6060;
        }

        .avail-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .car-body {
            padding: 20px 22px 24px;
        }

        .car-category {
            font-size: 0.67rem;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .car-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 0.04em;
            color: var(--text-primary);
            margin-bottom: 14px;
            line-height: 1;
        }

        .car-specs {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .spec-item i {
            color: var(--accent);
            font-size: 0.8rem;
        }

        .car-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .car-price {
            line-height: 1;
        }

        .price-amount {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--text-primary);
        }

        .price-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            display: block;
            margin-top: 2px;
        }

        .btn-rent {
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            padding: 9px 16px;
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            border-radius: 2px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .card-link:hover .btn-rent {
            background: var(--accent);
            color: #000;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            display: none;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .empty-state p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* FADE UP */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .result-info {
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .result-info span {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .filter-bar {
                padding: 12px 0;
            }

            .filter-bar .d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 12px !important;
            }

            .filter-bar .d-flex .d-flex {
                width: 100%;
            }

            .filter-select-wrapper,
            .filter-select,
            .search-wrap,
            .search-input-category {
                width: 100% !important;
                /* Biar penuh di layar HP */
            }
        }

        .pagination {
            background-color: #0f172a;
            padding: 8px;
            border-radius: 8px;
            display: inline-flex;
        }

        .pagination .page-item .page-link {
            background-color: #1e293b;
            color: #94a3b8;
            border: 1px solid #334155;
            margin: 0 4px;
            padding: 8px 16px;
            border-radius: 6px !important;
            transition: all 0.25s ease-in-out;
        }

        .pagination .page-item.active .page-link {
            background-color: rgba(200, 255, 0, 0.9) !important;
            border-color: rgba(200, 255, 0, 1) !important;
            color: #0f172a !important;
            font-weight: bold;
            box-shadow: 0 0 12px rgba(200, 255, 0, 0.6), 0 0 4px rgba(200, 255, 0, 0.4);
        }

        .pagination .page-item .page-link:hover {
            background-color: #334155;
            color: rgba(200, 255, 0, 1);
            border-color: rgba(200, 255, 0, 0.5);
        }

        .pagination .page-link:focus {
            box-shadow: 0 0 0 3px rgba(200, 255, 0, 0.2);
        }

        .pagination .page-item.disabled .page-link {
            background-color: #0f172a;
            color: #475569;
            border-color: #1e293b;
            opacity: 0.6;
        }
    </style>
@endpush
@section('content')
    <section class="page-header">
        <div class="page-header-orb"></div>
        <div class="container position-relative">
            <div class="breadcrumb-velox">
                <a href="{{ route('landing') }}">Beranda</a>
                <span class="sep">/</span>
                <span class="current">Semua Kendaraan</span>
            </div>
            <h1 class="page-title">SEMUA<br><span>KENDARAAN</span></h1>
            <p class="page-subtitle">Temukan kendaraan yang sempurna untuk setiap perjalananmu. Mobil premium dan motor
                tangguh tersedia dengan harga terbaik.</p>
            <div class="vehicle-count-badge">
                <i class="bi bi-collection-fill"></i>
                <span id="totalCount">{{ $cars->count() }} Kendaraan Tersedia</span>
            </div>
        </div>
    </section>

    <form action="{{ route('category') }}" method="GET" id="filterForm">
        <div class="filter-bar">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="filter-select-wrapper">
                            <select class="filter-select" name="category" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ request('category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down select-icon"></i>
                        </div>

                        <div class="filter-select-wrapper">
                            <select class="filter-select" name="sort" id="sortFilter">
                                <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Urutkan
                                </option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nama A-Z
                                </option>
                            </select>
                            <i class="bi bi-chevron-down select-icon"></i>
                        </div>
                    </div>
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="search-input-category" id="searchInput"
                            placeholder="Cari kendaraan..." value="{{ request('search') }}" autocomplete="off">
                    </div>

                </div>
            </div>
        </div>
    </form>


    <div class="vehicle-grid">
        <div class="container">
            @if ($cars->isNotEmpty())
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="result-info">Menampilkan <span id="visibleCount">{{ $cars->count() }}</span>
                        kendaraan</div>
                </div>

                @if ((!request()->filled('type') || request('type') == 'car') && $cars->isNotEmpty())
                    <div class="section-divider" id="mobilDivider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">
                            <i class="bi bi-car-front-fill"></i> MOBIL
                            <span class="section-divider-count" id="mobilCount">{{ $cars->count() }}</span>
                        </div>
                        <div class="section-divider-line"></div>
                    </div>
                @endif

                <div class="row g-4" id="mobilGrid">
                    @foreach ($cars as $index => $car)
                        <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="City Car"
                            data-name="{{ $car->model }}" data-price="{{ $car->daily_rate }}"
                            style="transition-delay:0s">
                            <a href="{{ route('detail', $car->id) }}" class="card-link">
                                <div class="car-card">
                                    <div class="car-img-wrap">
                                        <span class="car-badge">{{ strtoupper($car->category->name) }}</span>
                                        <span
                                            class="avail-badge {{ $car->status == 'available' ? 'available' : 'booked' }}">{{ $car->status }}</span>

                                        <div class="img-aspect-container"
                                            style="width: 100%; aspect-ratio: 280 / 120; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            @if (isset($car->images_data['front']) && $car->images_data['front'] !== null)
                                                <img src="{{ $car->images_data['front'] }}" alt="{{ $car->model }}"
                                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg"
                                                    style="width:100%;max-width:240px;position:relative;z-index:1;">
                                                    <defs>
                                                        <linearGradient id="mc{{ $index }}" x1="0%"
                                                            y1="0%" x2="100%" y2="100%">
                                                            <stop offset="0%" style="stop-color:#282828" />
                                                            <stop offset="100%" style="stop-color:#141414" />
                                                        </linearGradient>
                                                    </defs>
                                                    <ellipse cx="140" cy="110" rx="110" ry="7"
                                                        fill="rgba(0,0,0,0.45)" />
                                                    <path
                                                        d="M28 78 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 78 Z"
                                                        fill="url(#mc{{ $index }})" stroke="#282828"
                                                        stroke-width="1" />
                                                    <path d="M70 78 L88 50 Q95 42 107 42 L173 42 Q185 42 192 50 L210 78 Z"
                                                        fill="#1c1c1c" stroke="#222" stroke-width="1" />
                                                    <circle cx="72" cy="101" r="18" fill="#0e0e0e"
                                                        stroke="#333" stroke-width="1.5" />
                                                    <circle cx="208" cy="101" r="18" fill="#0e0e0e"
                                                        stroke="#333" stroke-width="1.5" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="car-body">
                                        <div class="car-category">{{ $car->category->name }} · {{ $car->color }}</div>
                                        <div class="car-name">{{ $car->model }}</div>
                                        <div class="car-specs">
                                            <div class="spec-item"><i class="bi bi-people-fill"></i>
                                                {{ $car->car->capacity }} Kursi</div>
                                            <div class="spec-item"><i class="bi bi-gear-fill"></i>
                                                {{ $car->car->transmission }}</div>
                                            <div class="spec-item"><i class="bi bi-droplet-fill"></i>
                                                {{ $car->car->fuel_type }}</div>
                                        </div>
                                        <div class="car-footer">
                                            <div class="car-price">
                                                <span class="price-amount">Rp
                                                    {{ number_format($car->daily_rate, 0, ',', '.') }}</span>
                                                <span class="price-label">per hari</span>
                                            </div>
                                            <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $cars->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-state" id="emptyState">
                    <i class="bi bi-search d-block"></i>
                    <h5
                        style="font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:0.05em;margin-bottom:8px;">
                        TIDAK DITEMUKAN</h5>
                    <p>Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fadeEls = document.querySelectorAll('.fade-up');
            if (fadeEls.length > 0) {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(e => {
                        if (e.isIntersecting) e.target.classList.add('visible');
                    });
                }, {
                    threshold: 0.08
                });
                fadeEls.forEach(el => observer.observe(el));
            }

            const filterForm = document.getElementById('filterForm');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortFilter = document.getElementById('sortFilter');
            const searchInput = document.getElementById('searchInput');

            if (categoryFilter) {
                categoryFilter.addEventListener('change', () => filterForm.submit());
            }
            if (sortFilter) {
                sortFilter.addEventListener('change', () => filterForm.submit());
            }
            if (searchInput && filterForm) {
                let searchTimeout;
                searchInput.addEventListener('input', () => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                });

                const val = searchInput.value;
                searchInput.value = '';
                searchInput.focus();
                searchInput.value = val;
            }
        });
    </script>
@endpush
