@extends('layouts.admin')

@push('styles')
    <style>
        .glass-card {
            background: var(--bg-card);
            border: 1px solid var(--border) !important;
            border-radius: 6px;
            backdrop-filter: blur(20px);
            transition: all .3s ease;
            overflow: hidden;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right,
                    rgba(200, 255, 0, 0.06),
                    transparent 35%);
            opacity: 0;
            transition: opacity .3s;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-accent) !important;
            background: var(--bg-card-hover);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
        }

        .glass-card:hover::before {
            opacity: 1;
        }

        .premium-search {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            transition: .25s;
            min-height: 56px;
        }

        .premium-search:focus-within {
            border-color: var(--border-accent);
            box-shadow: 0 0 25px rgba(200, 255, 0, 0.08);
        }

        .premium-input {
            background: transparent !important;
            border: none !important;
            color: var(--text-primary) !important;
            box-shadow: none !important;
            padding-left: 0;
            font-size: .95rem;
        }

        .premium-input::placeholder {
            color: var(--text-muted);
        }

        .search-icon {
            color: var(--accent);
            font-size: 1rem;
        }

        .filter-btn {
            border-radius: 2px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-secondary);
            transition: .2s;
            padding: 10px 20px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--accent-dim);
            border-color: var(--border-accent);
            color: var(--accent);
        }

        .vehicle-badge {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            padding: 6px 10px;
            border-radius: 2px;
            font-size: .72rem;
        }

        .vehicle-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-available {
            background: #c8ff00;
            box-shadow: 0 0 10px rgba(200, 255, 0, .5);
        }

        .status-rented {
            background: #ff5858;
        }

        .status-maintenance {
            background: #ffc107;
        }

        .premium-btn {
            border-radius: 2px;
            border: 1px solid var(--border);
            background: var(--bg-surface);
            color: var(--text-secondary);
            transition: .2s;
        }

        .premium-btn:hover {
            border-color: var(--border-accent);
            color: var(--accent);
            background: var(--accent-dim);
        }

        .premium-btn-primary {
            background: var(--accent);
            border: none;
            color: #000;
            font-weight: 700;
        }

        .premium-btn-primary:hover {
            background: #d7ff42;
            color: #000;
        }

        .premium-add-card {
            border: 1px dashed var(--border-accent) !important;
            background: rgba(200, 255, 0, 0.02);
            transition: .3s;
            border-radius: 6px;
        }

        .premium-add-card:hover {
            background: rgba(200, 255, 0, 0.05);
            transform: translateY(-3px);
            box-shadow: 0 0 30px rgba(200, 255, 0, 0.08);
        }

        .modal-content {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 4px;
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

@section('admin_content')
    <div class="container-fluid">
        <div class="glass-card mb-5">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-lg-8">
                        <form action="{{ route('admin.vehicles') }}" method="GET">
                            <div class="premium-search d-flex align-items-center px-3">
                                <i class="bi bi-search me-3 search-icon"></i>
                                <input type="text" name="search" class="form-control premium-input"
                                    placeholder="Cari model kendaraan atau nomor plat..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-lg-end gap-2 flex-wrap">
                        <a href="{{ route('admin.vehicles') }}"
                            class="btn filter-btn {{ request('status') ? '' : 'active' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.vehicles', ['status' => 'available']) }}"
                            class="btn filter-btn {{ request('status') == 'available' ? 'active' : '' }}">
                            Tersedia
                        </a>
                        <a href="{{ route('admin.vehicles', ['status' => 'rented']) }}"
                            class="btn filter-btn {{ request('status') == 'rented' ? 'active' : '' }}">
                            Disewa
                        </a>
                        <a href="{{ route('admin.vehicles', ['status' => 'maintenance']) }}"
                            class="btn filter-btn {{ request('status') == 'maintenance' ? 'active' : '' }}">
                            Perbaikan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('admin.vehicles.create') }}" class="text-decoration-none h-100">
                    <div class="card h-100 premium-add-card d-flex align-items-center justify-content-center py-5">
                        <div class="text-center text-secondary">
                            <i class="bi bi-plus-lg display-4 mb-3 d-block text-white"></i>
                            <h5 class="fw-bold text-white">Tambah Kendaraan</h5>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($vehicles as $vehicle)
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h4 class="fw-bold mb-0 text-white">
                                        {{ $vehicle->model }}
                                    </h4>
                                    <p class="text-secondary small mb-0">
                                        {{ $vehicle->plate_number }}
                                    </p>
                                </div>
                                <button type="button" class="btn premium-btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $vehicle->id }}">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </div>
                            <div class="d-flex gap-2 flex-wrap mb-4">
                                @php
                                    $trans =
                                        $vehicle->car->transmission ?? ($vehicle->motorcycle->transmission ?? 'N/A');
                                @endphp
                                <span class="vehicle-badge">
                                    {{ $trans }}
                                </span>
                                <span class="vehicle-badge">
                                    {{ $vehicle->year }}
                                </span>
                                <span class="vehicle-badge">
                                    Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="vehicle-status rounded-circle me-2
                                        {{ $vehicle->status == 'available'
                                            ? 'status-available'
                                            : ($vehicle->status == 'rented'
                                                ? 'status-rented'
                                                : 'status-maintenance') }}">
                                    </div>
                                    <span class="small text-secondary">
                                        {{ $vehicle->status == 'available' ? 'Tersedia' : ($vehicle->status == 'rented' ? 'Disewa' : 'Perbaikan') }}
                                    </span>
                                </div>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.vehicles.maintenance', $vehicle->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn premium-btn btn-sm"
                                            {{ $vehicle->status == 'rented' ? 'disabled' : '' }}>
                                            <i
                                                class="bi
                                                {{ $vehicle->status == 'maintenance' ? 'bi-tools' : 'bi-gear' }}">
                                            </i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                        class="btn premium-btn premium-btn-primary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn premium-btn btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="detailModal{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                @include('admin.cars.show')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $vehicles->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
