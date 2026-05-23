@extends('layouts.app')

@section('title', 'Ubah Password Baru — CAPSTONE')

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
                                UPDATE <span style="color: var(--accent);">PASSWORD</span>
                            </h2>
                            <p class="font-mono text-white-50"
                                style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">
                                Masukkan password baru Anda
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger font-mono border-0 text-center mb-4"
                                style="font-size: 0.75rem; background-color: rgba(220, 53, 69, 0.2); color: #ea868f; border-radius: 2px;">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="mb-4">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">PASSWORD BARU</label>
                                <input type="password" name="password" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="••••••••" required autofocus>
                            </div>

                            <div class="mb-5">
                                <label class="font-mono text-white small mb-2"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">KONFIRMASI PASSWORD BARU</label>
                                <input type="password" name="password_confirmation" class="form-control font-mono py-2 px-3"
                                    style="background: var(--bg-base); border: 1px solid var(--border); color: var(--text-primary); border-radius: 2px; font-size: 0.85rem;"
                                    placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn-nav w-100 py-3 mb-4 text-center d-block border-0"
                                style="background: var(--accent); color: #000; font-weight: 700; cursor: pointer;">
                                SIMPAN PASSWORD BARU
                            </button>
                        </form>
                    </div>
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
