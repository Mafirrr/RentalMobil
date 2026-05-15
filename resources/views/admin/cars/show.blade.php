<div class="card bg-secondary bg-opacity-10 border-0 shadow-lg" style="overflow: hidden; border-radius: 24px;">
    <div class="row g-0">
        <div class="col-lg-7 position-relative" style="min-height: 450px;">
            @if ($vehicle->image)
                <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid w-100 h-100"
                    style="object-fit: cover;" alt="{{ $vehicle->model }}">
            @else
                <div class="w-100 h-100 bg-black d-flex align-items-center justify-content-center text-secondary">
                    <i class="bi bi-image display-1"></i>
                </div>
            @endif
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4"
                data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="col-lg-5 p-5 d-flex flex-column">
            <div class="mb-4">
                <span class="badge bg-primary mb-2">{{ $vehicle->category->name ?? 'Armada' }}</span>
                <h2 class="fw-bold text-white mb-1">{{ $vehicle->model }}</h2>
                <p class="text-secondary small"><i class="bi bi-hash me-1"></i>{{ $vehicle->plate_number }}</p>
            </div>

            <div class="row g-3 mb-4">
                {{-- INFO KHUSUS MOBIL --}}
                @if ($vehicle->vehicle_type == 'car')
                    <div class="col-6">
                        <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                            <i class="bi bi-people text-primary fs-4"></i>
                            <span class="text-secondary small d-block">Kapasitas</span>
                            <strong class="text-white">{{ $vehicle->car->capacity ?? '-' }} Kursi</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                            <i class="bi bi-gear text-primary fs-4"></i>
                            <span class="text-secondary small d-block">Transmisi</span>
                            <strong class="text-white">{{ $vehicle->car->transmission ?? '-' }}</strong>
                        </div>
                    </div>
                    {{-- INFO KHUSUS MOTOR --}}
                @else
                    <div class="col-6">
                        <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                            <i class="bi bi-speedometer2 text-primary fs-4"></i>
                            <span class="text-secondary small d-block">Mesin</span>
                            <strong class="text-white">{{ $vehicle->motorcycle->engine_capacity ?? '-' }} cc</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                            <i class="bi bi-shield-check text-primary fs-4"></i>
                            <span class="text-secondary small d-block">Helm</span>
                            <strong
                                class="text-white">{{ $vehicle->motorcycle->includes_helmet ?? false ? 'Tersedia' : 'Tidak' }}</strong>
                        </div>
                    </div>
                @endif

                {{-- INFO UMUM (Sama untuk keduanya) --}}
                <div class="col-6">
                    <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                        <i class="bi bi-calendar3 text-primary fs-4"></i>
                        <span class="text-secondary small d-block">Tahun</span>
                        <strong class="text-white">{{ $vehicle->year }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-dark rounded-4 text-center border border-secondary border-opacity-10">
                        <i class="bi bi-palette text-primary fs-4"></i>
                        <span class="text-secondary small d-block">Warna</span>
                        <strong class="text-white">{{ $vehicle->color ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-4 border-top border-secondary border-opacity-10">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <span class="text-secondary small d-block mb-1">Harga Sewa</span>
                        <h3 class="text-white fw-bold mb-0">
                            Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}
                            <span class="text-secondary fs-6 fw-normal">/hari</span>
                        </h3>
                    </div>
                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                        class="btn btn-primary btn-sm rounded-3 px-2">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
