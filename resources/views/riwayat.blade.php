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

        .payment-summary {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
        }

        .payment-summary-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            gap: 10px;

            background: rgba(255, 255, 255, 0.02);

            font-family: 'Space Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;

            color: var(--text-primary);
        }

        .payment-summary-header i {
            color: var(--accent);
        }

        .payment-summary-body {
            padding: 16px;
        }

        .payment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 12px;
        }

        .payment-label {
            color: var(--text-secondary);
            font-size: 0.82rem;
        }

        .payment-value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .payment-row-highlight {
            padding-top: 12px;
            margin-top: 12px;

            border-top: 1px dashed rgba(255, 255, 255, 0.08);
        }

        .payment-paid {
            color: #00d26a;

            font-size: 0.82rem;
            font-weight: 600;

            display: flex;
            align-items: center;
            gap: 6px;
        }

        .payment-progress-wrap {
            margin-top: 18px;
        }

        .payment-progress {
            width: 100%;
            height: 8px;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.06);
        }

        .payment-progress-bar {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, var(--accent), #d8ff52);
            transition: width 0.4s ease;
        }

        .btn-pay-remaining {
            margin-top: 18px;

            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 11px 16px;

            border: 1px solid #ffc107;
            color: #ffc107;

            border-radius: 3px;

            font-family: 'Space Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.08em;

            transition: all 0.25s ease;
        }

        .btn-pay-remaining:hover {
            background: #ffc107;
            color: #000;
        }

        .payment-success-info {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 3px;
            background: rgba(0, 210, 106, 0.1);
            border: 1px solid rgba(0, 210, 106, 0.2);
            color: #00d26a;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .payment-cancel-info {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 3px;
            background: rgba(210, 35, 0, 0.1);
            border: 1px solid rgba(210, 35, 0, 0.1);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .payment-confirm-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .payment-confirm-subtitle {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .payment-confirm-title {
            font-weight: 800;
            color: #111;
            margin-top: 2px;
        }

        .payment-status-box {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px;
            border-radius: 14px;
            background: rgba(0, 82, 156, 0.05);
            border: 1px solid rgba(0, 82, 156, 0.12);
        }

        .payment-status-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #00529c;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .payment-status-title {
            font-weight: 700;
            color: #111;
            margin-bottom: 4px;
        }

        .payment-status-desc {
            font-size: 0.88rem;
            color: #6c757d;
            line-height: 1.5;
        }

        .confirm-payment-card {
            border: 1px solid #e9ecef;
            border-radius: 14px;

            padding: 18px;
            background: #f8f9fa;
        }

        .confirm-payment-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 14px;

            color: #495057;
            font-size: 0.95rem;
        }

        .confirm-payment-row:last-child {
            margin-bottom: 0;
        }

        .confirm-payment-row.total {
            padding-top: 14px;
            border-top: 1px dashed #ced4da;

            font-size: 1.05rem;
            font-weight: 700;
        }

        .payment-note-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            padding: 14px;

            border-radius: 12px;

            background: #fff8e1;
            border: 1px solid #ffe082;

            color: #8d6e63;
            font-size: 0.85rem;
        }

        .btn-confirm-payment {
            padding: 13px 26px;
            border-radius: 12px;
            color: #ffc107;
            border-color: #ffbf00;
            font-weight: 700;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .btn-confirm-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 82, 156, 0.25);
        }

        .no-va {
            color: #000;
            font-weight: 400;
        }

        .col {
            color: #495057;
        }

        .star-rating-wrapper {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }

        .star-rating-wrapper input:checked~label,
        .star-rating-wrapper label:hover,
        .star-rating-wrapper label:hover~label {
            font-weight: bold;
        }

        .star-rating-wrapper input:checked~label::before,
        .star-rating-wrapper label:hover::before,
        .star-rating-wrapper label:hover~label::before {
            content: "\f586";
        }
    </style>
@endpush
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <x-booking-card :booking="$booking" />
                    @endforeach
                </div>
                @foreach ($bookings as $booking)
                    @php
                        $total = $booking->total_price ?? 0;
                        $remaining = $booking->remaining_amount;
                        if ($remaining == 0 && $total > 0) {
                            $paid = $total;
                        } else {
                            $paid = $total - $remaining;
                        }
                        $percent = $total > 0 ? min(($paid / $total) * 100, 100) : 0;
                    @endphp

                    @if ($remaining > 0)
                        <div class="modal fade" id="paymentModal{{ $booking->id }}" tabindex="-1"
                            aria-labelledby="paymentModalLabel{{ $booking->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content text-dark">

                                    <div class="modal-header">
                                        <div>
                                            <small class="text-muted d-block text-start">Pelunasan Pembayaran</small>
                                            <h5 class="modal-title fw-bold text-dark"
                                                id="paymentModalLabel{{ $booking->id }}">
                                                #{{ $booking->merchant_ref }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body text-start">
                                        <div class="payment-modal-box mb-3">
                                            <div class="payment-modal-row">
                                                <span>Total Rental</span>
                                                <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="payment-modal-row">
                                                <span>DP Dibayar</span>
                                                <strong class="text-info">Rp
                                                    {{ number_format($paid, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="payment-modal-row total">
                                                <span>Sisa Pembayaran</span>
                                                <strong class="text-danger">Rp
                                                    {{ number_format($remaining, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>

                                        <div class="payment-alert mb-4">
                                            <i class="bi bi-info-circle-fill"></i>
                                            Silakan pilih salah satu metode di bawah untuk menyelesaikan pelunasan
                                            transaksi rental Anda.
                                        </div>

                                        <div class="form-section">
                                            <div class="mb-3">
                                                <label class="fw-bold text-dark mb-1">Metode Pembayaran</label>
                                                <div class="text-muted small">Pilih virtual account atau transfer manual
                                                </div>
                                            </div>

                                            <div class="pay-methods">
                                                <label class="pay-method-item">
                                                    <input type="radio" name="paymethod_{{ $booking->id }}"
                                                        value="briva" checked>
                                                    <div class="pay-method-radio"></div>
                                                    <div class="pay-method-icon"
                                                        style="background:#00529c; color:#fff; font-weight:700; font-size:0.65rem;">
                                                        BRI</div>
                                                    <div class="pay-method-info">
                                                        <div class="pay-method-name">BRIVA</div>
                                                        <div class="pay-method-desc">Virtual Account BRI</div>
                                                    </div>
                                                </label>

                                                <label class="pay-method-item">
                                                    <input type="radio" name="paymethod_{{ $booking->id }}"
                                                        value="bniva">
                                                    <div class="pay-method-radio"></div>
                                                    <div class="pay-method-icon"
                                                        style="background:#ff6600; color:#fff; font-weight:700; font-size:0.65rem;">
                                                        BNI</div>
                                                    <div class="pay-method-info">
                                                        <div class="pay-method-name">BNI VA</div>
                                                        <div class="pay-method-desc">Virtual Account BNI</div>
                                                    </div>
                                                </label>

                                                <label class="pay-method-item">
                                                    <input type="radio" name="paymethod_{{ $booking->id }}"
                                                        value="mandiriva">
                                                    <div class="pay-method-radio"></div>
                                                    <div class="pay-method-icon"
                                                        style="background:#003882; color:#ffde00; font-weight:700; font-size:0.6rem;">
                                                        MDR</div>
                                                    <div class="pay-method-info">
                                                        <div class="pay-method-name">Mandiri VA</div>
                                                        <div class="pay-method-desc">Virtual Account Mandiri</div>
                                                    </div>
                                                </label>

                                                <label class="pay-method-item">
                                                    <input type="radio" name="paymethod_{{ $booking->id }}"
                                                        value="transfer">
                                                    <div class="pay-method-radio"></div>
                                                    <div class="pay-method-icon bg-secondary text-white">
                                                        <i class="bi bi-bank"></i>
                                                    </div>
                                                    <div class="pay-method-info">
                                                        <div class="pay-method-name">Transfer Bank</div>
                                                        <div class="pay-method-desc">Transfer Manual Antar Bank</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <button type="button"
                                                class="btn btn-outline-warning w-100 mt-3 py-2 fw-bold btn-lanjutkan-pembayaran"
                                                data-booking-id="{{ $booking->id }}"
                                                data-merchant-ref="{{ $booking->merchant_ref }}"
                                                data-remaining="{{ $remaining }}">
                                                LANJUTKAN PEMBAYARAN <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="modal fade" id="paymentConfirmModal{{ $booking->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content payment-confirm-content dark-confirm-modal">
                                <div class="modal-header border-0 pb-0">
                                    <div>
                                        <small class="payment-confirm-subtitle">
                                            Konfirmasi Pembayaran
                                        </small>
                                        <h4 class="payment-confirm-title">
                                            #{{ $booking->merchant_ref }}
                                        </h4>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                    </button>
                                </div>
                                <div class="modal-body pt-2">
                                    <div class="payment-status-box mb-4">
                                        <div class="payment-status-icon">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <div>
                                            <div class="payment-status-title">
                                                Pembayaran Aman
                                            </div>
                                            <div class="payment-status-desc">
                                                Pastikan nominal dan metode pembayaran sudah benar sebelum
                                                melanjutkan transaksi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="confirm-payment-card">
                                        <div class="confirm-payment-row">
                                            <span>Total Rental</span>
                                            <strong>
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                        <div class="confirm-payment-row">
                                            <span>DP Dibayar</span>
                                            <strong class="text-info">
                                                Rp {{ number_format($paid, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                        <div class="confirm-payment-row">
                                            <span>Metode Pembayaran</span>
                                            <strong class="text-primary nama-metode-terpilih-{{ $booking->id }}">
                                                Virtual Account
                                            </strong>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                Virtual Account
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="no-va-{{ $booking->id }} text-black">Menghitung...</span>
                                                    <button type="button"
                                                        class="btn btn-link p-0 text-decoration-none lh-1">
                                                        <i class="bi bi-copy fs-6 text-secondary"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="confirm-payment-row total">
                                            <span>Sisa Pembayaran</span>
                                            <strong class="text-warning">
                                                Rp {{ number_format($remaining, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="payment-note-box mt-4">
                                        <i class="bi bi-info-circle"></i>
                                        Setelah pembayaran berhasil, status transaksi akan otomatis diperbarui pada
                                        sistem.
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                                        Kembali
                                    </button>
                                    <button class="btn-confirm-payment" id="payment-finish"
                                        data-booking-id="{{ $booking->id }}"
                                        data-merchant-ref="{{ $booking->merchant_ref }}"
                                        data-remaining="{{ $remaining }}">
                                        BAYAR SEKARANG
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($remaining <= 0 && $booking->status == 'completed')
                        <div class="modal fade" id="ratingModal{{ $booking->id }}" tabindex="-1"
                            aria-labelledby="ratingModalLabel{{ $booking->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-dark">
                                    <div class="modal-header">
                                        <div>
                                            <small class="text-muted d-block text-start">Ulasan Pengalaman Rental</small>
                                            <h5 class="modal-title fw-bold text-dark"
                                                id="ratingModalLabel{{ $booking->id }}">
                                                Transaksi #{{ $booking->merchant_ref }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('rating.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rental_id" value="{{ $booking->id }}">
                                        <div class="modal-body text-start">
                                            <div class="text-center mb-4">
                                                <p class="text-secondary mb-2">Bagaimana kualitas unit dan pelayanan armada
                                                    kami?</p>
                                                <div
                                                    class="star-rating-wrapper fs-2 text-warning d-flex justify-content-center gap-2">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" class="btn-check" name="rating"
                                                            id="star{{ $i }}_{{ $booking->id }}"
                                                            value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                                        <label for="star{{ $i }}_{{ $booking->id }}"
                                                            class="bi bi-star" style="cursor: pointer;"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-dark mb-1">Komentar / Catatan
                                                    Tambahan</label>
                                                <textarea name="comment" class="form-control" rows="3"
                                                    placeholder="Ceritakan pengalaman Anda menggunakan unit kendaraan ini..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light px-4"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">KIRIM
                                                RATING</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let activeTriPayReferences = {};

            const buttons = document.querySelectorAll('.btn-lanjutkan-pembayaran');
            buttons.forEach(button => {
                button.addEventListener('click', async function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    const merchant_ref = this.getAttribute('data-merchant-ref');
                    const remaining = this.getAttribute('data-remaining');

                    const selectedMethodInput = document.querySelector(
                        `input[name="paymethod_${bookingId}"]:checked`);
                    if (!selectedMethodInput) {
                        alert('Silakan pilih metode pembayaran terlebih dahulu.');
                        return;
                    }
                    const paymentMethod = selectedMethodInput.value;
                    console.log(merchant_ref)
                    const originalText = this.innerHTML;
                    this.innerHTML =
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`;
                    this.disabled = true;
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');
                        const response = await fetch('/pembayaran/tripay-api', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                booking_id: bookingId,
                                merchant_ref: merchant_ref,
                                method: paymentMethod,
                                remaining: remaining,
                            })
                        });
                        const result = await response.json();
                        if (!response.ok || !result.success) {
                            console.log(result.detail)
                            throw new Error(result.message ||
                                'Gagal membuat tagihan pembayaran.');
                        }

                        if (result.data && result.data.reference) {
                            activeTriPayReferences[bookingId] = result.data.reference;
                        }

                        const namaMetodePlaceholder = document.querySelector(
                            `.nama-metode-terpilih-${bookingId}`);
                        const nomorVaPlaceholder = document.querySelector(
                            `.no-va-${bookingId}`);

                        if (namaMetodePlaceholder) {
                            namaMetodePlaceholder.textContent = paymentMethod.toUpperCase();
                        }
                        if (nomorVaPlaceholder) {
                            nomorVaPlaceholder.textContent = result.data.account_number ||
                                result.data.pay_code;
                        }

                        const modalPertamaEl = document.getElementById(
                            `paymentModal${bookingId}`);
                        const modalPertama = bootstrap.Modal.getInstance(modalPertamaEl);
                        if (modalPertama) modalPertama.hide();

                        const modalKeduaEl = document.getElementById(
                            `paymentConfirmModal${bookingId}`);
                        const modalKedua = new bootstrap.Modal(modalKeduaEl);
                        modalKedua.show();
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    } finally {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                });
            });

            document.querySelectorAll('[class^="no-va-"]').forEach(el => {
                const btnCopy = el.nextElementSibling;
                if (btnCopy && btnCopy.querySelector('.bi-copy')) {
                    btnCopy.addEventListener('click', function() {
                        navigator.clipboard.writeText(el.textContent.trim());
                        const icon = this.querySelector('i');
                        icon.className = 'bi bi-check text-success fs-6';
                        setTimeout(() => {
                            icon.className = 'bi bi-copy text-secondary fs-6';
                        }, 2000);
                    });
                }
            });

            const finishPaymentButtons = document.querySelectorAll('#payment-finish');
            finishPaymentButtons.forEach(button => {
                button.addEventListener('click', async function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    const merchant_ref = this.getAttribute('data-merchant-ref');
                    const remaining = this.getAttribute('data-remaining');

                    const nomorVaPlaceholder = document.querySelector(`.no-va-${bookingId}`);
                    const namaMetodePlaceholder = document.querySelector(
                        `.nama-metode-terpilih-${bookingId}`);

                    if (!nomorVaPlaceholder || !nomorVaPlaceholder.textContent.trim() ||
                        nomorVaPlaceholder.textContent.includes('...')) {
                        alert('Nomor pembayaran belum siap atau gagal dimuat.');
                        return;
                    }

                    const triPayReference = activeTriPayReferences[bookingId];
                    if (!triPayReference) {
                        alert(
                            'Reference pembayaran tidak ditemukan. Silakan ulangi proses dari awal.'
                        );
                        return;
                    }

                    const noVa = nomorVaPlaceholder.textContent.trim();
                    const paymentMethod = namaMetodePlaceholder ? namaMetodePlaceholder
                        .textContent.trim().toLowerCase() : '';

                    const originalText = this.innerHTML;
                    this.innerHTML =
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...`;
                    this.disabled = true;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');

                        const response = await fetch('/pelunasan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                booking_id: bookingId,
                                merchant_ref: merchant_ref,
                                no_va: noVa,
                                method: paymentMethod,
                                total: remaining,
                                reference: triPayReference,
                            })
                        });

                        const result = await response.json();

                        if (!response.ok || !result.success) {
                            console.log(result.detail);
                            throw new Error(result.detail ||
                                'Gagal menyimpan data pelunasan ke database.');
                        }

                        alert('Data pelunasan berhasil dicatat! Silakan lakukan pembayaran.');

                        const modalKeduaEl = document.getElementById(
                            `paymentConfirmModal${bookingId}`);
                        const modalKedua = bootstrap.Modal.getInstance(modalKeduaEl);
                        if (modalKedua) modalKedua.hide();

                        window.location.reload();
                    } catch (error) {
                        console.error('Error Pelunasan:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    } finally {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                });
            });
        });
    </script>
@endpush
