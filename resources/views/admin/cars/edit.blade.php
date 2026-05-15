@extends('layouts.admin')
@section('admin_content')
    <div class="mb-5">
        <a href="{{ route('admin.vehicles') }}" class="text-decoration-none text-white small mb-3 d-inline-block">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
        <h2 class="fw-bold text-white">Edit Detail Kendaraan</h2>
        <p class="text-secondary">Lengkapi detail armada Anda untuk memberikan informasi terbaik kepada penyewa.</p>
    </div>

    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card bg-secondary bg-opacity-10 border-0 shadow-sm" style="border-radius: 24px;">
            <div class="card-body p-5">
                @include('admin.cars._form')

                <div class="d-flex justify-content-between mt-5">
                    <button type="button" id="prevBtn"
                        class="btn btn-outline-light px-4 py-2 rounded-3 d-none">Kembali</button>
                    <button type="button" id="nextBtn"
                        class="btn btn-primary px-5 py-3 rounded-3 ms-auto">Lanjut</button>
                    <button type="submit" id="submitBtn"
                        class="btn btn-warning px-5 py-3 rounded-3 d-none text-dark fw-bold">Update Armada</button>
                </div>
            </div>
        </div>
    </form>
    @include('admin.cars._script')
@endsection
