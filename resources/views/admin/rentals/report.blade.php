@extends('layouts.admin')

@push('styles')
    <style>
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            background-color: #1a1d20 !important;
            border-color: #373b3e !important;
            color: #fff !important;
        }

        .page-item.active .page-link {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }

        .page-item.disabled .page-link {
            background-color: #1a1d20 !important;
            border-color: #373b3e !important;
            opacity: 0.5;
        }
    </style>
@endpush

@section('admin_content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-white mb-0">Laporan Penyewaan</h4>
            <form action="{{ route('admin.report') }}" method="GET" class="d-flex gap-2">
                <input type="date" name="start_date" class="form-control bg-dark text-white border-secondary">
                <input type="date" name="end_date" class="form-control bg-dark text-white border-secondary">
                <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i></button>
                <button type="button" onclick="window.print()" class="btn btn-outline-light"><i
                        class="bi bi-printer"></i></button>
            </form>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card bg-dark border border-secondary p-3 rounded shadow-sm">
                    <small class="text-secondary d-block mb-1">TOTAL PENDAPATAN (SELESAI)</small>
                    <h3 class="text-success fw-bold mb-0">Rp {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-dark border border-secondary p-3 rounded shadow-sm">
                    <small class="text-secondary d-block mb-1">TOTAL UANG MASUK (DP+PELUNASAN)</small>
                    <h3 class="text-primary fw-bold mb-0">Rp {{ number_format($totalPaid) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-dark border border-secondary p-3 rounded shadow-sm">
                    <small class="text-secondary d-block mb-1">SISA PIUTANG (ONGOING)</small>
                    <h3 class="text-warning fw-bold mb-0">Rp {{ number_format($totalPending) }}</h3>
                </div>
            </div>
        </div>

        <div class="stat-card bg-dark border border-secondary p-0 rounded shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="bg-black">
                        <tr>
                            <th class="py-3 px-4 border-secondary small">TANGGAL</th>
                            <th class="py-3 border-secondary small">CUSTOMER</th>
                            <th class="py-3 border-secondary small">ARMADA</th>
                            <th class="py-3 border-secondary small">DURASI</th>
                            <th class="py-3 border-secondary small text-end">TOTAL HARGA</th>
                            <th class="py-3 border-secondary small text-end">DIBAYAR</th>
                            <th class="py-3 border-secondary small text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentals as $rental)
                            @php
                                $start = \Carbon\Carbon::parse($rental->rental_date);
                                $end = \Carbon\Carbon::parse($rental->return_date_scheduled);
                                $duration = $start->diffInDays($end);
                            @endphp
                            <tr class="align-middle">
                                <td class="px-4">
                                    <div class="small">{{ $start->format('d M Y') }}</div>
                                    <div class="text-secondary" style="font-size: 0.7rem;">{{ $start->format('H:i') }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $rental->customer_name }}</div>
                                    <div class="small text-secondary">{{ $rental->customer_phone }}</div>
                                </td>
                                <td>
                                    <div>{{ $rental->car->model }}</div>
                                    <div class="small text-secondary">{{ $rental->car->plate_number }}</div>
                                </td>
                                <td>{{ $duration }} Hari</td>
                                <td class="text-end">Rp {{ number_format($rental->total_price) }}</td>
                                <td class="text-end text-success">Rp {{ number_format($rental->amount_paid) }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge rounded-pill
                                bg-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }}
                                bg-opacity-10
                                text-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }}
                                border border-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }}
                                border-opacity-25 px-3">
                                        {{ strtoupper($rental->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center p-4 border-top border-secondary">
                <div class="small text-secondary">
                    Showing {{ $rentals->firstItem() }} to {{ $rentals->lastItem() }} of {{ $rentals->total() }} entries
                </div>
                <div class="pagination-wrapper">
                    {{ $rentals->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            form,
            .sidebar,
            .navbar {
                display: none !important;
            }

            .stat-card {
                border: 1px solid #000 !important;
                color: #000 !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .table-dark {
                --bs-table-bg: white !important;
                color: black !important;
            }
        }
    </style>
@endsection
