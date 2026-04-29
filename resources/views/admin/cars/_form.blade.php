<div class="form-step" id="step-1">
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Model Mobil</label>
            <input type="text" name="model" value="{{ old('model', $car->model ?? '') }}"
                class="form-control bg-dark border-0 py-3 px-4 text-white rounded-3 shadow-none"
                placeholder="e.g. Toyota Avanza" required>
        </div>
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Tipe Mobil</label>
            <select name="category_id"
                class="form-select bg-dark border-0 py-3 px-4 text-white rounded-3 shadow-none custom-select" required>
                <option value="" selected disabled>Pilih Tipe</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isset($car) && $car->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Nomor Plat</label>
            <input type="text" name="plate_number" value="{{ old('plate_number', $car->plate_number ?? '') }}"
                class="form-control bg-dark border-0 py-3 px-4 text-white rounded-3 shadow-none"
                placeholder="e.g. P 2345 AB" required>
        </div>
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Warna Mobil</label>
            <input type="text" name="color" value="{{ old('color', $car->color ?? '') }}"
                class="form-control bg-dark border-0 py-3 px-4 text-white rounded-3 shadow-none"
                placeholder="e.g. Hitam" required>
        </div>
    </div>
</div>

<div class="form-step d-none" id="step-2">
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Tahun Mobil</label>
            <div class="input-group">
                <input type="number" name="year" value="{{ old('year', $car->year ?? '') }}"
                    class="form-control bg-dark border-0 py-3 px-4 text-white rounded-start-3 shadow-none"
                    placeholder="2024" placeholder="e.g. 2020" required>
                <span class="input-group-text bg-dark border-0 text-secondary rounded-end-3 px-4 small">Tahun</span>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label text-white fw-bold mb-3">Kapasitas Penumpang</label>
            <div class="input-group">
                <input type="number" name="capacity" value="{{ old('capacity', $car->capacity ?? '') }}"
                    class="form-control bg-dark border-0 py-3 px-4 text-white rounded-start-3 shadow-none"
                    placeholder="e.g. 7">
                <span class="input-group-text bg-dark border-0 text-secondary rounded-end-3 px-4 small">Orang</span>
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label text-white fw-bold mb-3">Transmisi</label>
            <div class="d-flex gap-3">
                @php
                    $currentTransmission = old('transmission', $car->transmission ?? 'Manual');
                @endphp
                <div class="flex-fill">
                    <input type="radio" class="btn-check" name="transmission" id="manual" value="Manual"
                        {{ $currentTransmission == 'Manual' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary w-100 py-3 rounded-3 border-opacity-25"
                        for="manual">Manual</label>
                </div>
                <div class="flex-fill">
                    <input type="radio" class="btn-check" name="transmission" id="automatic" value="Automatic"
                        {{ $currentTransmission == 'Automatic' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary w-100 py-3 rounded-3 border-opacity-25"
                        for="automatic">Automatic</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-step d-none" id="step-3">
    <div class="row g-4">
        <div class="col-md-12">
            <label class="form-label text-white fw-bold mb-3">Harga Sewa Per Hari</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-0 text-secondary rounded-start-3 px-4">Rp</span>
                <input type="number" name="daily_rate"
                    value="{{ old('daily_rate', isset($car) ? number_format($car->daily_rate, 0, '', '') : '') }}"
                    class="form-control bg-dark border-0 py-3 px-4 text-white rounded-end-3 shadow-none"
                    placeholder="350000" required>
            </div>
        </div>
    </div>
</div>

<div class="form-step d-none" id="step-4">
    <div class="text-center py-4">
        @if (isset($car) && $car->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $car->image) }}" class="rounded-3" style="width: 150px;">
                <p class="text-secondary small">Foto saat ini</p>
            </div>
        @endif
        <i class="bi bi-cloud-arrow-up display-1 text-primary mb-3"></i>
        <h5 class="text-white">{{ isset($car) ? 'Ganti Foto Mobil' : 'Upload Foto Mobil' }}</h5>
        <input type="file" name="image" class="form-control bg-dark border-0 text-white mt-3 mx-auto shadow-none"
            style="max-width: 350px;">
    </div>
</div>

<div class="form-step d-none" id="step-5">
    <div class="text-center py-4">
        <h4 class="fw-bold text-white">{{ isset($car) ? 'Perbarui Data Armada?' : 'Simpan Armada Baru?' }}</h4>
        <p class="text-secondary">Pastikan semua informasi sudah sesuai sebelum memproses data.</p>
    </div>
</div>
