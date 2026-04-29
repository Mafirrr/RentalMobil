@extends('layouts.app')

@section('title', 'Sewa Mobil Terbaik - InovasiKita')

<style>
    .scroll-container::-webkit-scrollbar {
        display: none;
    }

    .scroll-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow-x: auto;
        white-space: nowrap;
        display: flex;
        gap: 1rem;
        padding-bottom: 10px;
    }

    .filter-btn {
        border-radius: 30px;
        padding: 8px 25px;
        transition: all 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .filter-btn.active {
        background: #0d6efd;
        border-color: #0d6efd;
    }
</style>

@section('content')
    <section class="hero-section position-relative py-5 overflow-hidden" style="min-height: 80vh; background: #121212;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Cari Mobil Terbaik di <span class="text-primary">Kota Anda</span>, Temukan Kenyamanan Berkendara.
                    </h1>
                    <p class="lead text-secondary mb-5">
                        Jelajahi ratusan pilihan mobil dengan fitur pencarian yang canggih, mulai dari harga, tipe mobil,
                        hingga transmisi yang sesuai kebutuhanmu.
                    </p>
                    <div class="d-flex gap-4 mb-5">
                        <div>
                            <h3 class="fw-bold mb-0 text-primary">500+</h3>
                            <small class="text-secondary">Ulasan Positif</small>
                        </div>
                        <div class="vr bg-secondary"></div>
                        <div>
                            <h3 class="fw-bold mb-0 text-primary">1k+</h3>
                            <small class="text-secondary">Mobil Tersewa</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block position-relative">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=800"
                            class="img-fluid rounded-5 shadow-lg position-relative"
                            style="z-index: 2; transform: rotate(-2deg);" alt="Car Image">
                        <div class="position-absolute bg-primary rounded-5"
                            style="top: -20px; right: -20px; width: 100%; height: 100%; opacity: 0.2; z-index: 1;"></div>
                    </div>
                </div>
            </div>

            <div class="row mt-lg-n5">
                <div class="col-12">
                    <div class="card bg-secondary bg-opacity-25 border-0 shadow-lg backdrop-blur"
                        style="backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1) !important;">
                        <div class="card-body p-4">
                            <form action="#" class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-bold">Pilih Tipe Mobil</label>
                                    <select name="category"
                                        class="form-select bg-dark text-white border-secondary border-opacity-50 py-2">
                                        <option value="">Semua Tipe</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-bold">Range Harga</label>
                                    <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2">
                                        <option selected>Pilih Harga</option>
                                        <option>
                                            < Rp 500rb </option>
                                        <option> Rp 500rb - 1jt </option>
                                        <option> > Rp 1jt </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-bold">Transmisi</label>
                                    <select class="form-select bg-dark text-white border-secondary border-opacity-50 py-2">
                                        <option selected>Semua Transmisi</option>
                                        <option>Manual</option>
                                        <option>Otomatis</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                        <i class="bi bi-search me-2"></i> Cari Mobil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Pilihan Mobil Terbaik <span class="text-primary">Untukmu</span></h5>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Semua <i
                            class="bi bi-arrow-right ms-1"></i></a>
                </div>

                <div class="scroll-container mb-4">
                    <a href="{{ route('landing') }}"
                        class="filter-btn {{ !request('category') ? 'active' : '' }} text-decoration-none">Semua</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('landing', ['category' => $category->id]) }}"
                            class="filter-btn {{ request('category') == $category->id ? 'active' : '' }} text-decoration-none">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <div class="scroll-container pb-3 d-flex flex-nowrap"
                    style="overflow-x: auto; gap: 1.5rem; scroll-behavior: smooth;">
                    @forelse ($cars as $car)
                        <div class="card bg-dark border-secondary border-opacity-25 shadow-sm"
                            style="min-width: 320px; border-radius: 24px; transition: transform 0.3s;">
                            <div class="p-3">
                                <div class="position-relative mb-3">
                                    @if ($car->image)
                                        <img src="{{ asset('storage/' . $car->image) }}" class="img-fluid rounded-4 w-100"
                                            style="height: 200px; object-fit: cover;" alt="{{ $car->model }}">
                                    @else
                                        <div class="bg-secondary bg-opacity-10 rounded-4 d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <i class="bi bi-image text-secondary fs-1"></i>
                                        </div>
                                    @endif

                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill shadow">
                                            {{ $car->category->name ?? 'Premium' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="px-2">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="fw-bold text-white mb-0">{{ $car->model }}</h5>
                                        <span
                                            class="badge bg-dark text-secondary border border-secondary border-opacity-25 fw-normal">
                                            {{ $car->transmission }}
                                        </span>
                                    </div>

                                    <div class="d-flex gap-3 mb-4 text-secondary small">
                                        <span><i class="bi bi-people me-1"></i> {{ $car->capacity }} Kursi</span>
                                        <span><i class="bi bi-fuel-pump me-1"></i> {{ $car->fuel_type ?? 'Bensin' }}</span>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-10">
                                        <div>
                                            <span class="text-secondary d-block" style="font-size: 0.75rem;">Mulai
                                                dari</span>
                                            <h4 class="text-primary fw-bold mb-0">Rp
                                                {{ number_format($car->daily_rate, 0, ',', '.') }}<span
                                                    class="text-secondary fs-6 fw-normal">/hari</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-5 text-center w-100">
                            <i class="bi bi-search text-secondary display-1 d-block mb-3"></i>
                            <p class="text-secondary">Maaf, armada dengan kriteria tersebut belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hero-section::before {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(13, 110, 253, 0.15);
            filter: blur(100px);
            top: -100px;
            left: -100px;
            z-index: 1;
        }

        .form-select,
        .form-control {
            color: white !important;
        }

        .form-select option {
            background-color: #212529;
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollPos = sessionStorage.getItem("scrollPosition");
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                sessionStorage.removeItem("scrollPosition");
            }

            const filterLinks = document.querySelectorAll(".filter-btn, .btn-primary");
            filterLinks.forEach(link => {
                link.addEventListener("click", function() {
                    sessionStorage.setItem("scrollPosition", window.scrollY);
                });
            });
        });
    </script>
@endpush
