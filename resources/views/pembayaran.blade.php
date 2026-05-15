<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — CAPSTONE Car Rental</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #0a0a0c;
            --bg-surface: #111115;
            --bg-card: #16161c;
            --bg-card-hover: #1c1c24;
            --accent: #c8ff00;
            --accent-dim: rgba(200,255,0,0.10);
            --accent-glow: rgba(200,255,0,0.30);
            --text-primary: #f0f0f0;
            --text-secondary: #8a8a9a;
            --text-muted: #55556a;
            --border: rgba(255,255,255,0.07);
            --border-accent: rgba(200,255,0,0.28);
            --success: #00c850;
            --success-dim: rgba(0,200,80,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 2px; }

        /* ── NAVBAR ── */
        .navbar-capstone {
            position: fixed; top: 0; width: 100%; z-index: 1000; padding: 20px 0;
            background: rgba(10,10,12,0.95); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .nav-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--text-primary) !important; letter-spacing: 0.1em; text-decoration: none; }
        .nav-brand span { color: var(--accent); }

        /* Stepper progress */
        .checkout-progress {
            padding: 100px 0 0;
            background: var(--bg-base);
        }
        .step-bar {
            display: flex; align-items: center; justify-content: center;
            gap: 0; padding: 28px 0;
        }
        .step-item {
            display: flex; flex-direction: column; align-items: center; gap: 6px;
            position: relative; z-index: 1;
        }
        .step-circle {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Space Mono', monospace; font-size: 0.72rem; font-weight: 700;
            border: 2px solid var(--border); background: var(--bg-card); color: var(--text-muted);
            transition: all 0.3s;
        }
        .step-item.done .step-circle { background: var(--accent); border-color: var(--accent); color: #000; }
        .step-item.active .step-circle { border-color: var(--accent); color: var(--accent); background: var(--accent-dim); box-shadow: 0 0 20px rgba(200,255,0,0.25); }
        .step-label { font-family: 'Space Mono', monospace; font-size: 0.6rem; letter-spacing: 0.1em; color: var(--text-muted); text-transform: uppercase; white-space: nowrap; }
        .step-item.active .step-label { color: var(--accent); }
        .step-item.done .step-label { color: var(--text-secondary); }
        .step-connector { width: 80px; height: 2px; background: var(--border); margin: 0 8px; margin-bottom: 22px; position: relative; overflow: hidden; }
        .step-connector.done::after { content: ''; position: absolute; inset: 0; background: var(--accent); }
        @media (max-width: 576px) { .step-connector { width: 40px; } .step-label { display: none; } }

        /* ── MAIN LAYOUT ── */
        .checkout-body { padding: 40px 0 80px; background: var(--bg-base); }

        /* ── FORM SECTION ── */
        .form-section {
            background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px;
            padding: 32px; margin-bottom: 20px;
        }
        .form-section-head {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 26px; padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }
        .form-section-num {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--accent-dim); border: 1px solid var(--border-accent);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Space Mono', monospace; font-size: 0.72rem; color: var(--accent);
            font-weight: 700; flex-shrink: 0;
        }
        .form-section-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.25rem; letter-spacing: 0.08em; color: var(--text-primary); }
        .form-section-subtitle { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }

        /* ── FORM CONTROLS ── */
        .form-label-cap {
            font-family: 'Space Mono', monospace; font-size: 0.65rem; letter-spacing: 0.1em;
            color: var(--text-muted); text-transform: uppercase; margin-bottom: 7px; display: block;
        }
        .form-label-cap span { color: #ff6060; }
        .form-control-cap {
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            background: var(--bg-surface); border: 1px solid var(--border);
            border-radius: 3px; color: var(--text-primary); padding: 12px 16px;
            width: 100%; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control-cap:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(200,255,0,0.08); background: var(--bg-surface); }
        .form-control-cap::placeholder { color: var(--text-muted); }
        select.form-control-cap option { background: #1a1a22; }
        .input-group-cap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem; pointer-events: none; }
        .input-icon ~ .form-control-cap { padding-left: 40px; }
        .form-hint { font-size: 0.72rem; color: var(--text-muted); margin-top: 5px; }
        .form-hint i { color: var(--accent); }

        /* ── DATE PICKER RANGE ── */
        .date-range-wrap {
            display: grid; grid-template-columns: 1fr auto 1fr; gap: 10px; align-items: center;
        }
        .date-sep {
            font-family: 'Space Mono', monospace; font-size: 0.65rem; letter-spacing: 0.1em;
            color: var(--text-muted); text-align: center; padding-top: 24px;
        }

        /* ── PAYMENT METHOD ── */
        .pay-methods { display: flex; flex-direction: column; gap: 10px; }
        .pay-method-item {
            display: flex; align-items: center; gap: 16px;
            padding: 16px 18px; background: var(--bg-surface);
            border: 1.5px solid var(--border); border-radius: 4px;
            cursor: pointer; transition: all 0.2s; position: relative;
        }
        .pay-method-item:hover { border-color: rgba(200,255,0,0.2); }
        .pay-method-item.selected { border-color: var(--accent); background: var(--accent-dim); }
        .pay-method-item input[type="radio"] { display: none; }
        .pay-method-radio {
            width: 18px; height: 18px; border-radius: 50%;
            border: 2px solid var(--border); background: var(--bg-card);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.2s;
        }
        .pay-method-item.selected .pay-method-radio { border-color: var(--accent); background: var(--accent); }
        .pay-method-item.selected .pay-method-radio::after { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #000; }
        .pay-method-icon {
            width: 44px; height: 30px; border-radius: 3px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; background: var(--bg-card); border: 1px solid var(--border);
            flex-shrink: 0;
        }
        .pay-method-info { flex: 1; }
        .pay-method-name { font-weight: 600; font-size: 0.9rem; color: var(--text-primary); }
        .pay-method-desc { font-size: 0.75rem; color: var(--text-muted); margin-top: 1px; }
        .pay-method-badge {
            font-family: 'Space Mono', monospace; font-size: 0.55rem; letter-spacing: 0.1em;
            padding: 3px 7px; border-radius: 1px; font-weight: 700;
        }
        .pay-method-badge.free { background: rgba(0,200,80,0.15); border: 1px solid rgba(0,200,80,0.3); color: var(--success); }
        .pay-method-badge.fee { background: rgba(255,180,0,0.1); border: 1px solid rgba(255,180,0,0.25); color: #ffb400; }

        /* Bank detail panel */
        .bank-detail-panel {
            display: none; margin-top: 12px;
            padding: 18px; background: var(--bg-base); border: 1px solid var(--border-accent);
            border-radius: 3px;
        }
        .bank-detail-panel.show { display: block; }
        .bank-account-num {
            font-family: 'Space Mono', monospace; font-size: 1.3rem; letter-spacing: 0.1em;
            color: var(--accent); margin: 8px 0 4px;
        }
        .bank-account-name { font-size: 0.8rem; color: var(--text-secondary); }
        .btn-copy {
            font-family: 'Space Mono', monospace; font-size: 0.65rem; letter-spacing: 0.08em;
            padding: 7px 14px; background: var(--accent-dim); border: 1px solid var(--border-accent);
            border-radius: 2px; color: var(--accent); cursor: pointer; transition: all 0.2s;
        }
        .btn-copy:hover { background: var(--accent); color: #000; }

        /* ── ORDER SUMMARY ── */
        .order-summary {
            position: sticky; top: 90px;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 6px; overflow: hidden;
        }
        .os-header {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-surface);
        }
        .os-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 0.08em; color: var(--text-primary); }
        .os-vehicle-card { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; gap: 14px; align-items: center; }
        .os-vehicle-img { width: 80px; height: 54px; background: var(--bg-surface); border-radius: 3px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; padding: 6px; }
        .os-vehicle-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; letter-spacing: 0.04em; color: var(--text-primary); }
        .os-vehicle-cat { font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; }
        .os-vehicle-badge { font-family: 'Space Mono', monospace; font-size: 0.55rem; letter-spacing: 0.1em; padding: 3px 7px; background: var(--accent); color: #000; border-radius: 1px; font-weight: 700; }

        /* Rental duration picker */
        .duration-picker { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .duration-label { font-family: 'Space Mono', monospace; font-size: 0.62rem; letter-spacing: 0.12em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px; }
        .duration-dates { display: flex; gap: 10px; align-items: center; }
        .dur-date-box { flex: 1; background: var(--bg-surface); border: 1px solid var(--border); border-radius: 3px; padding: 10px 12px; }
        .dur-date-lbl { font-family: 'Space Mono', monospace; font-size: 0.55rem; letter-spacing: 0.1em; color: var(--accent); text-transform: uppercase; }
        .dur-date-val { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); margin-top: 2px; }
        .dur-arrow { color: var(--text-muted); font-size: 0.8rem; }
        .dur-nights {
            margin-top: 10px; display: flex; align-items: center; justify-content: space-between;
            font-family: 'Space Mono', monospace; font-size: 0.65rem; color: var(--text-muted);
        }
        .dur-nights span { color: var(--accent); font-size: 0.9rem; font-weight: 700; }

        /* Price breakdown */
        .price-breakdown { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .pb-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .pb-label { font-size: 0.84rem; color: var(--text-secondary); }
        .pb-value { font-family: 'Space Mono', monospace; font-size: 0.8rem; color: var(--text-primary); }
        .pb-divider { height: 1px; background: var(--border); margin: 14px 0; }
        .pb-total-label { font-family: 'Space Mono', monospace; font-size: 0.7rem; letter-spacing: 0.1em; color: var(--text-muted); text-transform: uppercase; }
        .pb-total-val { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--accent); letter-spacing: 0.02em; }
        .pb-discount { color: var(--success) !important; }
        .pb-badge { font-family: 'Space Mono', monospace; font-size: 0.55rem; padding: 2px 6px; background: var(--success-dim); border: 1px solid rgba(0,200,80,0.3); color: var(--success); border-radius: 1px; margin-left: 6px; }

        /* Promo input */
        .promo-wrap { padding: 16px 24px; border-bottom: 1px solid var(--border); }
        .promo-row { display: flex; gap: 8px; }
        .promo-input { flex: 1; font-family: 'Space Mono', monospace; font-size: 0.72rem; letter-spacing: 0.08em; padding: 10px 14px; background: var(--bg-surface); border: 1px solid var(--border); border-radius: 2px; color: var(--text-primary); text-transform: uppercase; transition: border-color 0.2s; }
        .promo-input:focus { outline: none; border-color: var(--accent); }
        .promo-input::placeholder { color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; }
        .btn-promo { font-family: 'Space Mono', monospace; font-size: 0.7rem; letter-spacing: 0.08em; padding: 10px 16px; background: transparent; border: 1px solid var(--border); color: var(--text-secondary); border-radius: 2px; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
        .btn-promo:hover { border-color: var(--accent); color: var(--accent); }

        .os-footer { padding: 20px 24px; }
        .btn-bayar {
            width: 100%; padding: 16px; background: var(--accent); color: #000;
            font-family: 'Space Mono', monospace; font-size: 0.82rem; letter-spacing: 0.1em;
            font-weight: 700; border: none; border-radius: 3px; cursor: pointer;
            transition: all 0.25s; display: flex; align-items: center; justify-content: center; gap: 10px;
            text-transform: uppercase;
        }
        .btn-bayar:hover { background: #d8ff20; transform: translateY(-1px); box-shadow: 0 8px 28px rgba(200,255,0,0.3); }
        .btn-bayar:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }
        .secure-badges {
            display: flex; align-items: center; justify-content: center; gap: 12px;
            margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);
        }
        .sec-badge { font-family: 'Space Mono', monospace; font-size: 0.58rem; letter-spacing: 0.08em; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }
        .sec-badge i { color: var(--success); font-size: 0.7rem; }

        /* ── SUCCESS MODAL ── */
        .success-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 9999;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }
        .success-overlay.show { display: flex; }
        .success-box {
            background: var(--bg-card); border: 1px solid var(--border); border-radius: 8px;
            padding: 48px 44px; max-width: 480px; width: 90%; text-align: center;
            animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes popIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
        .success-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: var(--success-dim); border: 2px solid rgba(0,200,80,0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; color: var(--success); margin: 0 auto 24px;
            animation: pulse 1.5s ease infinite;
        }
        @keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(0,200,80,0.3); } 50% { box-shadow: 0 0 0 12px rgba(0,200,80,0); } }
        .success-title { font-family: 'Bebas Neue', sans-serif; font-size: 2.4rem; letter-spacing: 0.05em; color: var(--text-primary); margin-bottom: 8px; }
        .success-sub { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.7; margin-bottom: 28px; }
        .order-id-box {
            background: var(--bg-surface); border: 1px solid var(--border-accent); border-radius: 3px;
            padding: 16px; margin-bottom: 28px;
        }
        .order-id-label { font-family: 'Space Mono', monospace; font-size: 0.6rem; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
        .order-id-val { font-family: 'Space Mono', monospace; font-size: 1.1rem; letter-spacing: 0.12em; color: var(--accent); font-weight: 700; }
        .btn-back-home { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; background: var(--accent); color: #000; font-family: 'Space Mono', monospace; font-size: 0.75rem; letter-spacing: 0.08em; font-weight: 700; border: none; border-radius: 2px; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-back-home:hover { background: #d8ff20; color: #000; }

        /* ── MISC ── */
        .breadcrumb-velox { display: flex; align-items: center; gap: 8px; font-family: 'Space Mono', monospace; font-size: 0.68rem; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 32px; }
        .breadcrumb-velox a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
        .breadcrumb-velox a:hover { color: var(--accent); }
        .breadcrumb-velox .sep { color: var(--border-accent); }
        .breadcrumb-velox .current { color: var(--accent); }
        .fade-up { opacity: 0; transform: translateY(16px); transition: opacity 0.4s ease, transform 0.4s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .form-valid-msg { font-size: 0.72rem; color: var(--success); margin-top: 4px; display: none; }
        .form-valid-msg.show { display: flex; align-items: center; gap: 4px; }
        .char-counter { font-family: 'Space Mono', monospace; font-size: 0.6rem; color: var(--text-muted); text-align: right; margin-top: 4px; }

        @media (max-width: 991px) {
            .order-summary { position: static; margin-top: 24px; }
        }
    </style>
</head>
<body>

    {{-- ── NAVBAR ── --}}
    <nav class="navbar-capstone">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="nav-brand">CAP<span>STONE</span></a>
                <div style="font-family:'Space Mono',monospace;font-size:0.7rem;letter-spacing:0.1em;color:var(--text-muted);display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-lock-fill" style="color:var(--success);"></i> HALAMAN AMAN & TERENKRIPSI
                </div>
            </div>
        </div>
    </nav>

    {{-- ── PROGRESS BAR ── --}}
    <div class="checkout-progress">
        <div class="container">
            <div class="step-bar">
                <div class="step-item done">
                    <div class="step-circle"><i class="bi bi-check-lg"></i></div>
                    <div class="step-label">Pilih Kendaraan</div>
                </div>
                <div class="step-connector done"></div>
                <div class="step-item done">
                    <div class="step-circle"><i class="bi bi-check-lg"></i></div>
                    <div class="step-label">Detail</div>
                </div>
                <div class="step-connector done"></div>
                <div class="step-item active">
                    <div class="step-circle">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-item">
                    <div class="step-circle">4</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="checkout-body">
        <div class="container">

            <div class="breadcrumb-velox">
                <a href="{{ url('/') }}">Beranda</a>
                <span class="sep">/</span>
                <a href="{{ url('/vehicles') }}">Kendaraan</a>
                <span class="sep">/</span>
                <a href="{{ url('/vehicles/toyota-yaris') }}">Toyota Yaris</a>
                <span class="sep">/</span>
                <span class="current">Pembayaran</span>
            </div>

            <div class="row g-4 align-items-start">

                {{-- ── LEFT COLUMN: FORMS ── --}}
                <div class="col-lg-7">

                    {{-- Section 1: Data Penyewa --}}
                    <div class="form-section fade-up">
                        <div class="form-section-head">
                            <div class="form-section-num">1</div>
                            <div>
                                <div class="form-section-title">Data Penyewa</div>
                                <div class="form-section-subtitle">Isi data diri sesuai KTP/identitas resmi</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-cap">Nama Lengkap <span>*</span></label>
                                <div class="input-group-cap">
                                    <i class="bi bi-person input-icon"></i>
                                    <input type="text" class="form-control-cap" placeholder="Sesuai KTP" id="namaInput">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cap">Nomor KTP / SIM <span>*</span></label>
                                <div class="input-group-cap">
                                    <i class="bi bi-card-text input-icon"></i>
                                    <input type="text" class="form-control-cap" placeholder="16 digit NIK" maxlength="16">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cap">Nomor WhatsApp <span>*</span></label>
                                <div class="input-group-cap">
                                    <i class="bi bi-whatsapp input-icon"></i>
                                    <input type="tel" class="form-control-cap" placeholder="+62 8xx xxxx xxxx">
                                </div>
                                <div class="form-hint"><i class="bi bi-info-circle"></i> Konfirmasi pemesanan dikirim via WhatsApp</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cap">Email <span>*</span></label>
                                <div class="input-group-cap">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email" class="form-control-cap" placeholder="email@contoh.com">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label-cap">Alamat Penjemputan <span>*</span></label>
                                <div class="input-group-cap">
                                    <i class="bi bi-geo-alt input-icon" style="top:14px;transform:none;"></i>
                                    <textarea class="form-control-cap" rows="2" placeholder="Masukkan alamat lengkap untuk pengantaran kendaraan..." id="alamatInput" style="padding-left:40px;resize:none;"></textarea>
                                </div>
                                <div class="char-counter"><span id="charCount">0</span>/200</div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Jadwal Sewa --}}
                    <div class="form-section fade-up" style="transition-delay:0.1s">
                        <div class="form-section-head">
                            <div class="form-section-num">2</div>
                            <div>
                                <div class="form-section-title">Jadwal Sewa</div>
                                <div class="form-section-subtitle">Pilih tanggal dan durasi penyewaan</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="date-range-wrap">
                                    <div>
                                        <label class="form-label-cap">Tanggal Mulai <span>*</span></label>
                                        <input type="date" class="form-control-cap" id="startDate">
                                    </div>
                                    <div class="date-sep"><i class="bi bi-arrow-right"></i></div>
                                    <div>
                                        <label class="form-label-cap">Tanggal Selesai <span>*</span></label>
                                        <input type="date" class="form-control-cap" id="endDate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cap">Jam Pengambilan <span>*</span></label>
                                <select class="form-control-cap">
                                    @for($h=8;$h<=18;$h++)
                                    <option>{{ str_pad($h,2,'0',STR_PAD_LEFT) }}:00</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-cap">Lokasi Pengambilan <span>*</span></label>
                                <select class="form-control-cap">
                                    <option>Kantor Capstone Sidoarjo</option>
                                    <option>Bandara Juanda Terminal 1</option>
                                    <option>Bandara Juanda Terminal 2</option>
                                    <option>Antar ke Alamat (+Rp 50.000)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-cap">Catatan Tambahan</label>
                                <textarea class="form-control-cap" rows="2" placeholder="Permintaan khusus, kondisi yang perlu diketahui, dsb..." style="resize:none;"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Metode Pembayaran --}}
                   {{-- Section 3: Metode Pembayaran --}}
<div class="form-section fade-up" style="transition-delay:0.2s">
    <div class="form-section-head">
        <div class="form-section-num">3</div>
        <div>
            <div class="form-section-title">Metode Pembayaran</div>
            <div class="form-section-subtitle">Pilih metode pembayaran</div>
        </div>
    </div>

    <div class="pay-methods">

        {{-- BRIVA --}}
        <label class="pay-method-item selected">
            <input type="radio" name="paymethod" value="briva" checked>
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon"
                style="background:#00529c;color:#fff;font-weight:700;font-size:0.6rem;font-family:'Space Mono',monospace;">
                BRI
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">BRIVA</div>
                <div class="pay-method-desc">Virtual Account BRI</div>
            </div>

            <span class="pay-method-badge free">GRATIS</span>
        </label>

        <div class="bank-detail-panel show" id="briva-detail">
            <div style="font-family:'Space Mono',monospace;font-size:0.6rem;letter-spacing:0.1em;color:var(--text-muted);">
                NOMOR VA BRI
            </div>

            <div class="bank-account-num">88081234567890</div>

            <div class="bank-account-name">
                a.n. PT CAPSTONE RENTAL INDONESIA
            </div>
        </div>

        {{-- BNI VA --}}
        <label class="pay-method-item">
            <input type="radio" name="paymethod" value="bni">
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon"
                style="background:#ff6600;color:#fff;font-weight:700;font-size:0.6rem;font-family:'Space Mono',monospace;">
                BNI
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">BNI Virtual Account</div>
                <div class="pay-method-desc">Pembayaran otomatis</div>
            </div>

            <span class="pay-method-badge free">GRATIS</span>
        </label>

        <div class="bank-detail-panel" id="bni-detail">
            <div class="bank-account-num">98881234567890</div>
            <div class="bank-account-name">a.n. PT CAPSTONE RENTAL INDONESIA</div>
        </div>

        {{-- Mandiri VA --}}
        <label class="pay-method-item">
            <input type="radio" name="paymethod" value="mandiri">
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon"
                style="background:#003882;color:#ffde00;font-weight:700;font-size:0.58rem;font-family:'Space Mono',monospace;">
                MDR
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">Mandiri Virtual Account</div>
                <div class="pay-method-desc">Pembayaran otomatis</div>
            </div>

            <span class="pay-method-badge free">GRATIS</span>
        </label>

        <div class="bank-detail-panel" id="mandiri-detail">
            <div class="bank-account-num">700081234567890</div>
            <div class="bank-account-name">a.n. PT CAPSTONE RENTAL INDONESIA</div>
        </div>

        {{-- Bank Transfer --}}
        <label class="pay-method-item">
            <input type="radio" name="paymethod" value="transfer">
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon">
                <i class="bi bi-bank"></i>
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">Transfer Bank</div>
                <div class="pay-method-desc">Transfer manual antar bank</div>
            </div>

            <span class="pay-method-badge free">MANUAL</span>
        </label>

        <div class="bank-detail-panel" id="transfer-detail">
            <div class="bank-account-num">1234567890</div>
            <div class="bank-account-name">Bank BCA - PT CAPSTONE RENTAL INDONESIA</div>
        </div>

        {{-- DANA --}}
        <label class="pay-method-item">
            <input type="radio" name="paymethod" value="dana">
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon"
                style="background:#00aaff;color:#fff;font-weight:700;font-size:0.65rem;">
                DANA
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">DANA</div>
                <div class="pay-method-desc">Pembayaran e-wallet</div>
            </div>

            <span class="pay-method-badge free">INSTAN</span>
        </label>

        <div class="bank-detail-panel" id="dana-detail">
            <div class="bank-account-num">081234567890</div>
            <div class="bank-account-name">Nomor DANA CAPSTONE</div>
        </div>

        {{-- OVO --}}
        <label class="pay-method-item">
            <input type="radio" name="paymethod" value="ovo">
            <div class="pay-method-radio"></div>

            <div class="pay-method-icon"
                style="background:#6f2cff;color:#fff;font-weight:700;font-size:0.7rem;">
                OVO
            </div>

            <div class="pay-method-info">
                <div class="pay-method-name">OVO</div>
                <div class="pay-method-desc">Pembayaran e-wallet</div>
            </div>

            <span class="pay-method-badge free">INSTAN</span>
        </label>

        <div class="bank-detail-panel" id="ovo-detail">
            <div class="bank-account-num">081234567890</div>
            <div class="bank-account-name">Nomor OVO CAPSTONE</div>
        </div>

    </div>
</div>

                    {{-- Section 4: Konfirmasi Syarat --}}
                    <div class="form-section fade-up" style="transition-delay:0.3s">
                        <div class="form-section-head">
                            <div class="form-section-num">4</div>
                            <div>
                                <div class="form-section-title">Konfirmasi & Persetujuan</div>
                            </div>
                        </div>
                        @foreach([
                            ['id'=>'tnc1','label'=>'Saya telah membaca dan menyetujui <a href="#" style="color:var(--accent);text-decoration:none;">Syarat & Ketentuan</a> penyewaan kendaraan CAPSTONE.'],
                            ['id'=>'tnc2','label'=>'Saya bertanggung jawab atas kendaraan selama periode sewa dan akan menjaga kondisi kendaraan.'],
                            ['id'=>'tnc3','label'=>'Saya memahami kebijakan deposit dan biaya tambahan yang mungkin berlaku.'],
                        ] as $t)
                        <label style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);cursor:pointer;" class="tnc-item">
                            <input type="checkbox" class="tnc-check" id="{{ $t['id'] }}" style="display:none;">
                            <div class="custom-checkbox" style="width:18px;height:18px;border:1.5px solid var(--border);border-radius:2px;background:var(--bg-surface);flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:all 0.2s;margin-top:2px;">
                                <i class="bi bi-check2" style="font-size:0.8rem;color:#000;display:none;"></i>
                            </div>
                            <span style="font-size:0.84rem;color:var(--text-secondary);line-height:1.6;">{!! $t['label'] !!}</span>
                        </label>
                        @endforeach
                    </div>

                </div>

                {{-- ── RIGHT COLUMN: ORDER SUMMARY ── --}}
                <div class="col-lg-5 fade-up" style="transition-delay:0.15s">
                    <div class="order-summary">

                        <div class="os-header">
                            <div class="os-title">RINGKASAN PESANAN</div>
                        </div>

                        {{-- Vehicle --}}
                        <div class="os-vehicle-card">
                            <div class="os-vehicle-img">
                                <svg viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 52 L18 64 Q18 70 24 70 L176 70 Q182 70 182 64 L182 52 Z" fill="#282828" stroke="#333"/>
                                    <path d="M50 52 L64 32 Q70 25 80 25 L120 25 Q130 25 136 32 L150 52 Z" fill="#1c1c1c" stroke="#222"/>
                                    <path d="M52 51 L63 34 Q68 27 78 27 L97 27 L97 51 Z" fill="rgba(200,255,0,0.08)" stroke="rgba(200,255,0,0.25)"/>
                                    <path d="M103 27 L122 27 Q132 27 137 34 L148 51 L103 51 Z" fill="rgba(200,255,0,0.08)" stroke="rgba(200,255,0,0.25)"/>
                                    <line x1="100" y1="27" x2="100" y2="51" stroke="#111" stroke-width="2"/>
                                    <rect x="19" y="46" width="14" height="5" rx="1" fill="rgba(200,255,0,0.8)"/>
                                    <rect x="167" y="46" width="12" height="5" rx="1" fill="rgba(255,55,55,0.8)"/>
                                    <circle cx="48" cy="70" r="13" fill="#0e0e0e" stroke="#2a2a2a" stroke-width="1.5"/>
                                    <circle cx="48" cy="70" r="7" fill="#0a0a0a" stroke="#333"/>
                                    <circle cx="48" cy="70" r="2.5" fill="#1e1e1e" stroke="rgba(200,255,0,0.4)"/>
                                    <circle cx="152" cy="70" r="13" fill="#0e0e0e" stroke="#2a2a2a" stroke-width="1.5"/>
                                    <circle cx="152" cy="70" r="7" fill="#0a0a0a" stroke="#333"/>
                                    <circle cx="152" cy="70" r="2.5" fill="#1e1e1e" stroke="rgba(200,255,0,0.4)"/>
                                </svg>
                            </div>
                            <div>
                                <div style="margin-bottom:4px;"><span class="os-vehicle-badge">TERLARIS</span></div>
                                <div class="os-vehicle-name">Toyota Yaris</div>
                                <div class="os-vehicle-cat">City Car · Matic CVT · 2023</div>
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div class="duration-picker">
                            <div class="duration-label">Periode Sewa</div>
                            <div class="duration-dates">
                                <div class="dur-date-box">
                                    <div class="dur-date-lbl">MULAI</div>
                                    <div class="dur-date-val" id="sumStart">— pilih tanggal —</div>
                                </div>
                                <div class="dur-arrow"><i class="bi bi-arrow-right"></i></div>
                                <div class="dur-date-box">
                                    <div class="dur-date-lbl">SELESAI</div>
                                    <div class="dur-date-val" id="sumEnd">— pilih tanggal —</div>
                                </div>
                            </div>
                            <div class="dur-nights">
                                <span>Total Durasi</span>
                                <span id="totalDays">0 hari</span>
                            </div>
                        </div>

                        {{-- Price Breakdown --}}
                        <div class="price-breakdown">
                            <div class="pb-row">
                                <div class="pb-label">Sewa kendaraan</div>
                                <div class="pb-value" id="pbBase">Rp 350.000 × 0 hari</div>
                            </div>
                            <div class="pb-row">
                                <div class="pb-label">Asuransi dasar <span class="pb-badge">GRATIS</span></div>
                                <div class="pb-value pb-discount">Rp 0</div>
                            </div>
                            <div class="pb-row" id="pb-delivery-row" style="display:none;">
                                <div class="pb-label">Biaya antar</div>
                                <div class="pb-value">Rp 50.000</div>
                            </div>
                            <div class="pb-row" id="pb-promo-row" style="display:none;">
                                <div class="pb-label">Diskon promo <span class="pb-badge" style="background:var(--success-dim);border-color:rgba(0,200,80,0.3);color:var(--success);" id="promoLabel">—</span></div>
                                <div class="pb-value pb-discount" id="pbDiscount">-Rp 0</div>
                            </div>
                            <div class="pb-row">
                                <div class="pb-label">Deposit (refundable)</div>
                                <div class="pb-value">Rp 500.000</div>
                            </div>
                            <div class="pb-divider"></div>
                            <div class="pb-row">
                                <div class="pb-total-label">TOTAL PEMBAYARAN</div>
                                <div></div>
                            </div>
                            <div class="pb-row">
                                <div class="pb-total-val" id="pbTotal">Rp 500.000</div>
                                <div style="font-family:'Space Mono',monospace;font-size:0.62rem;color:var(--text-muted);">termasuk deposit</div>
                            </div>
                        </div>

                        {{-- Promo --}}
                        <div class="promo-wrap">
                            <div class="promo-row">
                                <input type="text" class="promo-input" placeholder="KODE PROMO" id="promoInput">
                                <button class="btn-promo" onclick="applyPromo()">PAKAI</button>
                            </div>
                            <div id="promoMsg" style="font-size:0.72rem;margin-top:6px;display:none;"></div>
                        </div>

                        {{-- Submit --}}
                        <div class="os-footer">
                            <button class="btn-bayar" id="btnBayar" onclick="submitPembayaran()" disabled>
                                <i class="bi bi-lock-fill"></i> BAYAR SEKARANG
                            </button>
                            <div class="secure-badges">
                                <div class="sec-badge"><i class="bi bi-shield-check"></i> SSL 256-bit</div>
                                <div class="sec-badge"><i class="bi bi-shield-check"></i> PCI DSS</div>
                                <div class="sec-badge"><i class="bi bi-shield-check"></i> Terenkripsi</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── SUCCESS MODAL ── --}}
    <div class="success-overlay" id="successOverlay">
        <div class="success-box">
            <div class="success-icon"><i class="bi bi-check-lg"></i></div>
            <div class="success-title">PEMESANAN BERHASIL!</div>
            <p class="success-sub">
                Terima kasih telah memesan kendaraan di CAPSTONE.<br>
                Detail pemesanan telah dikirim ke WhatsApp & email Anda.
            </p>
            <div class="order-id-box">
                <div class="order-id-label">NOMOR PESANAN</div>
                <div class="order-id-val" id="orderId">CAP-2025-XXXXX</div>
            </div>
            <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ url('/') }}" class="btn-back-home">
                    <i class="bi bi-house"></i> KEMBALI KE BERANDA
                </a>
                <a href="#" style="display:inline-flex;align-items:center;gap:8px;padding:14px 22px;background:transparent;color:var(--text-secondary);border:1px solid var(--border);font-family:'Space Mono',monospace;font-size:0.72rem;letter-spacing:0.08em;border-radius:2px;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--text-secondary)';this.style.color='var(--text-primary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
                    <i class="bi bi-receipt"></i> LIHAT PESANAN
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ── Fade-up ──
        const fadeEls = document.querySelectorAll('.fade-up');
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.06 });
        fadeEls.forEach(el => obs.observe(el));

      // ── Payment method selection ──
const pmItems = document.querySelectorAll('.pay-method-item');

pmItems.forEach(item => {
    item.addEventListener('click', () => {

        pmItems.forEach(i => i.classList.remove('selected'));
        item.classList.add('selected');

        item.querySelector('input[type="radio"]').checked = true;

        // Hide all detail panels
        document.querySelectorAll('.bank-detail-panel')
            .forEach(panel => panel.classList.remove('show'));

        // Show selected detail
        const method = item.querySelector('input').value;
        const target = document.getElementById(method + '-detail');

        if (target) {
            target.classList.add('show');
        }
    });
});

        // ── Date range → update summary ──
        const startD = document.getElementById('startDate');
        const endD   = document.getElementById('endDate');
        const BASE   = 350000;
        let totalDays = 0;
        let promoDiscount = 0;

        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        startD.min = today; endD.min = today;

        function updateSummary() {
            const s = startD.value, e = endD.value;
            if (!s || !e) return;
            const diff = Math.ceil((new Date(e) - new Date(s)) / 86400000);
            if (diff <= 0) { endD.value = ''; return; }
            totalDays = diff;

            // Summary dates
            const fmt = d => new Date(d + 'T00:00:00').toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric'});
            document.getElementById('sumStart').textContent = fmt(s);
            document.getElementById('sumEnd').textContent   = fmt(e);
            document.getElementById('totalDays').textContent = diff + ' hari';
            document.getElementById('pbBase').textContent  = 'Rp ' + fmtRp(BASE) + ' × ' + diff + ' hari';

            recalcTotal();
            checkFormReady();
        }

        function recalcTotal() {
            const base = BASE * totalDays;
            const deposit = 500000;
            const total = base + deposit - promoDiscount;
            document.getElementById('pbTotal').textContent = 'Rp ' + fmtRp(total);
            if (promoDiscount > 0) {
                document.getElementById('pb-promo-row').style.display = 'flex';
                document.getElementById('pbDiscount').textContent = '-Rp ' + fmtRp(promoDiscount);
            }
        }

        function fmtRp(n) {
            return n.toLocaleString('id-ID');
        }

        startD.addEventListener('change', () => { endD.min = startD.value; updateSummary(); });
        endD.addEventListener('change', updateSummary);

        // ── Char counter for address ──
        const alamat = document.getElementById('alamatInput');
        const charCnt = document.getElementById('charCount');
        if (alamat) alamat.addEventListener('input', () => {
            charCnt.textContent = alamat.value.length;
        });

        // ── Checkbox styling ──
        document.querySelectorAll('.tnc-item').forEach(item => {
            item.addEventListener('click', () => {
                const cb = item.querySelector('.tnc-check');
                const box = item.querySelector('.custom-checkbox');
                const icon = box.querySelector('i');
                cb.checked = !cb.checked;
                if (cb.checked) {
                    box.style.background = 'var(--accent)';
                    box.style.borderColor = 'var(--accent)';
                    icon.style.display = 'block';
                } else {
                    box.style.background = 'var(--bg-surface)';
                    box.style.borderColor = 'var(--border)';
                    icon.style.display = 'none';
                }
                checkFormReady();
            });
        });

        // ── Form validation ──
        function checkFormReady() {
            const checks = document.querySelectorAll('.tnc-check');
            const allChecked = [...checks].every(c => c.checked);
            const hasName = document.getElementById('namaInput').value.trim().length > 2;
            const hasDates = totalDays > 0;
            document.getElementById('btnBayar').disabled = !(allChecked && hasName && hasDates);
        }

        document.getElementById('namaInput').addEventListener('input', checkFormReady);

        // ── Promo code ──
        const promos = { 'CAPSTONE10': 10, 'HEMAT20': 20, 'PERDANA': 15 };
        function applyPromo() {
            const code = document.getElementById('promoInput').value.trim().toUpperCase();
            const msgEl = document.getElementById('promoMsg');
            if (promos[code]) {
                const pct = promos[code];
                promoDiscount = Math.round(BASE * totalDays * pct / 100);
                document.getElementById('promoLabel').textContent = code + ' -' + pct + '%';
                msgEl.innerHTML = '<span style="color:var(--success)"><i class="bi bi-check-circle-fill"></i> Promo berhasil! Diskon ' + pct + '% diterapkan.</span>';
                msgEl.style.display = 'block';
                recalcTotal();
            } else {
                promoDiscount = 0;
                document.getElementById('pb-promo-row').style.display = 'none';
                msgEl.innerHTML = '<span style="color:#ff6060"><i class="bi bi-x-circle-fill"></i> Kode promo tidak valid atau sudah kadaluarsa.</span>';
                msgEl.style.display = 'block';
                recalcTotal();
            }
        }

        document.getElementById('promoInput').addEventListener('keypress', e => {
            if (e.key === 'Enter') applyPromo();
        });

        // ── CC number formatting ──
        const ccNum = document.getElementById('ccNum');
        if (ccNum) ccNum.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '').substring(0, 16);
            this.value = v.replace(/(\d{4})(?=\d)/g, '$1 ');
        });

        // ── Copy ──
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.target.closest('button');
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-lg"></i> TERSALIN!';
                btn.style.background = 'var(--accent)';
                btn.style.color = '#000';
                setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; }, 2000);
            });
        }

        // ── Submit ──
        function submitPembayaran() {
            const btn = document.getElementById('btnBayar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> MEMPROSES...';

            setTimeout(() => {
                // Generate order ID
                const oid = 'CAP-' + new Date().getFullYear() + '-' + Math.random().toString(36).substr(2,5).toUpperCase();
                document.getElementById('orderId').textContent = oid;
                document.getElementById('successOverlay').classList.add('show');
            }, 2200);
        }
    </script>
</body>
</html>