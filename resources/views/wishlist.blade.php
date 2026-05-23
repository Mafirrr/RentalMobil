@extends('layouts.app')

@section('title', 'Wishlist - Capstone')
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

        /* FILTER BAR */
        .filter-bar {
            background: var(--bg-surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 20px 0;
            position: sticky;
            top: 65px;
            z-index: 100;
        }

        .filter-tabs {
            display: flex;
            gap: 4px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 3px;
            padding: 4px;
        }

        .filter-tab {
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            padding: 8px 18px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-tab.active {
            background: var(--accent);
            color: #000;
            font-weight: 700;
        }

        .filter-tab:not(.active):hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .filter-select {
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            padding: 8px 14px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--text-secondary);
            cursor: pointer;
            text-transform: uppercase;
            transition: border-color 0.2s;
            appearance: none;
            padding-right: 30px;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent);
        }

        .search-input-category {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            padding: 9px 16px 9px 38px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--text-primary);
            width: 220px;
            transition: all 0.2s;
        }

        .search-input-category:focus {
            outline: none;
            border-color: var(--accent);
            width: 260px;
        }

        .search-input-category::placeholder {
            color: var(--text-muted);
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
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
            .filter-bar .d-flex {
                flex-wrap: wrap;
                gap: 8px !important;
            }

            .search-input-category {
                width: 100%;
            }

            .filter-tabs {
                width: 100%;
            }

            .filter-tab {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
@endpush
@section('content')
    <form action="{{ route('wishlist') }}" method="GET" id="filterForm">
        <div class="filter-bar">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <input type="hidden" name="type" id="typeInput" value="{{ request('type') }}">
                        <div class="filter-tabs">
                            <button type="button" class="filter-tab {{ request('type') == '' ? 'active' : '' }}"
                                data-value="">
                                <i class="bi bi-grid-3x3-gap"></i> Semua
                            </button>
                            <button type="button" class="filter-tab {{ request('type') == 'car' ? 'active' : '' }}"
                                data-value="car">
                                <i class="bi bi-car-front"></i> Mobil
                            </button>
                            <button type="button" class="filter-tab {{ request('type') == 'motorcycle' ? 'active' : '' }}"
                                data-value="motorcycle">
                                <i class="bi bi-bicycle"></i> Motor
                            </button>
                        </div>

                        <div style="position:relative">
                            <select class="filter-select" name="category" id="categoryFilter" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ request('category') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.7rem;pointer-events:none"></i>
                        </div>

                        <div style="position:relative">
                            <select class="filter-select" name="sort" id="sortFilter" onchange="this.form.submit()">
                                <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Urutkan
                                </option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nama A-Z
                                </option>
                            </select>
                            <i class="bi bi-chevron-down"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.7rem;pointer-events:none"></i>
                        </div>
                    </div>
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="search-input-category" id="searchInput"
                            placeholder="Cari kendaraan..." value="{{ request('search') }}">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="vehicle-grid">
        <div class="container">
            @if (isset($cars) && $cars->isNotEmpty())
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="result-info">Menampilkan <span id="visibleCount">{{ $cars->count() }}</span> kendaraan
                    </div>
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
                    @foreach ($cars as $car)
                        <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil"
                            data-cat="{{ $car->category->name }}" data-name="{{ $car->model }}"
                            data-price="{{ $car->daily_rate }}">
                            <a href="{{ route('detail', $car->id) }}" class="card-link">
                                <div class="car-card">
                                    <div class="car-img-wrap">
                                        <span class="car-badge">{{ strtoupper($car->category->name) }}</span>
                                        <span
                                            class="avail-badge {{ $car->status == 'available' ? 'available' : 'booked' }}">{{ $car->status }}</span>
                                        <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg"
                                            style="width:100%;max-width:240px;position:relative;z-index:1;">
                                            <defs>
                                                <linearGradient id="mc0" x1="0%" y1="0%" x2="100%"
                                                    y2="100%">
                                                    <stop offset="0%" style="stop-color:#282828" />
                                                    <stop offset="100%" style="stop-color:#141414" />
                                                </linearGradient>
                                            </defs>
                                            <ellipse cx="140" cy="110" rx="110" ry="7"
                                                fill="rgba(0,0,0,0.45)" />
                                            <path d="M28 78 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 78 Z"
                                                fill="url(#mc0)" stroke="#282828" stroke-width="1" />
                                            <path d="M70 78 L88 50 Q95 42 107 42 L173 42 Q185 42 192 50 L210 78 Z"
                                                fill="#1c1c1c" stroke="#222" stroke-width="1" />
                                            <circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333"
                                                stroke-width="1.5" />
                                            <circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333"
                                                stroke-width="1.5" />
                                        </svg>
                                    </div>
                                    <div class="car-body">
                                        <div class="car-category">{{ $car->category->name }} · {{ $car->color }}</div>
                                        <div class="car-name">{{ $car->model }}</div>
                                        <div class="car-specs">
                                            <div class="spec-item"><i class="bi bi-people-fill"></i>
                                                {{ $car->car->capacity ?? '-' }} Kursi</div>
                                            <div class="spec-item"><i class="bi bi-gear-fill"></i>
                                                {{ $car->car->transmission ?? '-' }}</div>
                                            <div class="spec-item"><i class="bi bi-droplet-fill"></i>
                                                {{ $car->car->fuel_type ?? '-' }}</div>
                                        </div>
                                        <div class="car-footer">
                                            <div class="car-price"><span class="price-amount">Rp
                                                    {{ number_format($car->daily_rate, 0, ',', '.') }}</span><span
                                                    class="price-label">per hari</span></div>
                                            <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" id="emptyState">
                    @if (request()->routeIs('wishlist.*') || request()->get('view') == 'wishlist')
                        <i class="bi bi-heartbreak d-block" style="font-size: 3rem; color: var(--danger);"></i>
                        <h5
                            style="font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:0.05em;margin-bottom:8px;">
                            WISHLIST KOSONG
                        </h5>
                        <p>Anda belum menambahkan kendaraan apa pun ke dalam daftar keinginan.</p>
                    @else
                        <i class="bi bi-search d-block"></i>
                        <h5
                            style="font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:0.05em;margin-bottom:8px;">
                            TIDAK DITEMUKAN
                        </h5>
                        <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                    @endif
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
            const typeInput = document.getElementById('typeInput');
            const tabs = document.querySelectorAll('.filter-tab');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortFilter = document.getElementById('sortFilter');
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            if (filterForm) {
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        if (typeInput) {

                            typeInput.value = tab.getAttribute('data-value');
                            if (categoryFilter) categoryFilter.value = '';

                            filterForm.submit();
                        }
                    });
                });

                if (categoryFilter) {
                    categoryFilter.addEventListener('change', () => {
                        filterForm.submit();
                    });
                }

                if (sortFilter) {
                    sortFilter.addEventListener('change', () => {
                        filterForm.submit();
                    });
                }

                if (statusFilter) {
                    statusFilter.addEventListener('change', () => {
                        filterForm.submit();
                    });
                }

                if (searchInput) {
                    searchInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            filterForm.submit();
                        }
                    });
                }
            }
        });
    </script>
@endpush
