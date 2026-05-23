@extends('layouts.app')

@section('title', 'Lupa Password — CAPSTONE')

@section('content')
    <div class="container d-flex align-items-center justify-content-center"
        style="min-height: 100vh; padding-top: 100px; padding-bottom: 60px;">
        <div class="row justify-content-center w-100">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg p-3"
                    style="background: var(--bg-surface); border: 1px solid var(--border) !important; border-radius: 4px;">

                    <div class="card-body">
                        <div class="text-center mb-5">
                            <h2 class="font-display text-white mb-2" style="font-size: 2.2rem; letter-spacing: 2px;">
                                RESET <span style="color: var(--accent);">PASSWORD</span>
                            </h2>
                            <p class="font-mono text-white-50"
                                style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; line-height: 1.4;">
                                Tulis alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
                            </p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success font-mono border-0 text-center mb-4"
                                style="font-size: 0.75rem; background-color: rgba(25, 135, 84, 0.2); color: #20c997; border-radius: 2px;">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->has('email'))
                            <div class="alert alert-danger font-mono border-0 text-center mb-4"
                                style="font-size: 0.75rem; background-color: rgba(220, 53, 69, 0.2); color: #ea868f; border-radius: 2px;">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf

                            <div class="mb-5">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">ALAMAT EMAIL TERDAFTAR</label>
                                <input type="email" name="email" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="user@capstone.com" value="{{ old('email') }}" required>
                            </div>

                            <button type="submit" class="btn-nav w-100 py-3 mb-4 text-center d-block border-0"
                                style="background: var(--accent); color: #000; font-weight: 700; cursor: pointer;">
                                KIRIM LINK RESET
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="font-mono text-secondary text-decoration-none small">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Login
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
    </style>
@endsection
