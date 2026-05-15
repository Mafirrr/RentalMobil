@extends('layouts.admin')

@section('admin_content')
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="stat-card h-100">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="bi bi-whatsapp text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-white">Record Rental Manual</h5>
                </div>

                <form action="{{ route('admin.rentals.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label class="form-label small text-secondary">NAMA PENYEWA</label>
                            <input type="text" name="customer_name"
                                class="form-control bg-dark text-white border-secondary py-2"
                                placeholder="Input nama dari WA" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small text-secondary">NO. WHATSAPP</label>
                            <input type="text" name="customer_phone"
                                class="form-control bg-dark text-white border-secondary py-2" placeholder="08xxx" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">ALAMAT DOMISILI</label>
                        <textarea name="customer_address" class="form-control bg-dark text-white border-secondary" rows="2"
                            placeholder="Alamat lengkap penyewa"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">PILIH ARMADA</label>
                            <select name="car_id" id="car_select" class="form-select bg-dark text-white border-secondary"
                                required>
                                <option selected disabled>Pilih Mobil</option>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}" data-price="{{ $car->daily_rate }}">
                                        {{ $car->model }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">TOTAL HARGA (RP)</label>
                            <input type="text" name="total_price" id="total_price"
                                class="form-control bg-dark text-white border-secondary currency-input"
                                placeholder="700.000" readonly required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">JADWAL SEWA</label>
                            <input type="datetime-local" name="rental_date" id="rental_date"
                                class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">DP / JUMLAH BAYAR (RP)</label>
                            <input type="text" name="amount_paid"
                                class="form-control bg-dark text-white border-secondary currency-input"
                                placeholder="Masukkan nominal DP">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label small text-secondary">ESTIMASI KEMBALI</label>
                            <input type="datetime-local" name="return_date_scheduled" id="return_date"
                                class="form-control bg-dark text-white border-secondary" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-secondary">CATATAN ADMIN</label>
                        <textarea name="admin_notes" class="form-control bg-dark text-white border-secondary" rows="2"
                            placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="bi bi-save me-2"></i>Simpan Record Transaksi
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="stat-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-white">Record Transaksi Terbaru</h5>
                    <div class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3">
                        Status Default: Ongoing
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-secondary small text-secondary py-3">PENYEWA</th>
                                <th class="border-secondary small text-secondary py-3">ARMADA</th>
                                <th class="border-secondary small text-secondary py-3 text-center">BAYAR / TOTAL</th>
                                <th class="border-secondary small text-secondary py-3 text-end">STATUS</th>
                                <th class="border-secondary small text-secondary py-3 text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentRentals as $rental)
                                <tr class="align-middle">
                                    <td class="py-3">
                                        <div class="fw-bold text-white">{{ $rental->customer_name }}</div>
                                        <div class="small text-secondary">{{ $rental->customer_phone }}</div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-white">{{ $rental->car->model }}</div>
                                        <div class="small text-secondary">{{ $rental->car->plate_number }}</div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="small text-success fw-bold">Rp {{ number_format($rental->amount_paid) }}
                                        </div>
                                        <div class="small text-secondary" style="font-size: 0.75rem;">Total: Rp
                                            {{ number_format($rental->total_price) }}</div>
                                    </td>
                                    <td class="text-end py-3">
                                        <span
                                            class="badge rounded-pill
                                                bg-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }} bg-opacity-10 text-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }}
                                                border border-{{ $rental->status == 'completed' ? 'success' : ($rental->status == 'cancelled' ? 'danger' : 'primary') }} border-opacity-25 px-3">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#returnModal{{ $rental->id }}"
                                                {{ $rental->status != 'ongoing' ? 'disabled' : '' }}>
                                                <i class="bi bi-check-circle"></i>
                                            </button>

                                            @if ($rental->status == 'ongoing')
                                                <form action="{{ route('admin.rentals.cancel', $rental->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan penyewaan ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="returnModal{{ $rental->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content bg-dark text-white border-secondary">
                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title">Pengembalian: {{ $rental->customer_name }}</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.rentals.return', $rental->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="small text-secondary mb-2">TANGGAL KEMBALI
                                                            AKTUAL</label>
                                                        <input type="datetime-local" name="return_date_actual"
                                                            class="form-control bg-dark text-white border-secondary"
                                                            value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="small text-secondary mb-2">PELUNASAN / TOTAL DIBAYAR
                                                            (RP)
                                                        </label>
                                                        <input type="number" name="amount_paid" id="amount_paid"
                                                            class="form-control bg-dark text-white border-secondary"
                                                            value="{{ $rental->total_price }}"
                                                            placeholder="Total: Rp {{ number_format($rental->total_price) }}">
                                                        <div class="form-text text-info small">Total harga awal: Rp
                                                            {{ number_format($rental->total_price) }}</div>
                                                    </div>

                                                    <div class="mb-0">
                                                        <label class="small text-secondary mb-2">KONDISI UNIT / CATATAN
                                                            AKHIR</label>
                                                        <textarea name="admin_notes" class="form-control bg-dark text-white border-secondary" rows="2"
                                                            placeholder="Contoh: Bensin full, body lecet dikit bagian depan."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success fw-bold">Konfirmasi
                                                        Selesai</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
            rentalDateInput.min = currentDateTime;

            rentalDateInput.addEventListener('input', function() {
                returnDateInput.min = this.value;
                calculateTotal();
            });

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

            carSelect.addEventListener('change', calculateTotal);
            returnDateInput.addEventListener('input', calculateTotal);

            document.querySelector('form').addEventListener('submit', function(e) {
                const totalPrice = document.getElementById('total_price');
                const amountPaid = document.getElementById('amount_paid');
                totalPrice.value = totalPrice.value.replace(/\./g, '');
                amountPaid.value = amountPaid.value.replace(/\./g, '');
            });
        </script>
    @endpush
@endsection
