@extends('layouts.app')

@push('styles')
    <style>
        /* ── HERO ── */
        .hero-section {
            min-height: 100vh;
            background: var(--gradient-hero);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-noise {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.5;
            pointer-events: none;
        }

        .hero-grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(200, 255, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(200, 255, 0, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
        }

        .hero-orb-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(200, 255, 0, 0.08) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }

        .hero-orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(100, 120, 255, 0.06) 0%, transparent 70%);
            bottom: 0;
            left: 10%;
        }

        .hero-label {
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-label::before {
            content: '';
            display: block;
            width: 30px;
            height: 1px;
            background: var(--accent);
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(4.5rem, 10vw, 9rem);
            line-height: 0.92;
            letter-spacing: 0.02em;
            color: var(--text-primary);
            margin-bottom: 28px;
        }

        .hero-title .accent-word {
            color: var(--accent);
        }

        .hero-desc {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.75;
            max-width: 420px;
            margin-bottom: 44px;
        }

        .btn-primary-capstone {
            font-family: 'Space Mono', monospace;
            font-size: 0.78rem;
            letter-spacing: 0.1em;
            padding: 16px 36px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 2px;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-capstone::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.15);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-primary-capstone:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px var(--accent-glow);
            color: #000;
        }

        .btn-primary-capstone:hover::after {
            opacity: 1;
        }

        .btn-ghost-capstone {
            font-family: 'Space Mono', monospace;
            font-size: 0.78rem;
            letter-spacing: 0.1em;
            padding: 15px 36px;
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: 2px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.25s;
        }

        .btn-ghost-capstone:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .hero-stats {
            display: flex;
            gap: 48px;
            margin-top: 64px;
            padding-top: 40px;
            border-top: 1px solid var(--border);
        }

        .stat-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-num span {
            color: var(--accent);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* hero car visual */
        .hero-car-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-car-bg {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 255, 0, 0.06) 0%, transparent 70%);
            animation: pulse-glow 4s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }
        }

        .hero-car-svg {
            width: 100%;
            max-width: 580px;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 40px 80px rgba(200, 255, 0, 0.15));
            animation: float-car 6s ease-in-out infinite;
        }

        @keyframes float-car {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .hero-car-line {
            position: absolute;
            bottom: -20px;
            width: 70%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-glow), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }
        }

        /* ── BOOKING BAR ── */
        .booking-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 28px 32px;
            margin-top: -1px;
            position: relative;
            z-index: 10;
        }

        .booking-label {
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .booking-input {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--text-primary);
            padding: 12px 16px;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .booking-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(200, 255, 0, 0.03);
        }

        .booking-input option {
            background-color: var(--bg-card);
            color: var(--text-primary);
        }

        .booking-input::placeholder {
            color: var(--text-muted);
        }

        select.booking-input {
            appearance: none;
            cursor: pointer;
        }

        .booking-divider {
            width: 1px;
            background: var(--border);
            margin: 0 8px;
            align-self: stretch;
        }

        .btn-search-capstone {
            font-family: 'Space Mono', monospace;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            padding: 14px 28px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 2px;
            font-weight: 700;
            white-space: nowrap;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search-capstone:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 30px var(--accent-glow);
        }

        /* ── SECTION HEADERS ── */
        .section-tag {
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.2em;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 3.8rem);
            line-height: 1;
            color: var(--text-primary);
            letter-spacing: 0.03em;
        }

        .section-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.8;
            max-width: 480px;
        }

        /* ── FLEET SECTION ── */
        .fleet-section {
            padding: 100px 0;
            background: var(--bg-base);
        }

        .car-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            transition: all 0.35s ease;
            position: relative;
        }

        .car-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }

        .car-card:hover {
            border-color: var(--border-accent);
            background: var(--bg-card-hover);
            transform: translateY(-4px);
        }

        .car-card:hover::before {
            transform: scaleX(1);
        }

        .car-img-wrap {
            background: var(--bg-surface);
            padding: 28px;
            position: relative;
            overflow: hidden;
        }

        .car-img-wrap::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(transparent, var(--bg-card));
        }

        .car-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            padding: 4px 10px;
            background: var(--accent);
            color: #000;
            border-radius: 1px;
            font-weight: 700;
        }

        .car-img {
            width: 100%;
            height: 160px;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        .car-body {
            padding: 22px 24px 28px;
        }

        .car-category {
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .car-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.7rem;
            letter-spacing: 0.04em;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .car-specs {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        .spec-item i {
            color: var(--accent);
            font-size: 0.85rem;
        }

        .car-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .car-price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: var(--text-primary);
            line-height: 1;
        }

        .car-price span {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            color: var(--text-muted);
            display: block;
            letter-spacing: 0.05em;
        }

        .btn-rent {
            font-family: 'Space Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            padding: 10px 20px;
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            border-radius: 2px;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-rent:hover {
            background: var(--accent);
            color: #000;
        }

        /* ── WHY US ── */
        .why-section {
            padding: 100px 0;
            background: var(--bg-surface);
            position: relative;
            overflow: hidden;
        }

        .why-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-accent), transparent);
        }

        .why-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-accent), transparent);
        }

        .feature-item {
            padding: 36px 32px;
            border: 1px solid var(--border);
            border-radius: 4px;
            background: var(--bg-card);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .feature-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(200, 255, 0, 0.06) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feature-item:hover {
            border-color: var(--border-accent);
            transform: translateY(-2px);
        }

        .feature-item:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            background: var(--accent-dim);
            border: 1px solid var(--border-accent);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--accent);
            margin-bottom: 22px;
        }

        .feature-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 0.04em;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .feature-desc {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.75;
        }

        /* ── HOW IT WORKS ── */
        .how-section {
            padding: 100px 0;
            background: var(--bg-base);
        }

        .step-num {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 5rem;
            color: rgba(200, 255, 0, 0.08);
            line-height: 1;
            margin-bottom: 0;
        }

        .step-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 0.04em;
            color: var(--text-primary);
            margin-top: -16px;
            margin-bottom: 10px;
        }

        .step-desc {
            font-size: 0.87rem;
            color: var(--text-secondary);
            line-height: 1.75;
        }

        .step-connector {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--border-accent), transparent);
            margin-top: -30px;
        }

        /* ── TESTIMONIALS ── */
        .testi-section {
            padding: 100px 0;
            background: var(--bg-surface);
        }

        .testi-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 32px 28px;
            transition: all 0.3s;
        }

        .testi-card:hover {
            border-color: var(--border-accent);
            transform: translateY(-3px);
        }

        .testi-quote {
            font-size: 2rem;
            color: var(--accent);
            font-family: 'Bebas Neue', sans-serif;
            margin-bottom: 16px;
        }

        .testi-text {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .testi-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--accent-dim);
            border: 1px solid var(--border-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            color: var(--accent);
        }

        .testi-name {
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--text-primary);
        }

        .testi-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .star-rating {
            color: var(--accent);
            font-size: 0.8rem;
            margin-bottom: 12px;
        }

        /* ── CTA SECTION ── */
        .cta-section {
            padding: 100px 0;
            background: var(--bg-base);
            position: relative;
            overflow: hidden;
        }

        .cta-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(200, 255, 0, 0.05) 0%, transparent 70%);
        }

        .cta-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 7vw, 6rem);
            line-height: 0.95;
            letter-spacing: 0.03em;
            color: var(--text-primary);
            margin-bottom: 24px;
        }

        .cta-title .cta-accent {
            color: var(--accent);
        }

        .social-link {
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .social-link:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-dim);
        }

        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-up-delay-1 {
            transition-delay: 0.1s;
        }

        .fade-up-delay-2 {
            transition-delay: 0.2s;
        }

        .fade-up-delay-3 {
            transition-delay: 0.3s;
        }

        .capstone-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }

        @media (max-width: 768px) {
            .hero-stats {
                gap: 24px;
                flex-wrap: wrap;
            }

            .step-connector {
                display: none;
            }

            .hero-title {
                font-size: 4rem;
            }
        }
    </style>
@endpush
@section('content')
    <section class="hero-section" id="home">
        <div class="hero-noise"></div>
        <div class="hero-grid-lines"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>

        <div class="container" style="padding-top: 80px;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-label">Premium Car Rental — Jakarta</div>
                    <h1 class="hero-title">
                        DRIVE<br>
                        WITHOUT<br>
                        <span class="accent-word">LIMITS</span>
                    </h1>
                    <p class="hero-desc">
                        Mobil premium untuk setiap perjalanan. Dari city car hingga SUV mewah—
                        booking mudah, harga transparan, pengalaman tak terlupakan.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#fleet" class="btn-primary-capstone">LIHAT MOBIL <i
                                class="bi bi-arrow-right ms-2"></i></a>
                        <a href="#how" class="btn-ghost-capstone">
                            <i class="bi bi-play-circle"></i> Cara Kerja
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div>
                            <div class="stat-num">50<span>+</span></div>
                            <div class="stat-label">Unit Mobil</div>
                        </div>
                        <div>
                            <div class="stat-num">10<span>K+</span></div>
                            <div class="stat-label">Pelanggan Puas</div>
                        </div>
                        <div>
                            <div class="stat-num">24<span>/7</span></div>
                            <div class="stat-label">Layanan Aktif</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-car-wrapper">
                        <div class="hero-car-bg"></div>
                        <svg class="hero-car-svg" viewBox="0 0 600 300" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="bodyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#2a2a2a" />
                                    <stop offset="100%" style="stop-color:#111" />
                                </linearGradient>
                                <linearGradient id="roofGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#333" />
                                    <stop offset="100%" style="stop-color:#1a1a1a" />
                                </linearGradient>
                                <radialGradient id="wheelGrad" cx="50%" cy="50%" r="50%">
                                    <stop offset="0%" style="stop-color:#444" />
                                    <stop offset="100%" style="stop-color:#111" />
                                </radialGradient>
                                <filter id="glow">
                                    <feGaussianBlur stdDeviation="3" result="coloredBlur" />
                                    <feMerge>
                                        <feMergeNode in="coloredBlur" />
                                        <feMergeNode in="SourceGraphic" />
                                    </feMerge>
                                </filter>
                            </defs>
                            <!-- Shadow -->
                            <ellipse cx="300" cy="265" rx="220" ry="18" fill="rgba(0,0,0,0.5)" />
                            <!-- Body -->
                            <path d="M60 195 L60 220 Q60 235 75 235 L525 235 Q540 235 540 220 L540 195 Z"
                                fill="url(#bodyGrad)" stroke="#333" stroke-width="1" />
                            <!-- Roof & windows -->
                            <path d="M150 195 L190 140 Q200 128 220 128 L380 128 Q400 128 410 140 L450 195 Z"
                                fill="url(#roofGrad)" stroke="#2a2a2a" stroke-width="1" />
                            <!-- Window left -->
                            <path d="M165 193 L197 148 Q205 138 220 138 L285 138 L285 193 Z" fill="rgba(200,255,0,0.08)"
                                stroke="rgba(200,255,0,0.3)" stroke-width="1" />
                            <!-- Window right -->
                            <path d="M295 138 L380 138 Q395 138 403 148 L435 193 L295 193 Z" fill="rgba(200,255,0,0.08)"
                                stroke="rgba(200,255,0,0.3)" stroke-width="1" />
                            <!-- Window divider -->
                            <line x1="290" y1="138" x2="290" y2="193" stroke="#1a1a1a"
                                stroke-width="3" />
                            <!-- Hood -->
                            <path d="M60 195 L90 195 L130 175 L150 195 Z" fill="#222" stroke="#333" stroke-width="1" />
                            <!-- Trunk -->
                            <path d="M450 195 L470 175 L510 195 L540 195 Z" fill="#222" stroke="#333"
                                stroke-width="1" />
                            <!-- Headlights -->
                            <rect x="62" y="185" width="38" height="10" rx="3" fill="rgba(200,255,0,0.9)"
                                filter="url(#glow)" />
                            <rect x="62" y="185" width="38" height="10" rx="3" fill="none"
                                stroke="rgba(200,255,0,0.5)" stroke-width="2" />
                            <!-- Taillights -->
                            <rect x="500" y="185" width="36" height="10" rx="3"
                                fill="rgba(255,50,50,0.9)" />
                            <!-- Wheels -->
                            <circle cx="155" cy="235" r="38" fill="url(#wheelGrad)" stroke="#444"
                                stroke-width="2" />
                            <circle cx="155" cy="235" r="24" fill="#1a1a1a" stroke="#555"
                                stroke-width="2" />
                            <circle cx="155" cy="235" r="10" fill="#333" stroke="rgba(200,255,0,0.5)"
                                stroke-width="1.5" />
                            <!-- Wheel spokes left -->
                            <line x1="155" y1="211" x2="155" y2="259" stroke="#444"
                                stroke-width="2" />
                            <line x1="131" y1="235" x2="179" y2="235" stroke="#444"
                                stroke-width="2" />
                            <line x1="138" y1="218" x2="172" y2="252" stroke="#444"
                                stroke-width="1.5" />
                            <line x1="172" y1="218" x2="138" y2="252" stroke="#444"
                                stroke-width="1.5" />

                            <circle cx="445" cy="235" r="38" fill="url(#wheelGrad)" stroke="#444"
                                stroke-width="2" />
                            <circle cx="445" cy="235" r="24" fill="#1a1a1a" stroke="#555"
                                stroke-width="2" />
                            <circle cx="445" cy="235" r="10" fill="#333" stroke="rgba(200,255,0,0.5)"
                                stroke-width="1.5" />
                            <line x1="445" y1="211" x2="445" y2="259" stroke="#444"
                                stroke-width="2" />
                            <line x1="421" y1="235" x2="469" y2="235" stroke="#444"
                                stroke-width="2" />
                            <line x1="428" y1="218" x2="462" y2="252" stroke="#444"
                                stroke-width="1.5" />
                            <line x1="462" y1="218" x2="428" y2="252" stroke="#444"
                                stroke-width="1.5" />
                            <!-- Door lines -->
                            <line x1="152" y1="195" x2="152" y2="232" stroke="#333"
                                stroke-width="1.5" />
                            <line x1="290" y1="195" x2="290" y2="232" stroke="#333"
                                stroke-width="1.5" />
                            <line x1="448" y1="195" x2="448" y2="232" stroke="#333"
                                stroke-width="1.5" />
                            <!-- Door handles -->
                            <rect x="200" y="208" width="22" height="4" rx="2" fill="#444" />
                            <rect x="340" y="208" width="22" height="4" rx="2" fill="#444" />
                            <!-- Accent stripe -->
                            <line x1="65" y1="210" x2="535" y2="210"
                                stroke="rgba(200,255,0,0.2)" stroke-width="1" />
                            <!-- Logo placeholder -->
                            <circle cx="300" cy="155" r="5" fill="rgba(200,255,0,0.7)"
                                filter="url(#glow)" />
                        </svg>
                        <div class="hero-car-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── BOOKING BAR ── --}}
    <section id="booking" style="background: var(--bg-surface); padding: 48px 0; border-top: 1px solid var(--border);">
        <div class="container">
            <form action="{{ route('vehicle.search') }}" method="GET">
                <div class="booking-bar">
                    <div class="row g-3 align-items-end flex-nowrap overflow-auto">
                        <div class="col">
                            <div class="booking-label">Lokasi Jemput</div>
                            <select name="lokasi" class="booking-input" required>
                                <option value="Sidoarjo Kota">Sidoarjo Kota</option>
                                <option value="Candi">Candi</option>
                                <option value="Buduran">Buduran</option>
                                <option value="Waru">Waru</option>
                                <option value="Taman">Taman</option>
                                <option value="Krian">Krian</option>
                                <option value="Porong">Porong</option>
                                <option value="Gedangan">Gedangan</option>
                                <option value="Sedati">Sedati</option>
                                <option value="Balongbendo">Balongbendo</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="booking-label">Tanggal Mulai</div>
                            <input type="date" name="start_date" class="booking-input" required />
                        </div>
                        <div class="col">
                            <div class="booking-label">Tanggal Selesai</div>
                            <input type="date" name="end_date" class="booking-input" required />
                        </div>
                        <div class="col">
                            <div class="booking-label">Range Harga</div>
                            <select name="price_range" class="booking-input">
                                <option value="all">Semua Harga</option>
                                <option value="100000-300000">Rp 100rb - Rp 300rb</option>
                                <option value="300000-500000">Rp 300rb - Rp 500rb</option>
                                <option value="500000-1000000">Rp 500rb - Rp 1jt</option>
                                <option value="1000000-2000000">Rp 1jt - Rp 2jt</option>
                            </select>
                        </div>
                        <div class="col">
                            <div class="booking-label">Kapasitas</div>
                            <select name="kapasitas" class="booking-input">
                                <option value="2">2 Orang</option>
                                <option value="4">4 Orang</option>
                                <option value="6">6 Orang</option>
                                <option value="7">7 Orang</option>
                                <option value="12">12 Orang</option>
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn-search-capstone w-100 justify-content-center">
                                <i class="bi bi-search"></i> CARI KENDARAAN
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- ── FLEET SECTION ── --}}
    <section class="fleet-section" id="fleet">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <div class="section-tag fade-up">// Mobil Kami</div>
                    <h2 class="section-title fade-up fade-up-delay-1">PILIH KENDARAAN<br>IMPIANMU</h2>
                </div>
                <div class="col-lg-6 d-flex align-items-end">
                    <p class="section-desc fade-up fade-up-delay-2">
                        Dari city car lincah hingga SUV tangguh dan sedan premium.
                        Semua dalam kondisi prima, siap menemanimu.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($vehicles as $index => $car)
                    <div class="col-lg-4 col-md-6 fade-up" style="transition-delay: {{ $index * 0.07 }}s">
                        <div class="car-card">
                            <div class="car-img-wrap">
                                <div class="car-img-container"
                                    style="width: 100%; aspect-ratio: 300 / 130; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                    @if (isset($car->images_data['front']) && $car->images_data['front'] !== null)
                                        <img class="car-img" src="{{ $car->images_data['front'] }}"
                                            alt="{{ $car->model }}"
                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <svg class="car-img" viewBox="0 0 300 130" xmlns="http://www.w3.org/2000/svg"
                                            style="width: 100%; height: 100%; border-radius: 8px;">
                                            <defs>
                                                <linearGradient id="cg{{ $index }}" x1="0%" y1="0%"
                                                    x2="100%" y2="100%">
                                                    <stop offset="0%" style="stop-color:#252525" />
                                                    <stop offset="100%" style="stop-color:#151515" />
                                                </linearGradient>
                                            </defs>
                                            <ellipse cx="150" cy="118" rx="120" ry="8"
                                                fill="rgba(0,0,0,0.4)" />
                                            <path d="M30 85 L30 100 Q30 108 38 108 L262 108 Q270 108 270 100 L270 85 Z"
                                                fill="url(#cg{{ $index }})" stroke="#2a2a2a" stroke-width="1" />
                                            <path d="M75 85 L95 55 Q102 46 115 46 L185 46 Q198 46 205 55 L225 85 Z"
                                                fill="#1e1e1e" stroke="#222" stroke-width="1" />
                                            <path d="M82 84 L98 60 Q103 53 113 53 L148 53 L148 84 Z"
                                                fill="rgba(200,255,0,0.07)" stroke="rgba(200,255,0,0.25)"
                                                stroke-width="0.8" />
                                            <path d="M152 53 L187 53 Q197 53 202 60 L218 84 L152 84 Z"
                                                fill="rgba(200,255,0,0.07)" stroke="rgba(200,255,0,0.25)"
                                                stroke-width="0.8" />
                                            <line x1="150" y1="53" x2="150" y2="84"
                                                stroke="#111" stroke-width="2" />
                                            <path d="M30 85 L45 85 L64 75 L75 85 Z" fill="#1a1a1a" stroke="#222" />
                                            <path d="M225 85 L236 75 L255 85 L270 85 Z" fill="#1a1a1a" stroke="#222" />
                                            <rect x="31" y="78" width="22" height="7" rx="2"
                                                fill="rgba(200,255,0,0.85)" />
                                            <rect x="247" y="78" width="20" height="7" rx="2"
                                                fill="rgba(255,60,60,0.85)" />
                                            <circle cx="78" cy="108" r="20" fill="#111" stroke="#333"
                                                stroke-width="1.5" />
                                            <circle cx="78" cy="108" r="12" fill="#0a0a0a" stroke="#444"
                                                stroke-width="1" />
                                            <circle cx="78" cy="108" r="5" fill="#222"
                                                stroke="rgba(200,255,0,0.4)" stroke-width="1" />
                                            <line x1="78" y1="96" x2="78" y2="120"
                                                stroke="#333" stroke-width="1.5" />
                                            <line x1="66" y1="108" x2="90" y2="108"
                                                stroke="#333" stroke-width="1.5" />
                                            <circle cx="222" cy="108" r="20" fill="#111" stroke="#333"
                                                stroke-width="1.5" />
                                            <circle cx="222" cy="108" r="12" fill="#0a0a0a" stroke="#444"
                                                stroke-width="1" />
                                            <circle cx="222" cy="108" r="5" fill="#222"
                                                stroke="rgba(200,255,0,0.4)" stroke-width="1" />
                                            <line x1="222" y1="96" x2="222" y2="120"
                                                stroke="#333" stroke-width="1.5" />
                                            <line x1="210" y1="108" x2="234" y2="108"
                                                stroke="#333" stroke-width="1.5" />
                                            <line x1="32" y1="93" x2="268" y2="93"
                                                stroke="rgba(200,255,0,0.12)" stroke-width="0.8" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="car-body">
                                <div class="car-category">{{ $car->category->name }} · {{ $car['color'] }}</div>
                                <div class="car-name">{{ $car->model }}</div>
                                <div class="car-specs">
                                    @if ($car->vehicle_type == 'car' && $car->car)
                                        <div class="spec-item">
                                            <i class="bi bi-people-fill"></i> {{ $car->car->capacity }} Kursi
                                        </div>
                                        <div class="spec-item">
                                            <i class="bi bi-gear-fill"></i> {{ $car->car->transmission }}
                                        </div>
                                        <div class="spec-item">
                                            <i class="bi bi-droplet-fill"></i> {{ $car->car->fuel_type }}
                                        </div>
                                    @elseif($car->vehicle_type == 'motorcycle' && $car->motorcycle)
                                        <div class="spec-item">
                                            <i class="bi bi-speedometer2"></i> {{ $car->motorcycle->engine_capacity }} CC
                                        </div>
                                        <div class="spec-item">
                                            <i class="bi bi-gear-fill"></i> {{ $car->motorcycle->transmission }}
                                        </div>
                                        <div class="spec-item">
                                            <i class="bi bi-shield-check"></i>
                                            {{ $car->motorcycle->includes_helmet == 1 ? 'Termasuk Helm' : 'TIdak Termasuk Helm' }}
                                        </div>
                                    @endif
                                </div>
                                <div class="car-footer">
                                    <div class="car-price">
                                        Rp {{ number_format($car->daily_rate, 0, ',', '.') }}
                                        <span>per hari</span>
                                    </div>
                                    <a href="{{ route('detail', $car->id) }}" class="btn-rent">
                                        DETAIL <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5 fade-up">
                <a href="{{ route('category') }}" class="btn-ghost-capstone" style="display: inline-flex;">
                    LIHAT SEMUA KENDARAAN <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ── WHY US ── --}}
    <section class="why-section" id="why">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-tag fade-up">// Keunggulan Kami</div>
                <h2 class="section-title fade-up fade-up-delay-1">MENGAPA MEMILIH<br><span
                        style="color:var(--accent)">CAPSTONE</span>?</h2>
            </div>
            <div class="row g-4">
                @php
                    $features = [
                        [
                            'icon' => 'bi-shield-check',
                            'title' => 'ASURANSI LENGKAP',
                            'desc' =>
                                'Setiap kendaraan dilindungi asuransi komprehensif. Berkendara tenang, kami jamin keamananmu.',
                        ],
                        [
                            'icon' => 'bi-clock-history',
                            'title' => 'BOOKING 24/7',
                            'desc' =>
                                'Reservasi kapan saja, di mana saja. Proses cepat, konfirmasi instan dalam hitungan menit.',
                        ],
                        [
                            'icon' => 'bi-geo-alt-fill',
                            'title' => 'ANTAR JEMPUT',
                            'desc' =>
                                'Layanan jemput dan antar ke lokasi pilihanmu. Bandara, hotel, atau alamat rumahmu.',
                        ],
                        [
                            'icon' => 'bi-star-fill',
                            'title' => 'MOBIL PREMIUM',
                            'desc' =>
                                'Kendaraan terawat dengan perawatan rutin berkala. Selalu bersih, nyaman, dan bertenaga.',
                        ],
                        [
                            'icon' => 'bi-telephone-fill',
                            'title' => 'SUPPORT AKTIF',
                            'desc' =>
                                'Tim CS kami siap membantu 24 jam sehari, 7 hari seminggu. Respons cepat via WA & telepon.',
                        ],
                        [
                            'icon' => 'bi-cash-coin',
                            'title' => 'HARGA TRANSPARAN',
                            'desc' =>
                                'Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar.',
                        ],
                    ];
                @endphp
                @foreach ($features as $i => $f)
                    <div class="col-lg-4 col-md-6 fade-up" style="transition-delay: {{ $i * 0.08 }}s">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi {{ $f['icon'] }}"></i></div>
                            <div class="feature-title">{{ $f['title'] }}</div>
                            <div class="feature-desc">{{ $f['desc'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── HOW IT WORKS ── --}}
    <section class="how-section" id="how">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-5">
                    <div class="section-tag fade-up">// Cara Sewa</div>
                    <h2 class="section-title fade-up fade-up-delay-1">MUDAH DALAM<br>4 LANGKAH</h2>
                </div>
                <div class="col-lg-7 d-flex align-items-end">
                    <p class="section-desc fade-up fade-up-delay-2">
                        Dari pilih kendaraan hingga start mesin—proses pemesanan kami dirancang sesederhana mungkin.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @php
                    $steps = [
                        [
                            'num' => '01',
                            'title' => 'PILIH KENDARAAN',
                            'desc' =>
                                'Jelajahi mobil kami dan pilih kendaraan yang sesuai dengan kebutuhan dan budget Anda.',
                            'icon' => 'bi-car-front',
                        ],
                        [
                            'num' => '02',
                            'title' => 'TENTUKAN JADWAL',
                            'desc' => 'Pilih tanggal mulai, tanggal selesai, dan lokasi jemput yang Anda inginkan.',
                            'icon' => 'bi-calendar-check',
                        ],
                        [
                            'num' => '03',
                            'title' => 'KONFIRMASI BOOKING',
                            'desc' =>
                                'Isi data diri, lakukan pembayaran DP, dan terima konfirmasi booking via email & WA.',
                            'icon' => 'bi-check-circle',
                        ],
                        [
                            'num' => '04',
                            'title' => 'NIKMATI PERJALANAN',
                            'desc' => 'Kendaraan siap di lokasi yang Anda pilih. Gas pol, perjalanan impian dimulai!',
                            'icon' => 'bi-map',
                        ],
                    ];
                @endphp
                @foreach ($steps as $i => $s)
                    <div class="col-lg-3 col-md-6 fade-up" style="transition-delay: {{ $i * 0.1 }}s">
                        <div
                            style="padding: 28px; border: 1px solid var(--border); border-radius: 4px; background: var(--bg-card); height: 100%; position: relative;">
                            <div class="step-num">{{ $s['num'] }}</div>
                            <div
                                style="width: 44px; height: 44px; background: var(--accent-dim); border: 1px solid var(--border-accent); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.2rem; margin-bottom: 16px; margin-top: -8px;">
                                <i class="bi {{ $s['icon'] }}"></i>
                            </div>
                            <div class="step-title">{{ $s['title'] }}</div>
                            <div class="step-desc">{{ $s['desc'] }}</div>
                            @if ($i < 3)
                                <div style="position: absolute; top: 50%; right: -22px; width: 44px; height: 1px; background: linear-gradient(90deg, var(--border-accent), transparent); z-index: 2;"
                                    class="d-none d-lg-block"></div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="testi-section" id="testi">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-tag fade-up">// Ulasan Pelanggan</div>
                <h2 class="section-title fade-up fade-up-delay-1">APA KATA<br>MEREKA?</h2>
            </div>
            <div class="row g-4">
                @php
                    $reviews = [
                        [
                            'init' => 'AR',
                            'name' => 'Andi Rachmat',
                            'role' => 'Business Traveler',
                            'text' =>
                                'Capstone benar-benar mengubah cara saya bepergian untuk bisnis. Mobil selalu bersih, tepat waktu, dan harganya bersaing. Highly recommended!',
                        ],
                        [
                            'init' => 'SR',
                            'name' => 'Siti Rahayu',
                            'role' => 'Family Traveler',
                            'text' =>
                                'Booking mudah banget, CS-nya responsif dan ramah. Mobil diantar tepat waktu ke hotel. Anak-anak senang, liburan keluarga jadi sempurna!',
                        ],
                        [
                            'init' => 'BH',
                            'name' => 'Budi Hartono',
                            'role' => 'Corporate Client',
                            'text' =>
                                'Kami sudah 2 tahun pakai Capstone untuk operasional perusahaan. Profesional, amanah, dan selalu memberikan yang terbaik. Partner terpercaya kami.',
                        ],
                    ];
                @endphp
                @foreach ($reviews as $i => $r)
                    <div class="col-lg-4 fade-up" style="transition-delay: {{ $i * 0.1 }}s">
                        <div class="testi-card">
                            <div class="star-rating">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <div class="testi-quote">"</div>
                            <div class="testi-text">{{ $r['text'] }}</div>
                            <div class="testi-author">
                                <div class="testi-avatar">{{ $r['init'] }}</div>
                                <div>
                                    <div class="testi-name">{{ $r['name'] }}</div>
                                    <div class="testi-role">{{ $r['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── CTA SECTION ── --}}
    <section class="cta-section">
        <div class="cta-bg"></div>
        <div class="container text-center position-relative">
            <div class="section-tag fade-up" style="justify-content: center; display: flex;">// Siap Berangkat?</div>
            <h2 class="cta-title fade-up fade-up-delay-1">
                MULAI<br>PERJALANANMU<br>
                <span class="cta-accent">SEKARANG</span>
            </h2>
            <p class="section-desc fade-up fade-up-delay-2 mx-auto text-center mb-5" style="max-width: 400px;">
                Ribuan pelanggan telah mempercayai Capstone. Giliran Anda merasakan pengalaman berkendara yang
                sesungguhnya.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap fade-up fade-up-delay-3">
                <a href="#booking" class="btn-primary-capstone">PESAN SEKARANG <i class="bi bi-arrow-right ms-2"></i></a>
                <a href="https://wa.me/6281234567890" class="btn-ghost-capstone">
                    <i class="bi bi-whatsapp"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function preventBack() {
            window.history.forward();
        }

        setTimeout("preventBack()", 0);

        window.onunload = function() {
            null
        };
    </script>
@endpush
