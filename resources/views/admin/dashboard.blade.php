@extends('layouts.admin')

@section('admin_content')
    <div class="row g-4 mb-4">
        <!-- Total Armada -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Total Armada</span>
                    <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-car-front text-primary fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($totalArmada, 0, ',', '.') }}</h3>
                <p class="text-secondary small mb-0">Total unit terdaftar</p>
            </div>
        </div>

        <!-- Penyewa Aktif -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Penyewa Aktif</span>
                    <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-person text-warning fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($penyewaAktif, 0, ',', '.') }}</h3>
                <p class="text-secondary small mb-0">Reservasi atau Digunakan</p>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Pendapatan</span>
                    <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-wallet2 text-success fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">
                    @if ($totalPendapatan >= 1000000000)
                        Rp {{ number_format($totalPendapatan / 1000000000, 1, ',', '.') }}M
                    @elseif($totalPendapatan >= 1000000)
                        Rp {{ number_format($totalPendapatan / 1000000, 1, ',', '.') }}Jt
                    @else
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    @endif
                </h3>
                <p class="text-secondary small mb-0">Pendapatan kotor sah</p>
            </div>
        </div>

        <!-- Rating -->
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Rating Rata-rata</span>
                    <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-star text-danger fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($ratingRataRata, 1, '.', ',') }}/5</h3>
                <p class="text-secondary small mb-0">{{ number_format($totalUlasan, 0, ',', '.') }} Ulasan total</p>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="stat-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">Statistik Penyewaan</h5>
            <form action="{{ url()->current() }}" method="GET" id="monthFilterForm">
                <select name="month" class="form-select form-select-sm bg-dark text-white border-secondary w-auto"
                    onchange="document.getElementById('monthFilterForm').submit();">
                    @foreach ($availableMonths as $month)
                        <option value="{{ $month['value'] }}"
                            {{ $selectedMonthValue == $month['value'] ? 'selected' : '' }}>
                            {{ $month['label'] }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <canvas id="salesChart" height="100"></canvas>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const chartLabels = {!! json_encode($chartLabels) !!};
        const chartData = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Sewa Aktif',
                    data: chartData,
                    borderColor: '#facc15',
                    backgroundColor: 'rgba(250, 204, 21, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#facc15',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.parsed.y} Transaksi`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        ticks: {
                            color: '#8a8a8a',
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        ticks: {
                            color: '#8a8a8a'
                        }
                    }
                }
            }
        });
    </script>
@endpush
