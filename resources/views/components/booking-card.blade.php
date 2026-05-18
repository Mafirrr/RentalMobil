@php
    $vehicle = $booking->vehicle;
    $isCar = $vehicle->car ? true : false;
@endphp <div class="col-xl-4 col-lg-6 col-md-6 fade-up" style="transition-delay: 0.1s">
    <div class="car-card {{ !$isCar ? 'motor-card' : '' }} p-0">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between"
            style="background: rgba(255,255,255,0.02)">
            <div> <span class="text-secondary small d-block"> Nota / Kode Sewa </span> <strong
                    style="font-family: monospace; color: var(--text-main);"> #{{ $booking->merchant_ref }} </strong>
            </div>
            @if ($booking->status == 'pending')
                <span class="badge bg-warning text-dark px-2 py-1 small"> <i class="bi bi-clock"></i> Menunggu Bayar
                </span>
            @elseif($booking->status == 'ongoing')
                <span class="badge bg-primary px-2 py-1 small"> <i class="bi bi-arrow-repeat"></i> Sedang Digunakan
                </span>
            @elseif($booking->status == 'completed')
                <span class="badge bg-success px-2 py-1 small"> <i class="bi bi-check2-all"></i> Selesai Sewa </span>
            @else
                <span class="badge bg-secondary px-2 py-1 small"> <i class="bi bi-x-circle"></i> Batal </span>
            @endif
        </div>
        <div class="car-body p-3">
            <div class="car-category"> {{ strtoupper($vehicle->category->name) }} · {{ $vehicle->color }} <span
                    class="float-end text-secondary">
                    @if ($isCar)
                        <i class="bi bi-car-front-fill"></i> Mobil
                    @else
                        <i class="bi bi-bicycle" style="color:#00d4ff"></i> Motor
                    @endif
                </span> </div>
            <div class="car-name mb-3"> {{ $vehicle->model }} </div>
            <div class="p-2 mb-3 rounded"
                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05)">
                <div class="row text-center">
                    <div class="col-5"> <small class="text-secondary d-block" style="font-size: 0.75rem;"> TGL MULAI
                        </small> <span class="small font-weight-bold" style="color: var(--text-main);">
                            {{ date('d M Y', strtotime($booking->rental_date)) }} </span> </div>
                    <div class="col-2 d-flex align-items-center justify-content-center"> <i
                            class="bi bi-arrow-right text-secondary"></i> </div>
                    <div class="col-5"> <small class="text-secondary d-block" style="font-size: 0.75rem;"> TGL SELESAI
                        </small> <span class="small font-weight-bold" style="color: var(--text-main);">
                            {{ date('d M Y', strtotime($booking->return_date_scheduled)) }} </span> </div>
                </div>
            </div>
            <div class="car-specs mb-3">
                @if ($isCar)
                    <div class="spec-item"> <i class="bi bi-people-fill"></i> {{ $vehicle->car->capacity ?? '-' }} Kursi
                    </div>
                    <div class="spec-item"> <i class="bi bi-gear-fill"></i> {{ $vehicle->car->transmission ?? '-' }}
                    </div>
                @else
                    <div class="spec-item"> <i class="bi bi-speedometer2" style="color:#00d4ff"></i>
                        {{ $vehicle->motorcycle->engine_capacity ?? '-' }}cc </div>
                    <div class="spec-item"> <i class="bi bi-gear-fill" style="color:#00d4ff"></i>
                        {{ $vehicle->motorcycle->transmission ?? '-' }} </div>
                @endif
            </div>
            <div class="car-footer pt-2 border-top">
                <div class="car-price"> <span class="price-amount" style="font-size: 1.2rem;"> Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }} </span> <span class="price-label">
                        Total ({{ $booking->duration }} Hari) </span> </div>
            </div> {{-- PAYMENT SUMMARY --}} <x-payment-summary :booking="$booking" />
        </div>
    </div>
</div>
