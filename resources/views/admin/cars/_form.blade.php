<div id="step-1" class="setup-step">
    <h4 class="text-white mb-4">Pilih Tipe Kendaraan</h4>
    <div class="row g-3">
        <div class="col-md-6">
            <input type="radio" class="btn-check" name="vehicle_type" id="type_car" value="car"
                {{ old('vehicle_type', $vehicle->vehicle_type ?? 'car') == 'car' ? 'checked' : '' }}
                {{ isset($vehicle) ? 'disabled' : '' }}>
            <label class="btn btn-outline-primary w-100 p-4 rounded-4" for="type_car">
                <i class="bi bi-car-front display-4 d-block mb-2"></i> Mobil
            </label>
        </div>
        <div class="col-md-6">
            <input type="radio" class="btn-check" name="vehicle_type" id="type_motor" value="motorcycle"
                {{ old('vehicle_type', $vehicle->vehicle_type ?? '') == 'motorcycle' ? 'checked' : '' }}
                {{ isset($vehicle) ? 'disabled' : '' }}>
            <label class="btn btn-outline-primary w-100 p-4 rounded-4" for="type_motor">
                <i class="bi bi-bicycle display-4 d-block mb-2"></i> Sepeda Motor
            </label>
        </div>
    </div>
    @if (isset($vehicle))
        <input type="hidden" name="vehicle_type" value="{{ $vehicle->vehicle_type }}">
        <p class="text-warning small mt-2">* Tipe kendaraan tidak dapat diubah.</p>
    @endif
</div>

<div id="step-2" class="setup-step d-none">
    <h4 class="text-white mb-4">Informasi Dasar</h4>
    <div class="mb-3">
        <label class="text-secondary small mb-2">Kategori</label>
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
        <label class="text-secondary small mb-2">Model / Nama Kendaraan</label>
        <input type="text" name="model" class="form-control bg-dark border-0 text-white p-3"
            placeholder="Contoh: Honda Civic" required value="{{ old('model', $vehicle->model ?? '') }}">
    </div>
</div>

<div id="step-3" class="setup-step d-none">
    <h4 class="text-white mb-4">Detail Spesifikasi</h4>

    <div id="spec_car">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Tahun</label>
                <input type="number" name="year" class="form-control bg-dark border-0 text-white p-3 vehicle-input"
                    value="{{ old('year', $vehicle->year ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Warna</label>
                <input type="text" name="color" class="form-control bg-dark border-0 text-white p-3 vehicle-input"
                    value="{{ old('color', $vehicle->color ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Kapasitas Penumpang</label>
                <input type="number" name="capacity" class="form-control bg-dark border-0 text-white p-3 vehicle-input"
                    value="{{ old('capacity', $vehicle->car->capacity ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Bahan Bakar</label>
                <select name="fuel_type"
                    class="form-select bg-dark border-0 text-white p-3 custom-select vehicle-input">
                    @foreach (['Bensin', 'Diesel', 'Electric'] as $fuel)
                        <option value="{{ $fuel }}"
                            {{ old('fuel_type', $vehicle->car->fuel_type ?? '') == $fuel ? 'selected' : '' }}>
                            {{ $fuel }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div id="spec_motor" class="d-none">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Tahun</label>
                <input type="number" name="year_motor"
                    class="form-control bg-dark border-0 text-white p-3 motorcycle-input"
                    value="{{ old('year_motor', $vehicle->year ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Warna</label>
                <input type="text" name="color_motor"
                    class="form-control bg-dark border-0 text-white p-3 motorcycle-input"
                    value="{{ old('color_motor', $vehicle->color ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Kapasitas Mesin (CC)</label>
                <input type="number" name="engine_capacity"
                    class="form-control bg-dark border-0 text-white p-3 motorcycle-input" placeholder="120"
                    value="{{ old('engine_capacity', $vehicle->motorcycle->engine_capacity ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-secondary small mb-2">Termasuk Helm?</label>
                <select name="includes_helmet"
                    class="form-select bg-dark border-0 text-white p-3 custom-select motorcycle-input">
                    <option value="1"
                        {{ old('includes_helmet', $vehicle->motorcycle->includes_helmet ?? '') == '1' ? 'selected' : '' }}>
                        Ya (2 Helm)</option>
                    <option value="0"
                        {{ old('includes_helmet', $vehicle->motorcycle->includes_helmet ?? '') == '0' ? 'selected' : '' }}>
                        Tidak</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="text-secondary small mb-2">Transmisi</label>
        <select name="transmission" id="transmission_select"
            class="form-select bg-dark border-0 text-white p-3 custom-select" required>
        </select>
    </div>
</div>

<div id="step-4" class="setup-step d-none">
    <h4 class="text-white mb-4">Legalitas & Harga</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Nomor Plat</label>
            <input type="text" name="plate_number" class="form-control bg-dark border-0 text-white p-3" required
                value="{{ old('plate_number', $vehicle->plate_number ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="text-secondary small mb-2">Harga Sewa / Hari</label>
            <input type="text" id="daily_rate_display" class="form-control bg-dark border-0 text-white p-3"
                placeholder="Contoh: 500.000"
                value="{{ old('daily_rate', isset($vehicle) ? number_format($vehicle->daily_rate, 0, ',', '.') : '') }}">
            <input type="hidden" name="daily_rate" id="daily_rate_real"
                value="{{ old('daily_rate', $vehicle->daily_rate ?? '') }}">

            <div id="formatted_price_preview" class="text-primary small mt-2 fw-bold"></div>
        </div>
    </div>
</div>

<div id="step-5" class="setup-step d-none">
    <h4 class="text-white mb-4">Foto Kendaraan</h4>

    <div class="row">
        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Depan</label>
            <div class="mb-3">
                <img id="preview-front" src="{{ $images['front'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary style-preview"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_front" class="form-control bg-dark border-0 text-white p-2 image-input"
                data-target="preview-front">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Interior</label>
            <div class="mb-3">
                <img id="preview-right" src="{{ $images['interior'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary style-preview"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_interior"
                class="form-control bg-dark border-0 text-white p-2 image-input" data-target="preview-right">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Samping</label>
            <div class="mb-3">
                <img id="preview-left" src="{{ $images['side'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary style-preview"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_side" class="form-control bg-dark border-0 text-white p-2 image-input"
                data-target="preview-left">
        </div>

        <div class="col-md-6 mb-4">
            <label class="text-white-50 mb-2">Foto Mesin</label>
            <div class="mb-3">
                <img id="preview-back" src="{{ $images['engine'] ?? asset('images/placeholder.jpg') }}"
                    class="img-fluid rounded border border-secondary style-preview"
                    style="max-height: 200px; width: 100%; object-fit: cover;">
            </div>
            <input type="file" name="image_engine"
                class="form-control bg-dark border-0 text-white p-2 image-input" data-target="preview-back">
        </div>
    </div>
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
