@extends('layouts.admin')

@section('admin_content')
    <style>
        .custom-pagination .page-link {
            background-color: #212529 !important;
            /* bg-dark */
            color: #f8f9fa !important;
            /* text-light */
            border-color: rgba(108, 117, 125, 0.25) !important;
            /* border-secondary opacity */
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #0d6efd !important;
            /* btn-primary */
            color: #000 !important;
            /* teks hitam untuk kontras */
            border-color: #0d6efd !important;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #1a1d20 !important;
            color: #6c757d !important;
        }
    </style>

    <div class="container-fluid bg-dark text-white min-vh-100 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Manajemen Driver</h2>
                <p class="text-secondary small mb-0">Kelola informasi driver, lisensi berkendara, dan status operasional
                    armada.</p>
            </div>
            <button type="button" class="btn btn-primary text-dark fw-bold d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#addDriverModal">
                <i class="bi bi-person-plus-fill"></i> Tambah Driver
            </button>
        </div>

        {{-- Flash Message Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 text-white border border-success border-opacity-25"
                role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 text-white border border-danger border-opacity-25"
                role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Driver --}}
        <div class="card bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-3">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr class="text-secondary border-bottom border-secondary border-opacity-25"
                            style="font-size: 0.85rem;">
                            <th class="py-3 ps-3">DRIVER</th>
                            <th class="py-3">KONTAK</th>
                            <th class="py-3">LISENSI / SIM</th>
                            <th class="py-3 text-center">STATUS</th>
                            <th class="py-3 text-end pe-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($drivers as $driver)
                            <tr class="border-bottom border-secondary border-opacity-10">
                                <td class="py-3 ps-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="btn p-0 border-0" data-bs-toggle="modal"
                                            data-bs-target="#viewPhotoModal{{ $driver->id }}">
                                            @if ($driver->avatar_path)
                                                <img src="{{ $driver->avatar_path }}" alt="{{ $driver->name }}"
                                                    class="rounded-circle border border-secondary border-opacity-50"
                                                    style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary bg-opacity-20 d-flex align-items-center justify-content-center text-secondary border border-secondary border-opacity-25"
                                                    style="width: 45px; height: 45px; font-weight: bold;">
                                                    {{ strtoupper(substr($driver->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </button>
                                        <div>
                                            <div class="fw-bold text-white">{{ $driver->name }}</div>
                                            <span class="text-secondary small d-block style"
                                                style="font-size: 0.75rem; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $driver->address }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="small text-white">
                                        <i class="bi bi-whatsapp text-success me-1"></i>{{ $driver->phone }}
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="badge bg-info bg-opacity-10 text-white border border-info border-opacity-25 px-2 py-1 fw-bold"
                                            style="font-size: 0.7rem;">
                                            SIM {{ $driver->license_type }}
                                        </span>
                                        <span class="small text-white fw-bold">{{ $driver->license_number }}</span>
                                    </div>
                                    <div class="small mt-1" style="font-size: 0.72rem;">
                                        @if (\Carbon\Carbon::parse($driver->license_expired)->isPast())
                                            <span class="text-danger fw-bold"><i
                                                    class="bi bi-exclamation-triangle-fill"></i> Kadaluwarsa</span>
                                        @else
                                            <span class="text-secondary">Exp:
                                                {{ \Carbon\Carbon::parse($driver->license_expired)->format('d M Y') }}</span>
                                        @endif
                                        ·
                                        <button type="button" class="btn p-0 text-info border-0 bg-transparent custom-link"
                                            style="font-size: 0.72rem;" data-bs-toggle="modal"
                                            data-bs-target="#viewLicenseModal{{ $driver->id }}">
                                            Lihat SIM
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusConfig = match ($driver->status) {
                                            'available' => ['color' => 'success', 'label' => 'Tersedia'],
                                            'assigned' => ['color' => 'primary', 'label' => 'Bertugas'],
                                            'off' => ['color' => 'secondary', 'label' => 'Libur'],
                                            'suspended' => ['color' => 'danger', 'label' => 'Skorsing'],
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $statusConfig['color'] }} bg-opacity-10 text-{{ $statusConfig['color'] }} border border-{{ $statusConfig['color'] }} border-opacity-25 px-3 text-white rounded-pill"
                                        style="font-size: 0.75rem;">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#editDriverModal{{ $driver->id }}" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver {{ $driver->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Hapus Driver">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary small">
                                    <i class="bi bi-people fs-2 d-block mb-2"></i> Belum ada data driver terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 px-2">
        <div class="text-secondary small">
            Menampilkan {{ $drivers->firstItem() ?? 0 }} sampai {{ $drivers->lastItem() ?? 0 }} dari
            {{ $drivers->total() }} driver
        </div>
        <div class="custom-pagination">
            {{ $drivers->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- ========================================== MODAL TAMBAH DRIVER ========================================== --}}
    <div class="modal fade" id="addDriverModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill text-primary me-2"></i>Registrasi
                        Driver Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row g-3 text-start">
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">NAMA LENGKAP</label>
                            <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                                required placeholder="Nama sesuai KTP">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">NOMOR WHATSAPP</label>
                            <input type="text" name="phone" class="form-control bg-dark text-white border-secondary"
                                required placeholder="Contoh: 081234xxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-secondary">ALAMAT TINGGAL</label>
                            <textarea name="address" class="form-control bg-dark text-white border-secondary" rows="2" required
                                placeholder="Alamat domisili sekarang..."></textarea>
                        </div>

                        <hr class="border-secondary opacity-25 my-3">

                        <div class="col-md-4">
                            <label class="form-label small text-secondary">NOMOR SIM</label>
                            <input type="text" name="license_number"
                                class="form-control bg-dark text-white border-secondary" required
                                placeholder="Nomor registrasi SIM">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-secondary">TIPE SIM</label>
                            <select name="license_type" class="form-select bg-dark text-white border-secondary" required>
                                <option value="A">A (Mobil Pribadi)</option>
                                <option value="B1">B1 (Bus/Truk Kecil)</option>
                                <option value="B2">B2 (Alat Berat/Truk Gandeng)</option>
                                <option value="C">C (Sepeda Motor)</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-secondary">MASA BERLAKU SIM</label>
                            <input type="date" name="license_expired"
                                class="form-control bg-dark text-white border-secondary" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-secondary">FOTO PROFIL DRIVER</label>
                            <input type="file" name="avatar_path"
                                class="form-control bg-dark text-white border-secondary" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">FOTO FISIK SIM</label>
                            <input type="file" name="license_image_path"
                                class="form-control bg-dark text-white border-secondary" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-dark fw-bold">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @foreach ($drivers as $driver)
        <div class="modal fade" id="editDriverModal{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-white border-secondary">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-info me-2"></i>Edit Data
                            Driver: {{ $driver->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-body row g-3 text-start">
                            @if ($errors->any())
                                <div class="col-12">
                                    <div class="alert alert-danger bg-danger text-white border-0 small py-2">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <label class="form-label small text-secondary">NAMA LENGKAP</label>
                                <input type="text" name="name"
                                    class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror"
                                    value="{{ old('name', $driver->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-secondary">NOMOR WHATSAPP</label>
                                <input type="text" name="phone"
                                    class="form-control bg-dark text-white border-secondary @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $driver->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label small text-secondary">ALAMAT TINGGAL</label>
                                <textarea name="address"
                                    class="form-control bg-dark text-white border-secondary @error('address') is-invalid @enderror" rows="2"
                                    required>{{ old('address', $driver->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small text-secondary">STATUS OPERASIONAL</label>
                                <select name="status" class="form-select bg-dark text-white border-secondary" required>
                                    <option value="available"
                                        {{ old('status', $driver->status) == 'available' ? 'selected' : '' }}>Tersedia
                                        (Available)
                                    </option>
                                    <option value="assigned"
                                        {{ old('status', $driver->status) == 'assigned' ? 'selected' : '' }}>Bertugas
                                        (Assigned)</option>
                                    <option value="off"
                                        {{ old('status', $driver->status) == 'off' ? 'selected' : '' }}>Libur (Off)
                                    </option>
                                    <option value="suspended"
                                        {{ old('status', $driver->status) == 'suspended' ? 'selected' : '' }}>Skorsing
                                        (Suspended)</option>
                                </select>
                            </div>

                            <hr class="border-secondary opacity-25 my-3">

                            <div class="col-md-4">
                                <label class="form-label small text-secondary">NOMOR SIM</label>
                                <input type="text" name="license_number"
                                    class="form-control bg-dark text-white border-secondary @error('license_number') is-invalid @enderror"
                                    value="{{ old('license_number', $driver->license_number) }}" required>
                                @error('license_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small text-secondary">TIPE SIM</label>
                                <select name="license_type" class="form-select bg-dark text-white border-secondary"
                                    required>
                                    <option value="A"
                                        {{ old('license_type', $driver->license_type) == 'A' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="B1"
                                        {{ old('license_type', $driver->license_type) == 'B1' ? 'selected' : '' }}>B1
                                    </option>
                                    <option value="B2"
                                        {{ old('license_type', $driver->license_type) == 'B2' ? 'selected' : '' }}>B2
                                    </option>
                                    <option value="C"
                                        {{ old('license_type', $driver->license_type) == 'C' ? 'selected' : '' }}>C
                                    </option>
                                    <option value="Internasional"
                                        {{ old('license_type', $driver->license_type) == 'Internasional' ? 'selected' : '' }}>
                                        Internasional</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small text-secondary">MASA BERLAKU SIM</label>
                                <input type="date" name="license_expired"
                                    class="form-control bg-dark text-white border-secondary @error('license_expired') is-invalid @enderror"
                                    value="{{ old('license_expired', $driver->license_expired ? date('Y-m-d', strtotime($driver->license_expired)) : '') }}"
                                    required>
                                @error('license_expired')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-secondary">FOTO PROFIL BARU (KOSONGKAN JIKA TIDAK
                                    DIGANTI)</label>
                                <input type="file" name="avatar_path"
                                    class="form-control bg-dark text-white border-secondary @error('avatar_path') is-invalid @enderror"
                                    accept="image/*">
                                @error('avatar_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($driver->avatar_path)
                                    <div class="form-text text-muted small mt-1"><i class="bi bi-image me-1"></i> Sudah
                                        ada foto profil terunggah.</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-secondary">FOTO SIM BARU (KOSONGKAN JIKA TIDAK
                                    DIGANTI)</label>
                                <input type="file" name="license_image_path"
                                    class="form-control bg-dark text-white border-secondary @error('license_image_path') is-invalid @enderror"
                                    accept="image/*">
                                @error('license_image_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($driver->license_image_path)
                                    <div class="form-text text-muted small mt-1"><i class="bi bi-image me-1"></i> Sudah
                                        ada foto SIM terunggah.</div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info text-dark fw-bold">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewPhotoModal{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark border-secondary text-white">
                    <div class="modal-header border-secondary">
                        <h6 class="modal-title fw-bold">Foto Profil: {{ $driver->name }}</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        @if ($driver->avatar_path)
                            <img src="{{ $driver->avatar_path }}" alt="Foto {{ $driver->name }}"
                                class="img-fluid rounded border border-secondary"
                                style="max-height: 400px; width: auto; object-fit: contain;">
                        @else
                            <div class="py-5 text-secondary">
                                <i class="bi bi-image fs-1 d-block mb-2"></i> Driver tidak memiliki foto profil.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewLicenseModal{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content bg-dark border-secondary text-white">
                    <div class="modal-header border-secondary">
                        <h6 class="modal-title fw-bold">Berkas SIM {{ $driver->license_type }} — {{ $driver->name }}</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-3 bg-black rounded-bottom">
                        @if ($driver->license_image_path)
                            <img src="{{ $driver->license_image_path }}" alt="SIM {{ $driver->name }}"
                                class="img-fluid rounded" style="max-height: 350px; width: auto; object-fit: contain;">
                            <div
                                class="mt-3 text-secondary small text-start p-2 bg-dark rounded border border-secondary border-opacity-25">
                                <strong>Nomor Lisensi:</strong> {{ $driver->license_number }}<br>
                                <strong>Masa Berlaku hingga:</strong>
                                {{ \Carbon\Carbon::parse($driver->license_expired)->format('d F Y') }}
                            </div>
                        @else
                            <div class="py-5 text-secondary">
                                <i class="bi bi-card-image fs-1 d-block mb-2"></i> Berkas fisik gambar SIM belum diunggah.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
