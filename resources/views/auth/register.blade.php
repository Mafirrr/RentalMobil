@extends('layouts.app')

@section('title', 'Daftar Akun - Rental Mobil')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary bg-opacity-10 border-0 shadow-lg p-4"
                    style="border: 1px solid rgba(255,255,255,0.1) !important;">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-white">Buat <span class="text-primary">Akun Baru</span></h3>
                            <p class="text-secondary small">Bergabunglah dengan ribuan pengguna lainnya.</p>
                        </div>

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-secondary">Username</label>
                                    <input type="text" name="username"
                                        class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                        placeholder="username_anda" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-secondary">Email</label>
                                    <input type="email" name="email"
                                        class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                        placeholder="nama@email.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Password</label>
                                    <input type="password" name="password"
                                        class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                        placeholder="••••••••" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                        placeholder="••••••••" required>
                                </div>
                            </div>

                            <input type="hidden" name="role" value="customer">

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Daftar
                                    Akun</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-secondary">Sudah punya akun? <a href="/login"
                                    class="text-primary text-decoration-none fw-bold">Login Disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
