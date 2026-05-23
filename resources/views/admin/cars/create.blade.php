@extends('layouts.admin')
@section('admin_content')
    <div class="mb-5">
        <a href="{{ route('admin.vehicles') }}" class="text-decoration-none text-white small mb-3 d-inline-block">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
        <h2 class="fw-bold text-white">Tambah Armada Mobil Baru</h2>
        <p class="text-secondary">Lengkapi detail unit mobil Anda pada form di bawah ini.</p>
    </div>

    <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card bg-secondary bg-opacity-10 border-0 shadow-sm" style="border-radius: 24px;">
            <div class="card-body p-5">
                @include('admin.cars._form')
            </div>
        </div>
    </form>
@endsection
