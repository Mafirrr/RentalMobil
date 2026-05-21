@extends('layouts.admin')

@section('admin_content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="stat-icon bg-primary bg-opacity-10" style="padding: 6px 10px; border-radius: 6px;">
                        <i class="bi bi-filter-square text-primary"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-white">Filter & Cari Transaksi</h6>
                </div>

                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">CARI PENYEWA</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-dark text-white border-secondary"
                                placeholder="Nama atau nomor WA..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-secondary">JENIS ARMADA</label>
                        <select name="vehicle_type" class="form-select bg-dark text-white border-secondary">
                            <option value="">Semua Jenis (Mobil & Motor)</option>
                            <option value="car" {{ request('vehicle_type') == 'car' ? 'selected' : '' }}>Khusus Mobil
                            </option>
                            <option value="motorcycle" {{ request('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>
                                Khusus Motor</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-secondary">STATUS RENTAL</label>
                        <select name="status" class="form-select bg-dark text-white border-secondary">
                            <option value="">Semua Status</option>
                            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                (Berjalan)</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                (Selesai)</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                (Batal)</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <a href="{{ route('admin.rentals') }}" class="btn btn-outline-secondary w-50 py-2 fw-bold"
                            title="Reset Filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                        <button type="submit" class="btn btn-primary text-dark w-50 py-2 fw-bold">
                            <i class="bi bi-funnel" style="color: #000000;"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-white">Daftar Transaksi Masuk</h5>
                    <div class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25 px-3">
                        Total: {{ $recentRentals->count() }} Data Berhasil Dimuat
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-secondary small text-secondary py-3">PENYEWA</th>
                                <th class="border-secondary small text-secondary py-3">ARMADA</th>
                                <th class="border-secondary small text-secondary py-3 text-center">PEMBAYARAN</th>
                                <th class="border-secondary small text-secondary py-3 text-end">STATUS</th>
                                <th class="border-secondary small text-secondary py-3 text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentRentals as $rental)
                                <tr class="align-middle">
                                    <td class="py-3">
                                        <div class="fw-bold text-white">
                                            {{ $rental->user->userDetail->full_name ?? 'Nama Tidak Diisi' }}</div>
                                        <div class="small text-secondary">
                                            <i
                                                class="bi bi-whatsapp text-success me-1"></i>{{ $rental->user->userDetail->phone ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @if ($rental->vehicle)
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge text-uppercase bg-opacity-10 text-black
                                                    {{ $rental->vehicle->vehicle_type == 'car' ? 'bg-info text-info border border-info border-opacity-25' : 'bg-warning text-warning border border-warning border-opacity-25' }}"
                                                    style="font-size: 0.65rem; padding: 2px 6px;">
                                                    {{ $rental->vehicle->vehicle_type == 'car' ? 'Mobil' : 'Motor' }}
                                                </span>
                                                <span class="fw-bold text-white">{{ $rental->vehicle->model }}</span>
                                            </div>
                                            <div class="small text-secondary mt-1">
                                                Plat: {{ $rental->vehicle->plate_number ?? '-' }}
                                                @if ($rental->vehicle->vehicle_type == 'motorcycle' && $rental->vehicle->motorcycle)
                                                    · {{ $rental->vehicle->motorcycle->engine_capacity }} CC
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-danger small">Unit Terhapus</div>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="small text-success fw-bold" style="font-size: 0.8rem;">
                                            Masuk: Rp {{ number_format($rental->total_paid ?? 0, 0, ',', '.') }}
                                        </div>
                                        <div class="small text-warning fw-bold" style="font-size: 0.8rem;">
                                            Sisa: Rp {{ number_format($rental->remaining_payment, 0, ',', '.') }}
                                        </div>
                                        <div class="small text-secondary" style="font-size: 0.72rem;">
                                            Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="text-end py-3">
                                        @php
                                            $statusColor = match ($rental->status) {
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'pending' => 'warning',
                                                default => 'primary',
                                            };
                                        @endphp

                                        <span
                                            class="badge rounded-pill bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} border border-{{ $statusColor }} border-opacity-25 px-3 text-white">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="d-flex justify-content-end gap-1">
                                            @if ($rental->status == 'ongoing')
                                                @php
                                                    $isTimeToCheckIn = now()->greaterThanOrEqualTo(
                                                        \Carbon\Carbon::parse(
                                                            $rental->return_date_scheduled,
                                                        )->startOfDay(),
                                                    );
                                                    $isFullyPaid = $rental->remaining_payment <= 0;
                                                @endphp

                                                @if ($isTimeToCheckIn)
                                                    <button type="button"
                                                        class="btn btn-sm btn-success d-flex align-items-center gap-1 fw-bold"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#returnModal{{ $rental->id }}">
                                                        <i class="bi bi-arrow-counterclockwise"></i> Return Vehicle
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-sm btn-secondary d-flex align-items-center gap-1"
                                                        disabled
                                                        title="{{ !$isFullyPaid ? 'Pembayaran belum lunas!' : 'Belum memasuki tanggal pengembalian!' }}">
                                                        <i class="bi bi-lock-fill"></i> Lock Return
                                                    </button>
                                                @endif

                                                <form action="{{ route('admin.rentals.cancel', $rental->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan penyewaan ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Batalkan Transaksi">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">No Action</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-secondary small">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i> Tidak ada transaksi yang cocok dengan
                                        filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($recentRentals as $rental)
        @if ($rental->status == 'ongoing')
            <div class="modal fade" id="returnModal{{ $rental->id }}" tabindex="-1"
                aria-labelledby="returnModalLabel{{ $rental->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title" id="returnModalLabel{{ $rental->id }}">
                                Pengembalian Unit: {{ $rental->user->userDetail->full_name ?? 'Penyewa' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.rentals.return', $rental->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body text-start">

                                <div class="mb-3">
                                    <label class="small text-secondary mb-2">TANGGAL KEMBALI AKTUAL</label>
                                    <input type="datetime-local" name="return_date"
                                        class="form-control bg-dark text-white border-secondary"
                                        value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>

                                <div
                                    class="mb-3 p-3 bg-opacity-10 bg-success border border-success border-opacity-25 rounded">
                                    <div class="small fw-bold text-success text-uppercase mb-1">Status Tagihan Utama</div>
                                    <div class="fs-6 fw-bold">LUNAS (Sisa: Rp 0)</div>
                                    <div class="form-text text-secondary small">
                                        Penyewa telah melunasi seluruh biaya sewa awal.
                                    </div>
                                </div>

                                @if (now()->greaterThan(\Carbon\Carbon::parse($rental->return_date_scheduled)))
                                    @php
                                        $scheduledDate = \Carbon\Carbon::parse($rental->return_date_scheduled);
                                        $currentDate = now();
                                        $lateDays = 0;
                                        $estimatedPenalty = 0;
                                        $dailyPrice = $rental->vehicle->daily_rate ?? 0;
                                        $penaltyPerDay = $dailyPrice + $dailyPrice * 0.1;
                                        if ($currentDate->greaterThan($scheduledDate)) {
                                            $lateDays = $currentDate
                                                ->copy()
                                                ->startOfDay()
                                                ->diffInDays($scheduledDate->copy()->startOfDay(), true);
                                            if ($lateDays == 0) {
                                                $lateDays = 1;
                                            }

                                            $estimatedPenalty = $lateDays * $penaltyPerDay;
                                        }
                                    @endphp
                                    <div
                                        class="mb-3 p-3 bg-opacity-10 bg-danger border border-danger border-opacity-25 rounded">
                                        <div class="small fw-bold text-danger text-uppercase mb-1">
                                            Peringatan Keterlambatan
                                        </div>
                                        <div class="small text-white mb-1">
                                            Terlambat: <strong class="text-white">{{ $lateDays }} Hari</strong>
                                        </div>
                                        <div class="small text-white">
                                            Estimasi Tambahan Denda: <strong class="text-white">Rp
                                                {{ number_format($estimatedPenalty, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="form-text text-secondary small mt-1">
                                            *Tarif denda: Rp {{ number_format($penaltyPerDay, 0, ',', '.') }}/hari (Daily
                                            Price + 10%). Otomatis diakumulasikan ke total_price saat konfirmasi.
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="small text-secondary mb-2">KONDISI UNIT (CAR CONDITION)</label>
                                    <select name="car_condition" class="form-select bg-dark text-white border-secondary"
                                        required>
                                        <option value="Good" selected>Good / Normal (Mulus & Aman)</option>
                                        <option value="Minor Damage">Minor Damage (Lecet/Goresan Ringan)</option>
                                        <option value="Major Damage">Major Damage (Rusak Parah/Tabrakan)</option>
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="small text-secondary mb-2">CATATAN AKHIR ADMIN</label>
                                    <textarea name="admin_notes" class="form-control bg-dark text-white border-secondary" rows="2"
                                        placeholder="Contoh: Bensin full kembali, ban aman, STNK ada."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success fw-bold">Konfirmasi Selesai &
                                    Kembalikan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        const carSelect = document.getElementById('car_select');
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');
        const totalPriceInput = document.getElementById('total_price');
        const amountPaidInput = document.getElementById('amount_paid');

        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        if (rentalDateInput) {
            rentalDateInput.min = currentDateTime;
            rentalDateInput.addEventListener('input', function() {
                if (returnDateInput) returnDateInput.min = this.value;
                calculateTotal();
            });
        }

        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = formatRupiah(this.value);
            });
        });

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function unformatRupiah(s) {
            return parseFloat(s.replace(/[^\d]/g, "")) || 0;
        }

        function calculateTotal() {
            if (!carSelect || !rentalDateInput || !returnDateInput || !totalPriceInput) return;

            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const pricePerDay = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;

            const start = new Date(rentalDateInput.value);
            const end = new Date(returnDateInput.value);

            if (!isNaN(start) && !isNaN(end) && end > start && pricePerDay > 0) {
                const diffInMs = end - start;
                const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));
                const total = diffInDays * pricePerDay;

                totalPriceInput.value = formatRupiah(total.toString());
            } else {
                totalPriceInput.value = 0;
            }
        }

        if (carSelect) carSelect.addEventListener('change', calculateTotal);
        if (returnDateInput) returnDateInput.addEventListener('input', calculateTotal);

        const formElement = document.querySelector('form');
        if (formElement) {
            formElement.addEventListener('submit', function(e) {
                const totalPrice = document.getElementById('total_price');
                const amountPaid = document.getElementById('amount_paid');
                if (totalPrice) totalPrice.value = totalPrice.value.replace(/\./g, '');
                if (amountPaid) amountPaid.value = amountPaid.value.replace(/\./g, '');
            });
        }
    </script>
@endpush
