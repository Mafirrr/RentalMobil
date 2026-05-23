@php
    $total = $booking->total_price ?? 0;
    $remaining = $booking->remaining_amount;
    if ($remaining == 0 && $total > 0) {
        $paid = $total;
    } else {
        $paid = $total - $remaining;
    }
    $percent = $total > 0 ? min(($paid / $total) * 100, 100) : 0;
@endphp

<style>
    .pay-methods {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .pay-method-item {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 16px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.01);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .pay-method-item:hover {
        border-color: rgba(0, 82, 156, 0.3);
        background: rgba(0, 0, 0, 0.03);
    }

    .pay-method-item input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .pay-method-radio {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
        position: relative;
    }

    .pay-method-item input:checked~.pay-method-radio {
        border-color: #00529c;
    }

    .pay-method-item input:checked~.pay-method-radio::after {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #00529c;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .pay-method-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pay-method-info {
        flex: 1;
    }

    .pay-method-name {
        color: #000;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .pay-method-desc {
        color: rgba(0, 0, 0, 0.55);
        font-size: 0.82rem;
        margin-top: 3px;
    }

    .payment-modal-box {
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #dee2e6;
    }

    .payment-modal-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
        color: #495057;
    }

    .payment-modal-row.total {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 1px dashed #dee2e6;
        font-size: 1.05rem;
        font-weight: bold;
        color: #212529;
    }

    .payment-alert {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        padding: 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-payment-submit {
        width: 100%;
        border: none;
        border-radius: 10px;
        padding: 14px 18px;
        background: #00529c;
        color: #fff;
        font-weight: 700;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
    }

    .btn-payment-submit:hover {
        background: #003d75;
        color: #fff;
    }
</style>

<div class="payment-summary mt-3">
    <div class="payment-summary-header">
        <i class="bi bi-wallet2"></i> <span>Informasi Pembayaran</span>
    </div>
    <div class="payment-summary-body">
        <div class="payment-row">
            <span class="payment-label">Total Rental</span>
            <span class="payment-value"> Rp {{ number_format($total, 0, ',', '.') }} </span>
        </div>

        <div class="payment-row">
            <span class="payment-label">DP Dibayar</span>
            <span class="payment-value text-info"> Rp {{ number_format($paid, 0, ',', '.') }} </span>
        </div>

        <div class="payment-row payment-row-highlight">
            <span class="payment-label">Sisa Pembayaran</span>
            @if ($remaining > 0)
                <span class="payment-value text-warning"> Rp {{ number_format($remaining, 0, ',', '.') }} </span>
            @else
                <span class="payment-paid"> <i class="bi bi-check-circle-fill"></i> Lunas </span>
            @endif
        </div>

        <div class="payment-progress-wrap">
            <div class="d-flex justify-content-between mb-1">
                <small class="text-secondary">Progress Pembayaran</small>
                <small class="text-secondary"> {{ number_format($percent, 0) }}% </small>
            </div>
            <div class="payment-progress">
                <div class="payment-progress-bar" style="width: {{ $percent }}%"> </div>
            </div>
        </div>

        @if ($booking->status == 'cancelled')
            <div class="payment-cancel-info mt-3 text-danger">
                <i class="bi bi-patch-check-fill"></i> Pembayaran Telah Dibatalkan
            </div>
        @elseif ($remaining > 0)
            @if ($booking->driver)
                @php
                    $rawPhone = $booking->driver->phone;
                    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                    if (str_starts_with($cleanPhone, '0')) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($booking->driver->name) }},%20saya%20pelanggan%20dari%20pesanan%20%23{{ $booking->id }}."
                    target="_blank"
                    class="btn btn-success w-100 mt-3 py-2 fw-bold d-flex align-items-center justify-content-center">
                    <i class="bi bi-whatsapp me-2"></i> HUBUNGI DRIVER ({{ $booking->driver->name }})
                </a>
            @endif

            <button type="button" class="btn btn-outline-warning w-100 mt-3 py-2 fw-bold" data-bs-toggle="modal"
                data-bs-target="#paymentModal{{ $booking->id }}">
                BAYAR SISA <i class="bi bi-arrow-right"></i>
            </button>
        @else
            <div class="payment-success-info mt-3 text-success mb-2">
                <i class="bi bi-patch-check-fill"></i> Pembayaran Telah Lunas
            </div>
            @if ($booking->status == 'completed')
                @if ($booking->rating)
                    <div class="alert alert-secondary text-center py-2 fw-bold small mt-1 mb-0 border-0 shadow-sm"
                        style="color: #6c757d; background-color: #f8f9fa;">
                        <i class="bi bi-check2-all text-success me-1"></i> Anda Telah Mengulas Transaksi Ini
                    </div>
                @else
                    <button type="button" class="btn btn-warning w-100 py-2 fw-bold text-dark mt-1"
                        data-bs-toggle="modal" data-bs-target="#ratingModal{{ $booking->id }}">
                        <i class="bi bi-star-fill me-1"></i> BERIKAN ULASAN & RATING
                    </button>
                @endif

            @endif
        @endif
    </div>
</div>
