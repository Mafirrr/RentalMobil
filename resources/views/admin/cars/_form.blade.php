<input type="hidden" name="vehicle_type" value="car">

<div class="mb-5">
    <h4 class="text-white mb-4"><i class="bi bi-info-circle text-primary me-2"></i>Informasi Dasar</h4>
    <div class="mb-3">
        <label class="text-secondary small mb-2">Kategori Mobil</label>
        <select name="category_id" class="form-select bg-dark border-0 text-white p-3 custom-select" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $vehicle->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="text-secondary small mb-2">Model / Nama Mobil</label>
        <input type="text" name="model" class="form-control bg-dark border-0 text-white p-3"
            placeholder="Contoh: Honda Civic" required value="{{ old('model', $vehicle->model ?? '') }}">
    </div>
</div>

<hr class="border-secondary my-4">

<div class="mb-5">
    <h4 class="text-white mb-4"><i class="bi bi-sliders text-primary me-2"></i>Detail Spesifikasi</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Tahun Pembuatan</label>
            <input type="number" name="year" class="form-control bg-dark border-0 text-white p-3"
                value="{{ old('year', $vehicle->year ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Warna</label>
            <input type="text" name="color" class="form-control bg-dark border-0 text-white p-3"
                value="{{ old('color', $vehicle->color ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Kapasitas Penumpang</label>
            <input type="number" name="capacity" class="form-control bg-dark border-0 text-white p-3"
                value="{{ old('capacity', $vehicle->car->capacity ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Bahan Bakar</label>
            <select name="fuel_type" class="form-select bg-dark border-0 text-white p-3 custom-select" required>
                @foreach (['Bensin', 'Diesel', 'Electric', 'Hybrid'] as $fuel)
                    <option value="{{ $fuel }}"
                        {{ old('fuel_type', $vehicle->car->fuel_type ?? '') == $fuel ? 'selected' : '' }}>
                        {{ $fuel }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label class="text-secondary small mb-2">Transmisi</label>
            <select name="transmission" id="transmission_select"
                class="form-select bg-dark border-0 text-white p-3 custom-select" required>
                <option value="Manual"
                    {{ old('transmission', $vehicle->transmission ?? '') == 'Manual' ? 'selected' : '' }}>Manual
                </option>
                <option value="Automatic"
                    {{ old('transmission', $vehicle->transmission ?? '') == 'Automatic' ? 'selected' : '' }}>Automatic
                    (CVT/AT)</option>
            </select>
        </div>
    </div>
</div>

<hr class="border-secondary my-4">

<div class="mb-5">
    <h4 class="text-white mb-4"><i class="bi bi-cash-coin text-primary me-2"></i>Legalitas & Harga</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Nomor Plat (No. Polisi)</label>
            <input type="text" name="plate_number" class="form-control bg-dark border-0 text-white p-3" required
                value="{{ old('plate_number', $vehicle->plate_number ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Harga Sewa / Hari</label>
            <input type="text" id="daily_rate_display" class="form-control bg-dark border-0 text-white p-3"
                placeholder="Contoh: 500.000" required
                value="{{ old('daily_rate', isset($vehicle) ? number_format($vehicle->daily_rate, 0, ',', '.') : '') }}">
            <input type="hidden" name="daily_rate" id="daily_rate_real"
                value="{{ old('daily_rate', $vehicle->daily_rate ?? '') }}">

            <div id="formatted_price_preview" class="text-primary small mt-2 fw-bold"></div>
        </div>
    </div>
</div>

<hr class="border-secondary my-4">

<div class="mb-5">
    <h4 class="text-white mb-4"><i class="bi bi-images text-primary me-2"></i>Foto Kendaraan</h4>
    <div class="row">
        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Depan</label>
            <div class="mb-3">
                <img id="preview-front" src="{{ $images['front'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_front" class="form-control bg-dark border-0 text-white p-2 image-input"
                data-target="preview-front">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Interior</label>
            <div class="mb-3">
                <img id="preview-interior" src="{{ $images['interior'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_interior"
                class="form-control bg-dark border-0 text-white p-2 image-input" data-target="preview-interior">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Samping</label>
            <div class="mb-3">
                <img id="preview-side" src="{{ $images['side'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_side" class="form-control bg-dark border-0 text-white p-2 image-input"
                data-target="preview-side">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Mesin</label>
            <div class="mb-3">
                <img id="preview-engine" src="{{ $images['engine'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_engine"
                class="form-control bg-dark border-0 text-white p-2 image-input" data-target="preview-engine">
        </div>
    </div>
</div>

<div class="mt-4 text-end">
    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3">
        <i class="bi bi-check-circle me-2"></i> {{ isset($vehicle) ? 'Simpan Perubahan' : 'Tambah Kendaraan' }}
    </button>
</div>

<script>
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', function() {
            const targetId = this.getAttribute('data-target');
            const previewImg = document.getElementById(targetId);
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- 1. FORMAT UTANG/RUPIAH SAAT HALAMAN DI-LOAD (UNTUK EDIT FORM) ---
        const displayInput = document.getElementById('daily_rate_display');
        const realInput = document.getElementById('daily_rate_real');
        const preview = document.getElementById('formatted_price_preview');

        if (displayInput && displayInput.value) {
            // Bersihkan format titik bawaan untuk memicu trigger input ulang secara rapi
            let rawValue = displayInput.value.replace(/[^0-9]/g, '');
            realInput.value = rawValue;
            displayInput.value = formatRupiah(rawValue);

            if (rawValue) {
                preview.innerText = "Terbaca: Rp " + new Intl.NumberFormat('id-ID').format(rawValue);
            }
        }

        // --- 2. LISTENER INPUT FORMAT RUPIAH OTOMATIS ---
        if (displayInput) {
            displayInput.addEventListener('input', function() {
                let rawValue = this.value.replace(/[^0-9]/g, '');
                realInput.value = rawValue; // Nilai murni angka tanpa titik untuk masuk database
                this.value = formatRupiah(rawValue); // Nilai berformat titik untuk kenyamanan pengguna

                if (rawValue) {
                    preview.innerText = "Terbaca: Rp " + new Intl.NumberFormat('id-ID').format(
                    rawValue);
                } else {
                    preview.innerText = "";
                }
            });
        }
    });

    // --- 3. FUNGSI UTANG UNTUK MEMBENTUK FORMAT TITIK RIBUAN ---
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
</script>

<style>
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.2);
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #1a1b1e !important;
        border: 1px solid #0d6efd !important;
    }

    .custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }

    .border-dashed {
        border-style: dashed !important;
    }
</style>
