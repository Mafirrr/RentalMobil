@extends('layouts.admin')

@section('admin_content')
    <div class="container-fluid">
        <div class="mb-4">
            <h2 class="fw-bold text-white">Daftar Armada</h2>
            <p class="text-secondary">Kelola armada, harga sewa, dan status ketersediaan mobil Anda.</p>
        </div>

        <div class="card bg-secondary bg-opacity-10 border-0 shadow-sm mb-5" style="border-radius: 20px;">
            <div class="card-body p-3">
                <div class="row align-items-center g-3">
                    <div class="col-lg-8">
                        <form action="{{ route('admin.vehicles') }}" method="GET">
                            <div
                                class="input-group bg-dark rounded-pill px-3 py-1 border border-secondary border-opacity-25">
                                <span class="input-group-text bg-transparent border-0"><i
                                        class="bi bi-search text-secondary"></i></span>
                                <input type="text" name="search" class="form-control bg-transparent border-0 text-white"
                                    placeholder="Cari model mobil atau nomor plat..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 d-flex justify-content-lg-end gap-2">
                        <a href="{{ route('admin.vehicles') }}"
                            class="btn btn-primary rounded-pill px-4 {{ request('status') ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.vehicles', ['status' => 'available']) }}"
                            class="btn btn-outline-secondary border-0 rounded-pill px-4 text-white {{ request('status') == 'available' ? 'bg-primary' : '' }}">Tersedia</a>
                        <a href="{{ route('admin.vehicles', ['status' => 'rented']) }}"
                            class="btn btn-outline-secondary border-0 rounded-pill px-4 text-white {{ request('status') == 'rented' ? 'bg-primary' : '' }}">Disewa</a>
                        <a href="{{ route('admin.vehicles', ['status' => 'maintenance']) }}"
                            class="btn btn-outline-secondary border-0 rounded-pill px-4 text-white {{ request('status') == 'maintenance' ? 'bg-primary' : '' }}">Perbaikan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('admin.vehicles', array_merge(request()->query(), ['type' => ''])) }}"
                class="btn {{ request('type') == '' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">
                Semua
            </a>
            <a href="{{ route('admin.vehicles', array_merge(request()->query(), ['type' => 'car'])) }}"
                class="btn {{ request('type') == 'car' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">
                <i class="bi bi-car-front me-2"></i>Mobil
            </a>
            <a href="{{ route('admin.vehicles', array_merge(request()->query(), ['type' => 'motorcycle'])) }}"
                class="btn {{ request('type') == 'motorcycle' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4">
                <i class="bi bi-bicycle me-2"></i>Motor
            </a>
        </div>
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('admin.vehicles.create') }}" class="text-decoration-none h-100">
                    <div class="card h-100 bg-transparent border-secondary border-opacity-25 d-flex align-items-center justify-content-center py-5"
                        style="border-style: dashed !important; border-width: 2px !important; border-radius: 24px;">
                        <div class="text-center text-secondary">
                            <i class="bi bi-plus-lg display-4 mb-3 d-block text-white"></i>
                            <h5 class="fw-bold text-white">Tambah Kendaraan</h5>
                        </div>
                    </div>
                </a>
            </div>

            @foreach ($vehicles as $vehicle)
                <div class="col-xl-3 col-md-6">
                    <div class="card h-100 bg-secondary bg-opacity-10 border-0 shadow-sm"
                        style="border-radius: 24px; border: 1px solid rgba(255,255,255,0.05) !important;">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="fw-bold mb-0 text-white">{{ $vehicle->model }}</h4>
                                    <p class="text-secondary small mb-0">{{ $vehicle->plate_number }}</p>
                                </div>
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $vehicle->id }}">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </div>

                            <div class="d-flex gap-2 mb-4">
                                @php
                                    $trans =
                                        $vehicle->car->transmission ?? ($vehicle->motorcycle->transmission ?? 'N/A');
                                    $badgeColor = in_array($trans, ['Automatic', 'Matic'])
                                        ? 'text-info border-info'
                                        : 'text-secondary border-light';
                                @endphp

                                <span
                                    class="badge bg-dark {{ $badgeColor }} border border-opacity-25 fw-normal px-2 py-1">
                                    {{ $trans }}
                                </span>
                                <span
                                    class="badge bg-dark text-secondary border border-light border-opacity-25 fw-normal">{{ $vehicle->year }}</span>
                                <span
                                    class="badge bg-dark text-secondary border border-secondary border-opacity-25 fw-normal">Rp
                                    {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2"
                                        style="width: 12px; height: 12px; background-color: {{ $vehicle->status == 'available' ? '#2ecc71' : '#e74c3c' }};">
                                    </div>
                                    <span
                                        class="small text-secondary">{{ $vehicle->status == 'available' ? 'Tersedia' : ($vehicle->status == 'rented' ? 'Disewa' : 'Perbaikan') }}</span>
                                </div>

                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.vehicles.maintenance', $vehicle->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="btn btn-sm rounded-3 px-2 {{ $vehicle->status == 'maintenance' ? 'btn-warning' : 'btn-outline-warning' }}"
                                            title="{{ $vehicle->status == 'maintenance' ? 'Set Available' : 'Set Maintenance' }}"
                                            {{ $vehicle->status == 'rented' ? 'disabled' : '' }}>
                                            <i
                                                class="bi {{ $vehicle->status == 'maintenance' ? 'bi-tools' : 'bi-gear' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                        class="btn btn-primary btn-sm rounded-3 px-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-3 px-2">
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
                        <div class="modal-content bg-dark border-0">
                            <div class="modal-body p-0">
                                @include('admin.cars.show')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $vehicles->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
