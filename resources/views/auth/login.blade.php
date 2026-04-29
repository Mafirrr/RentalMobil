@extends('layouts.app')

@section('title', 'Login - Rental Mobil')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-secondary bg-opacity-10 border-0 shadow-lg p-4"
                    style="border: 1px solid rgba(255,255,255,0.1) !important;">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-white">Selamat Datang <span class="text-primary">Kembali</span></h3>
                            <p class="text-secondary small">Masuk untuk mulai mengelola penyewaan Anda.</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                                <input type="email" name="email"
                                    class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                    placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Password</label>
                                <input type="password" name="password"
                                    class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                    placeholder="••••••••" required>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label small text-secondary" for="remember">Ingat Saya</label>
                                </div>
                                <a href="#" class="small text-primary text-decoration-none">Lupa Password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Masuk
                                Sekarang</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-secondary">Belum punya akun? <a href="/register"
                                    class="text-primary text-decoration-none fw-bold">Daftar Gratis</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
