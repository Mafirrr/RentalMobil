@extends('layouts.app')
@section('title', 'Riwayat - Capstone')
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
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .breadcrumb-velox a {
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
    <form action="{{ route('riwayat') }}" method="GET" id="filterForm">
        <div class="filter-bar">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">

                        <div class="filter-tabs">
                            <button type="button" class="filter-tab {{ request('status') == '' ? 'active' : '' }}"
                                data-value="">
                                <i class="bi bi-grid-3x3-gap"></i> Semua Status
                            </button>
                            <button type="button" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}"
                                data-value="pending">
                                <i class="bi bi-clock-history"></i> Menunggu
                            </button>
                            <button type="button" class="filter-tab {{ request('status') == 'ongoing' ? 'active' : '' }}"
                                data-value="ongoing">
                                <i class="bi bi-play-circle"></i> Berjalan
                            </button>
                            <button type="button" class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}"
                                data-value="completed">
                                <i class="bi bi-check-circle"></i> Selesai
                            </button>
                        </div>

                        <!-- Dropdown Jenis Kendaraan -->
                        <div style="position:relative">
                            <select class="filter-select" name="type" id="typeFilter" onchange="this.form.submit()">
                                <option value="">Semua Tipe</option>
                                <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Mobil</option>
                                <option value="motorcycle" {{ request('type') == 'motorcycle' ? 'selected' : '' }}>Motor
                                </option>
                            </select>
                            <i class="bi bi-chevron-down"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:var(--text-secondary);font-size:0.7rem;pointer-events:none"></i>
                        </div>
                    </div>

                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="search-input-category" id="searchInput"
                            placeholder="Cari kode atau kendaraan..." value="{{ request('search') }}">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="vehicle-grid">
        <div class="container">
            @if ($bookings->isNotEmpty())
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="result-info">Menampilkan <span id="visibleCount">{{ $bookings->count() }}</span> riwayat
                        pesanan</div>
                </div>

                <div class="row g-4">
                    @foreach ($bookings as $booking)
                        @php
                            $vehicle = $booking->vehicle;
                            $isCar = $vehicle->car ? true : false;
                        @endphp

                        <div class="col-xl-4 col-lg-6 col-md-6 fade-up" style="transition-delay: 0.1s">
                            <div class="car-card {{ !$isCar ? 'motor-card' : '' }} p-0">

                                <div class="p-3 border-bottom d-flex align-items-center justify-content-between"
                                    style="background: rgba(255,255,255,0.02)">
                                    <div>
                                        <span class="text-secondary small d-block">Nota / Kode Sewa</span>
                                        <strong
                                            style="font-family: monospace; color: var(--text-main);">#{{ $booking->merchant_ref }}</strong>
                                    </div>

                                    @if ($booking->status == 'pending')
                                        <span class="badge bg-warning text-dark px-2 py-1 small"><i class="bi bi-clock"></i>
                                            Menunggu Bayar</span>
                                    @elseif($booking->status == 'ongoing')
                                        <span class="badge bg-primary px-2 py-1 small"><i class="bi bi-arrow-repeat"></i>
                                            Sedang Digunakan</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge bg-success px-2 py-1 small"><i class="bi bi-check2-all"></i>
                                            Selesai Sewa</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1 small"><i class="bi bi-x-circle"></i>
                                            Batal</span>
                                    @endif
                                </div>

                                <div class="car-body p-3">
                                    <div class="car-category">
                                        {{ strtoupper($vehicle->category->name) }} · {{ $vehicle->color }}
                                        <span class="float-end text-secondary">
                                            @if ($isCar)
                                                <i class="bi bi-car-front-fill"></i> Mobil
                                            @else
                                                <i class="bi bi-bicycle" style="color:#00d4ff"></i> Motor
                                            @endif
                                        </span>
                                    </div>
                                    <div class="car-name mb-3">{{ $vehicle->model }}</div>

                                    <div class="p-2 mb-3 rounded"
                                        style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05)">
                                        <div class="row text-center">
                                            <div class="col-5">
                                                <small class="text-secondary d-block" style="font-size: 0.75rem;">TGL
                                                    MULAI</small>
                                                <span class="small font-weight-bold"
                                                    style="color: var(--text-main);">{{ date('d M Y', strtotime($booking->rental_date)) }}</span>
                                            </div>
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-arrow-right text-secondary"></i>
                                            </div>
                                            <div class="col-5">
                                                <small class="text-secondary d-block" style="font-size: 0.75rem;">TGL
                                                    SELESAI</small>
                                                <span class="small font-weight-bold"
                                                    style="color: var(--text-main);">{{ date('d M Y', strtotime($booking->return_date_scheduled)) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="car-specs mb-3">
                                        @if ($isCar)
                                            <div class="spec-item"><i class="bi bi-people-fill"></i>
                                                {{ $vehicle->car->capacity ?? '-' }} Kursi</div>
                                            <div class="spec-item"><i class="bi bi-gear-fill"></i>
                                                {{ $vehicle->car->transmission ?? '-' }}</div>
                                        @else
                                            <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i>
                                                {{ $vehicle->motorcycle->engine_capacity ?? '-' }}cc</div>
                                            <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i>
                                                {{ $vehicle->motorcycle->transmission ?? '-' }}</div>
                                        @endif
                                    </div>

                                    <div class="car-footer pt-2 border-top">
                                        <div class="car-price">
                                            <span class="price-amount" style="font-size: 1.2rem;">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </span>
                                            <span class="price-label">Total ({{ $booking->duration }} Hari)</span>
                                        </div>

                                        {{-- <a href="#" class="btn-rent text-decoration-none">
                                            INVOICE <i class="bi bi-arrow-right"></i>
                                        </a> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" id="emptyState">
                    <i class="bi bi-clock-history d-block mb-3"
                        style="font-size: 3rem; color: var(--text-secondary);"></i>
                    <h5
                        style="font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:0.05em;margin-bottom:8px;">
                        BELUM ADA RIWAYAT
                    </h5>
                    <p>Anda belum pernah melakukan pemesanan atau sewa kendaraan.</p>
                    <a href="{{ route('category') }}" class="btn btn-outline-light btn-sm mt-2 px-4 rounded-pill">
                        Sewa Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.getElementById('statusInput').value = this.getAttribute('data-value');
                document.getElementById('filterForm').submit();
            });
        });
    </script>
@endsection
