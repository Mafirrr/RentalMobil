@extends('layouts.admin')

@section('admin_content')
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Total Armada</span>
                    <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-car-front text-primary fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">10,293</h3>
                <p class="text-secondary small mb-0">Total unit terdaftar</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Penyewa Aktif</span>
                    <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-person text-warning fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">40,689</h3>
                <p class="text-secondary small mb-0">Total pelanggan unik</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Pendapatan</span>
                    <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-wallet2 text-success fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">Rp 89.0M</h3>
                <p class="text-secondary small mb-0">Pendapatan kotor</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-secondary">Rating Rata-rata</span>
                    <div class="stat-icon bg-danger bg-opacity-10"><i class="bi bi-star text-danger fs-5"></i></div>
                </div>
                <h3 class="fw-bold mb-1">4.9/5</h3>
                <p class="text-secondary small mb-0">2,040 Ulasan total</p>
            </div>
        </div>
    </div>

    <div class="stat-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">Statistik Penyewaan</h5>
            <select class="form-select form-select-sm bg-dark text-white border-secondary w-auto">
                <option>Oktober</option>
                <option>September</option>
            </select>
        </div>
        <canvas id="salesChart" height="100"></canvas>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1k', '5k', '10k', '15k', '20k', '25k', '30k', '35k', '40k', '45k', '50k', '55k', '60k'],
                datasets: [{
                    label: 'Sewa Aktif',
                    data: [25, 30, 45, 38, 52, 85, 40, 50, 62, 30, 75, 68, 55],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0d6efd',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        ticks: {
                            color: '#8a8a8a'
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
