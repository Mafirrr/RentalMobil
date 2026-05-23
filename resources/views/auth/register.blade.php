@extends('layouts.app')

@section('title', 'Register — CAPSTONE')

@section('content')
    <div class="container d-flex align-items-center justify-content-center"
        style="min-height: 100vh; padding-top: 120px; padding-bottom: 60px;">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow-lg p-3"
                    style="background: var(--bg-surface); border: 1px solid var(--border) !important; border-radius: 4px;">

                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="font-display text-white mb-2" style="font-size: 2.3rem; letter-spacing: 2px;">
                                REGISTER <span style="color: var(--accent);">USER</span>
                            </h2>
                            <p class="font-mono text-white"
                                style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">
                                Buat akun untuk mulai menyewa armada premium
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger font-mono p-2 mb-4"
                                style="font-size: 0.75rem; border-radius: 2px; background: rgba(220, 53, 69, 0.1); border-color: rgba(220, 53, 69, 0.2); color: #ea868f;">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-mono text-white small mb-2"
                                        style="font-size: 0.65rem; letter-spacing: 1px;">USERNAME</label>
                                    <input type="text" name="username" class="form-control font-mono py-2 px-3"
                                        style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                        placeholder="johndoe" value="{{ old('username') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-mono text-white small mb-2"
                                        style="font-size: 0.65rem; letter-spacing: 1px;">ALAMAT EMAIL</label>
                                    <input type="email" name="email" class="form-control font-mono py-2 px-3"
                                        style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                        placeholder="user@capstone.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">PASSWORD</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control font-mono py-2 px-3"
                                        style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px 0 0 2px; font-size: 0.85rem;"
                                        placeholder="••••••••" required>
                                    <span class="input-group-text p-0"
                                        style="background: var(--bg-base); border: 1px solid var(--border); border-left: none; border-radius: 0 2px 2px 0;">
                                        <button type="button" id="togglePassword"
                                            class="btn text-secondary h-100 d-flex align-items-center px-3 shadow-none border-0"
                                            style="background: transparent;">
                                            <i class="bi bi-eye" id="eyeIcon" style="font-size: 1.1rem;"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">KONFIRMASI PASSWORD</label>
                                <input type="password" name="password_confirmation" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="••••••••" required>
                            </div>

                            <hr style="border-color: var(--border); margin: 1.5rem 0;">

                            {{-- Section 2: Data Profil Pelanggan (UserDetail) --}}
                            <div class="mb-3">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">NAMA LENGKAP</label>
                                <input type="text" name="fullName" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="John Doe" value="{{ old('fullName') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">NOMOR TELEPON</label>
                                <input type="number" name="phone" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="081234567890" value="{{ old('phone') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">ALAMAT RUMAH</label>
                                <textarea name="address" class="form-control font-mono py-2 px-3" rows="2"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem; resize: none;"
                                    placeholder="Jl. Anggrek No. 12, Jakarta" required>{{ old('address') }}</textarea>
                            </div>

                            <button type="submit" class="btn-nav w-100 py-3 mb-4 text-center d-block border-0"
                                style="background: var(--accent); color: #000; font-weight: 700; cursor: pointer;">
                                DAFTAR AKUN
                            </button>

                            <div class="text-center">
                                <p class="font-mono text-white mb-0" style="font-size: 0.75rem;">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}"
                                        class="text-white text-decoration-none border-bottom border-secondary">Login</a>
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
        .input-group:focus-within .input-group-text {
            border-color: var(--accent) !important;
            box-shadow: 0 0 10px var(--accent-dim) !important;
        }

        .input-group:focus-within input.form-control {
            box-shadow: none !important;
        }

        input.form-control:focus,
        textarea.form-control:focus {
            background: var(--bg-base) !important;
            border-color: var(--accent) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 10px var(--accent-dim) !important;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('passwordInput');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';

                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                if (isPassword) {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                    togglePassword.classList.remove('text-secondary');
                    togglePassword.classList.add(
                        'text-white'); // Beri highlight putih saat password terlihat
                } else {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                    togglePassword.classList.remove('text-white');
                    togglePassword.classList.add('text-secondary');
                }
            });
        });
    </script>
@endsection
