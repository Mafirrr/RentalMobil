@extends('layouts.app')

@section('title', 'Login — CAPSTONE')

@section('content')
    <div class="container d-flex align-items-center justify-content-center"
        style="min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
        <div class="row justify-content-center w-100">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg p-3"
                    style="background: var(--bg-surface); border: 1px solid var(--border) !important; border-radius: 4px;">

                    <div class="card-body">
                        <div class="text-center mb-5">
                            <h2 class="font-display text-white mb-2" style="font-size: 2.5rem; letter-spacing: 2px;">
                                LOGIN <span style="color: var(--accent);">USER</span>
                            </h2>
                            <p class="font-mono text-white"
                                style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">
                                Akses armada premium Anda
                            </p>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">ALAMAT EMAIL</label>
                                <input type="email" name="email" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="user@capstone.com" required>
                            </div>

                            <div class="mb-4">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">PASSWORD</label>
                                <input type="password" name="password" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="••••••••" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input shadow-none" id="remember"
                                        style="background-color: var(--bg-base); border-color: var(--border);">
                                    <label class="form-check-label font-mono text-secondary" for="remember"
                                        style="font-size: 0.7rem;">INGAT SAYA</label>
                                </div>
                                <a href="#" class="font-mono text-decoration-none"
                                    style="color: var(--accent); font-size: 0.7rem;">LUPA PASSWORD?</a>
                            </div>

                            <button type="submit" class="btn-nav w-100 py-3 mb-4 text-center d-block border-0"
                                style="background: var(--accent); color: #000; font-weight: 700; cursor: pointer;">
                                MASUK SEKARANG
                            </button>

                            <div class="text-center">
                                <p class="font-mono text-white mb-0" style="font-size: 0.75rem;">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-white text-decoration-none border-bottom border-secondary">Daftar</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('landing') }}" class="font-mono text-secondary text-decoration-none small">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        input.form-control:focus {
            background: var(--bg-base) !important;
            border-color: var(--accent) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 10px var(--accent-dim) !important;
        }

        .form-check-input:checked {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
        }
    </style>
@endsection
