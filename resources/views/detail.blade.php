@extends('layouts.app')

@section('title', 'Detail Kendaraan — CAPSTONE Car Rental')

@php
    $detailPage = true;
    $hideFooter = true;
@endphp

@push('styles')
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #0a0a0c;
            --surface: #111115;
            --surface2: #16161c;
            --border: rgba(255, 255, 255, 0.07);
            --border-accent: rgba(200, 255, 0, 0.3);
            --accent: #c8ff00;
            --accent-dim: rgba(200, 255, 0, 0.12);
            --text: #f0f0f0;
            --muted: #8a8a9a;
            --text-muted: #55556a;
            --green: #3cff9a;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 2px;
        }

        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 2rem;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(20px);
        }

        .container-detail {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            /* Memberikan ruang aman di sisi kiri dan kanan */
        }

        .nav-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--text);
            letter-spacing: 0.1em;
            text-decoration: none;
        }

        .nav-brand span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.82rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: color .2s;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-back {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--muted);
            font-size: 0.75rem;
            cursor: pointer;
            transition: all .2s;
            background: none;
            border: 1px solid var(--border);
            font-family: 'Space Mono', monospace;
            letter-spacing: 0.08em;
            padding: 8px 16px;
            border-radius: 2px;
            text-decoration: none;
            text-transform: uppercase;
        }

        .nav-back:hover {
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* LAYOUT */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2.5rem;
            align-items: start;
        }

        /* BREADCRUMB */
        .breadcrumb-velox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-velox a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-velox a:hover {
            color: var(--accent);
        }

        .breadcrumb-velox .sep {
            color: var(--border-accent);
        }

        .breadcrumb-velox .current {
            color: var(--accent);
        }

        main {
            padding-top: 100px;
        }

        /* GALLERY */
        .gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .main-image {
            background: var(--surface2);
            border-radius: 4px;
            border: 1px solid var(--border);
            overflow: hidden;
            position: relative;
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(200, 255, 0, 0.015) 1px, transparent 1px), linear-gradient(90deg, rgba(200, 255, 0, 0.015) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .main-image svg {
            width: 100%;
            height: 100%;
        }

        .badge-status {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--accent);
            color: #000;
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            padding: 4px 12px;
            border-radius: 1px;
            z-index: 2;
        }

        .badge-year {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--border);
            color: var(--muted);
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            padding: 4px 12px;
            border-radius: 1px;
            backdrop-filter: blur(8px);
            z-index: 2;
        }

        .thumbnails {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .thumb {
            background: var(--surface2);
            border-radius: 4px;
            border: 1px solid var(--border);
            aspect-ratio: 4/3;
            overflow: hidden;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color .2s;
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .thumb:hover,
        .thumb.active {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .stat-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .stat-label {
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            color: var(--muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            letter-spacing: 0.05em;
            color: var(--text);
        }

        .stat-icon {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            color: var(--accent);
        }

        /* INFO PANEL */
        .info-panel {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .brand-tag {
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: var(--accent);
            text-transform: uppercase;
        }

        h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            line-height: 0.95;
            letter-spacing: 0.03em;
            color: var(--text);
            margin-top: 0.3rem;
        }

        h1 span {
            color: var(--muted);
        }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .price-main {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            letter-spacing: 0.03em;
            color: var(--text);
        }

        .price-sub {
            color: var(--muted);
            font-size: 0.8rem;
        }

        .price-old {
            color: var(--muted);
            font-size: 1rem;
            text-decoration: line-through;
        }

        .price-badge {
            background: var(--accent-dim);
            color: var(--accent);
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 1px;
            border: 1px solid var(--border-accent);
        }

        .rating-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }

        .stars {
            color: var(--accent);
            font-size: 0.9rem;
        }

        .rating-num {
            font-family: 'Space Mono', monospace;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .rating-count {
            color: var(--muted);
            font-size: 0.78rem;
        }

        .status-available {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            padding: 4px 10px;
            background: rgba(0, 200, 80, 0.1);
            border: 1px solid rgba(0, 200, 80, 0.3);
            color: #00c850;
            border-radius: 1px;
        }

        .status-available::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #00c850;
        }

        .status-unavailable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            padding: 4px 10px;
            background: rgba(200, 33, 0, 0.1);
            border: 1px solid rgba(200, 33, 0, 0.1);
            color: #c80000;
            border-radius: 1px;
        }

        .status-unavailable::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #c80000;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
        }

        /* TABS */
        .tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
        }

        .tab {
            padding: 0.6rem 1.25rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            cursor: pointer;
            border: none;
            background: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: all .2s;
        }

        .tab.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .tab:hover:not(.active) {
            color: var(--text);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .spec-list {
            display: flex;
            flex-direction: column;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border);
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-key {
            color: var(--muted);
            font-size: 0.82rem;
        }

        .spec-val {
            font-weight: 500;
            color: var(--text);
            font-size: 0.82rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.8rem;
            color: var(--muted);
            padding: 0.3rem 0;
        }

        .feature-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }

        /* DEALER */
        .dealer-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dealer-avatar {
            width: 44px;
            height: 44px;
            border-radius: 2px;
            background: var(--accent-dim);
            border: 1px solid var(--border-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--accent);
            flex-shrink: 0;
        }

        .dealer-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .dealer-loc {
            color: var(--muted);
            font-size: 0.75rem;
            margin-top: 2px;
        }

        .dealer-verified {
            color: var(--green);
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.08em;
            margin-top: 4px;
        }

        /* ACTIONS */
        .actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-primary {
            background: var(--accent);
            color: #000;
            font-family: 'Space Mono', monospace;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            border: none;
            border-radius: 2px;
            padding: 1rem 1.5rem;
            cursor: pointer;
            text-transform: uppercase;
            transition: opacity .2s, transform .1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .btn-primary:disabled {
            background: var(--border);
            color: rgba(255, 255, 255, 0.3);
            cursor: not-allowed;
            opacity: 0.6;
            transform: none !important;
            pointer-events: none;
        }

        .btn-secondary {
            background: transparent;
            color: var(--text);
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            border-radius: 2px;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex: 1;
        }

        .btn-secondary:hover {
            border-color: rgba(255, 255, 255, 0.2);
            background: var(--surface2);
        }

        .btn-row {
            display: flex;
            gap: 0.75rem;
        }

        .btn-icon {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 2px;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color .2s;
            color: var(--muted);
            font-size: 1.1rem;
        }

        .btn-icon:hover {
            border-color: rgba(255, 255, 255, 0.2);
            color: var(--text);
        }

        .btn-icon.saved {
            color: var(--accent);
            border-color: var(--border-accent);
        }

        /* SIMILAR */
        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.05em;
            color: var(--text);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .similar-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .similar-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: all .3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .similar-card:hover {
            border-color: var(--border-accent);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .similar-img {
            aspect-ratio: 4/3;
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .similar-img svg {
            width: 100%;
            height: 100%;
        }

        .similar-info {
            padding: 0.85rem;
        }

        .similar-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 0.03em;
            color: var(--text);
        }

        .similar-price {
            color: var(--accent);
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            margin-top: 4px;
            letter-spacing: 0.05em;
        }

        .similar-meta {
            color: var(--muted);
            font-size: 0.72rem;
            margin-top: 2px;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .similar-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .thumbnails {
                grid-template-columns: repeat(3, 1fr);
            }

            h1 {
                font-size: 2.2rem;
            }

            nav {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }

            .similar-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="breadcrumb-velox">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="sep">/</span>
            <a href="{{ route('category') }}">Semua Kendaraan</a>
            <span class="sep">/</span>
            <span>{{ $vehicle->category->name }}</span>
            <span class="sep">/</span>
            <span class="current">{{ $vehicle->model }}</span>
        </div>

        <div class="grid">
            <div class="gallery">
                <div class="image-gallery-wrapper">
                    <div class="main-image"
                        style="position: relative; width: 100%; aspect-ratio: 800 / 450; background: #111115; border-radius: 12px; overflow: hidden;">

                        <img id="featuredImage" src="" alt="{{ $vehicle->model }}"
                            style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; z-index: 2;">

                        <svg id="placeholderSvg" viewBox="0 0 800 450" xmlns="http://www.w3.org/2000/svg"
                            style="position:absolute;inset:0;width:100%;height:100%; z-index: 1;">
                            <rect width="800" height="450" fill="#111115" />
                            <ellipse cx="400" cy="380" rx="280" ry="18" fill="rgba(0,0,0,0.5)" />
                            <rect x="110" y="220" width="580" height="130" rx="12" fill="#1a1a22" />
                            <path d="M210,220 L260,140 L540,140 L590,220 Z" fill="#1e1e28" />
                            <path d="M535,220 L560,155 L540,140 L490,220 Z" fill="#1e2a40" opacity="0.9" />
                            <path d="M265,220 L260,140 L300,140 L310,220 Z" fill="#1e2a40" opacity="0.9" />
                            <rect x="315" y="150" width="175" height="65" rx="4" fill="#1a2638"
                                opacity="0.95" />
                            <line x1="400" y1="150" x2="400" y2="350"
                                stroke="rgba(255,255,255,0.04)" stroke-width="1" />
                            <line x1="490" y1="150" x2="490" y2="350"
                                stroke="rgba(255,255,255,0.04)" stroke-width="1" />
                            <path d="M650,240 L690,248 L690,278 L650,285 Z" fill="#141419" />
                            <path d="M655,248 L682,254 L682,272 L655,278 Z" fill="#c8ff00" opacity="0.7" />
                            <rect x="655" y="290" width="40" height="30" rx="4" fill="#0e0e12" />
                            <line x1="665" y1="295" x2="665" y2="315" stroke="#222228"
                                stroke-width="1" />
                            <line x1="675" y1="295" x2="675" y2="315" stroke="#222228"
                                stroke-width="1" />
                            <line x1="685" y1="295" x2="685" y2="315" stroke="#222228"
                                stroke-width="1" />
                            <path d="M110,255 L120,248 L120,285 L110,278 Z" fill="#141419" />
                            <rect x="110" y="255" width="12" height="30" rx="2" fill="#cc2222"
                                opacity="0.8" />
                            <rect x="655" y="320" width="48" height="25" rx="6" fill="#0e1014" />
                            <rect x="100" y="320" width="48" height="25" rx="6" fill="#0e1014" />
                            <circle cx="230" cy="355" r="48" fill="#080809" />
                            <circle cx="230" cy="355" r="42" fill="#141419" />
                            <circle cx="230" cy="355" r="26" fill="#0e0e12" />
                            <circle cx="230" cy="355" r="20" fill="#161620" />
                            <line x1="230" y1="335" x2="230" y2="375" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="210" y1="355" x2="250" y2="355" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="216" y1="341" x2="244" y2="369" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="244" y1="341" x2="216" y2="369" stroke="#1e2030"
                                stroke-width="3" />
                            <circle cx="230" cy="355" r="6" fill="#c8ff00" opacity="0.4" />
                            <circle cx="570" cy="355" r="48" fill="#080809" />
                            <circle cx="570" cy="355" r="42" fill="#141419" />
                            <circle cx="570" cy="355" r="26" fill="#0e0e12" />
                            <circle cx="570" cy="355" r="20" fill="#161620" />
                            <line x1="570" y1="335" x2="570" y2="375" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="550" y1="355" x2="590" y2="355" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="556" y1="341" x2="584" y2="369" stroke="#1e2030"
                                stroke-width="3" />
                            <line x1="584" y1="341" x2="556" y2="369" stroke="#1e2030"
                                stroke-width="3" />
                            <circle cx="570" cy="355" r="6" fill="#c8ff00" opacity="0.4" />
                            <rect x="270" y="136" width="260" height="6" rx="3" fill="#222230" />
                            <line x1="110" y1="295" x2="695" y2="295"
                                stroke="rgba(200,255,0,0.12)" stroke-width="1.5" />
                            <text x="400" y="418" text-anchor="middle" font-family="monospace" font-size="11"
                                fill="rgba(255,255,255,0.1)" letter-spacing="6">
                                {{ strtoupper($vehicle->model) }}
                            </text>
                        </svg>

                        <div class="badge-status" style="position: absolute; top: 15px; left: 15px; z-index: 3;">
                            {{ $vehicle->status }}</div>
                        <div class="badge-year" style="position: absolute; top: 15px; right: 15px; z-index: 3;">
                            {{ $vehicle->year }}</div>
                    </div>

                    <div class="thumbnails">
                        <div class="thumb active" data-src="{{ $vehicle->images_gallery['samping'] }}">SAMPING</div>
                        <div class="thumb" data-src="{{ $vehicle->images_gallery['depan'] }}">DEPAN</div>
                        <div class="thumb" data-src="{{ $vehicle->images_gallery['interior'] }}">INTERIOR</div>
                        <div class="thumb" data-src="{{ $vehicle->images_gallery['mesin'] }}">MESIN</div>
                    </div>
                </div>

            </div>

            <div class="info-panel">
                <div>
                    <div class="brand-tag">{{ $vehicle->category->name }}</div>
                    <h1>{{ $vehicle->model }}</h1>
                    <div class="rating-row">
                        @php
                            $fullStars = floor($rating);
                            $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                        @endphp
                        <div class="stars">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                            @if ($halfStar)
                                <i class="bi bi-star-half"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="bi bi-star"></i>
                            @endfor
                            <span class="rating-num">{{ number_format($rating, 1) }}</span>
                        </div>
                        <span class="rating-num">{{ $rating }}</span>
                        <span class="rating-count">({{ $total_ulasan }} ulasan)</span>
                        <div class="{{ $vehicle->status == 'available' ? 'status-available' : 'status-unavailable' }}">
                            {{ $vehicle->status }}</div>
                    </div>
                </div>

                <div>
                    <div class="price-row">
                        <div class="price-main">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</div>
                        @if (isset($hargaLama) && $vehicle->daily_rate < $hargaLama)
                            <div class="price-old">Rp {{ number_format($hargaLama, 0, ',', '.') }}</div>
                            <div class="price-badge">
                                -{{ round((($hargaLama - $vehicle->daily_rate) / $hargaLama) * 100) }}%</div>
                        @endif
                    </div>
                    <div class="price-sub" style="margin-top:6px;">per hari · Termasuk asuransi dasar</div>
                </div>

                <hr class="divider">

                {{-- TABS --}}
                <div>
                    <div class="tabs">
                        <button class="tab active" onclick="switchTab('spek', this)">Spesifikasi</button>
                        <button class="tab" onclick="switchTab('fitur', this)">Fitur</button>
                    </div>

                    <div id="tab-spek" class="tab-content active" style="padding-top:0.75rem;">
                        <div class="spec-list">
                            <div class="spec-row"><span class="spec-key">Tahun</span><span
                                    class="spec-val">{{ $vehicle->year }}</span>
                            </div>
                            <div class="spec-row"><span class="spec-key">Warna</span><span
                                    class="spec-val">{{ $vehicle->color }}</span></div>
                            <div class="spec-row"><span class="spec-key">Tipe</span><span
                                    class="spec-val">{{ $vehicle->category->name }}
                                </span></div>
                            @if ($vehicle->vehicle_type == 'car')
                                <div class="spec-row"><span class="spec-key">Kapasitas</span><span
                                        class="spec-val">{{ $vehicle->car->capacity }}
                                        Penumpang</span></div>
                                <div class="spec-row"><span class="spec-key">Jenis Bahan Bakar</span><span
                                        class="spec-val">{{ $vehicle->car->fuel_type }}</span></div>
                            @else
                                <div class="spec-row"><span class="spec-key">Kapasitas CC</span><span
                                        class="spec-val">{{ $vehicle->motorcycle->engine_capacity }}
                                        cc</span></div>
                                <div class="spec-row"><span class="spec-key">Kapasitas CC</span><span
                                        class="spec-val">{{ $vehicle->motorcycle->includes_helmet == 1 ? 'Termasuk Helm' : 'Tidak Termasuk Helm' }}
                                    </span></div>
                            @endif
                        </div>
                    </div>

                    <div id="tab-fitur" class="tab-content" style="padding-top:0.75rem;">
                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-dot"></div>Apple CarPlay / AA
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Kamera 360°
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Sunroof Panoramik
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Kursi Kulit Premium
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Keyless Entry
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Push Start Button
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Lane Departure Alert
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Pre-Collision System
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Blind Spot Monitor
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Adaptive Cruise Control
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Ventilated Front Seat
                            </div>
                            <div class="feature-item">
                                <div class="feature-dot"></div>Ambient Lighting
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="divider">

                <div class="dealer-card">
                    <div class="dealer-avatar">CS</div>
                    <div style="flex:1;">
                        <div class="dealer-name">CAPSTONE Rental Center</div>
                        <div class="dealer-loc"><i class="bi bi-geo-alt-fill"
                                style="color:var(--accent);font-size:0.7rem"></i> Sidoarjo, Jawa Timur</div>
                        <div class="dealer-verified"><i class="bi bi-patch-check-fill"></i> DEALER TERVERIFIKASI ·
                            RESPONS CEPAT</div>
                    </div>

                </div>

                <div class="actions">
                    <form action="{{ route('pembayaran') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <button type="submit" class="btn-primary" id="bookingBtn" style="border: none; width: 100%;"
                            data-auth="{{ Auth::check() ? 'true' : 'false' }}"
                            {{ $vehicle->status == 'available' ? '' : 'disabled' }}>
                            <i class="bi bi-calendar2-check"></i> PESAN SEKARANG
                        </button>
                    </form>
                    <div class="btn-row">
                        <button class="btn-secondary">
                            <i class="bi bi-chat-dots"></i> Hubungi Dealer
                        </button>
                        <button class="btn-icon {{ $isSaved ? 'saved' : '' }}" id="saveBtn" title="Simpan"
                            data-id="{{ $vehicle->id }}">
                            <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                        <button class="btn-icon" id="shareBtn" title="Bagikan"
                            data-title="Sewa {{ $vehicle->name }} - CAPSTONE" data-url="{{ url()->current() }}">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- SIMILAR VEHICLES --}}
        <div style="margin-top:3.5rem;">
            <div class="section-title">Kendaraan Serupa</div>
            <div class="similar-grid">
                @foreach ($similar_vehicles as $vehicle)
                    <a href="{{ route('detail', $vehicle->id) }}" class="similar-card">
                        <div class="similar-img"
                            style="position: relative; width: 100%; aspect-ratio: 300 / 200; overflow: hidden; background: #111115;">

                            @if ($vehicle->image_front)
                                <img src="{{ $vehicle->image_front }}" alt="{{ $vehicle->model }}"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; z-index: 2;">
                            @else
                                <svg viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg"
                                    style="width:100%;height:100%; position: absolute; inset: 0; z-index: 1;">
                                    <rect width="300" height="200" fill="#111115" />
                                    <ellipse cx="150" cy="170" rx="120" ry="12"
                                        fill="rgba(0,0,0,0.4)" />
                                    <rect x="30" y="100" width="240" height="65" rx="10" fill="#1a1a22" />
                                    <path d="M65,100 L82,68 L218,68 L235,100 Z" fill="#1e1e28" />
                                    <circle cx="75" cy="168" r="22" fill="#0a0a0c" stroke="#222230"
                                        stroke-width="2" />
                                    <circle cx="75" cy="168" r="14" fill="#111115" />
                                    <circle cx="225" cy="168" r="22" fill="#0a0a0c" stroke="#222230"
                                        stroke-width="2" />
                                    <circle cx="225" cy="168" r="14" fill="#111115" />
                                </svg>
                            @endif

                        </div>
                        <div class="similar-info">
                            <div class="similar-name">{{ $vehicle->model }}</div>
                            <div class="similar-price">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }} / hari
                            </div>

                            @if ($vehicle->vehicle_type == 'car')
                                <div class="similar-meta">
                                    {{ $vehicle->category->name }} · {{ $vehicle->car->capacity ?? 0 }} Kursi ·
                                    {{ $vehicle->car->fuel_type ?? '-' }}
                                </div>
                            @else
                                <div class="similar-meta">
                                    {{ $vehicle->category->name }} · {{ $vehicle->motorcycle->engine_capacity ?? 0 }} CC
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginAlertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center py-4 px-3"
                style="background: #111114; border: 1px solid var(--border); border-radius: 4px;">
                <div class="modal-body">
                    <div class="mb-3" style="color: #ff3366; font-size: 2.5rem;">
                        <i class="bi bi-lock-fill"></i>
                    </div>

                    <h5 class="text-white font-weight-bold mb-2"
                        style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em; font-size: 1.5rem;">
                        AKSES TERBATAS
                    </h5>
                    <p class="text-secondary small mb-4">
                        Login terlebih dahulu untuk bisa menggunakan fitur ini.
                    </p>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="btn-nav w-100 py-2 text-center text-decoration-none"
                            style="display: block;">
                            LOGIN SEKARANG
                        </a>
                        <button type="button" class="btn btn-sm text-secondary w-100" data-bs-dismiss="modal"
                            style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            Nanti Saja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTab(id, btn) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + id).classList.add('active');
            btn.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const thumbs = document.querySelectorAll('.thumb');
            const featuredImage = document.getElementById('featuredImage');
            const placeholderSvg = document.getElementById('placeholderSvg');

            function changeMainImage(element) {
                const imageSrc = element.getAttribute('data-src');
                thumbs.forEach(x => x.classList.remove('active'));
                element.classList.add('active');
                if (imageSrc && imageSrc.trim() !== "") {
                    featuredImage.src = imageSrc;
                    featuredImage.style.display = "block";
                } else {
                    featuredImage.style.display = "none";
                }
            }

            thumbs.forEach(t => {
                t.addEventListener('click', function() {
                    changeMainImage(this);
                });
            });

            const initialActiveThumb = document.querySelector('.thumb.active');
            if (initialActiveThumb) {
                changeMainImage(initialActiveThumb);
            }
            const saveBtn = document.getElementById('saveBtn');
            if (saveBtn) {
                saveBtn.addEventListener('click', function() {
                    const vehicleId = this.getAttribute('data-id');
                    const icon = this.querySelector('i');

                    fetch(`/vehicle/${vehicleId}/wishlist`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.status === 401) {
                                const loginModal = new bootstrap.Modal(document.getElementById(
                                    'loginAlertModal'));
                                loginModal.show();
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;

                            if (data.status === 'added') {
                                this.classList.add('saved');
                                icon.classList.replace('bi-heart', 'bi-heart-fill');
                            } else if (data.status === 'removed') {
                                this.classList.remove('saved');
                                icon.classList.replace('bi-heart-fill', 'bi-heart');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            }

            const shareBtn = document.getElementById('shareBtn');
            if (shareBtn) {
                shareBtn.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const url = this.getAttribute('data-url');
                    if (navigator.share) {
                        navigator.share({
                                title: title,
                                text: 'Cek kendaraan keren ini di CAPSTONE Rental!',
                                url: url
                            })
                            .then(() => console.log('Berhasil membagikan!'))
                            .catch((error) => console.log('Gagal membagikan:', error));
                    } else {
                        navigator.clipboard.writeText(url);
                        alert('Link berhasil disalin ke clipboard! Siap dibagikan.');
                    }
                });
            }

            const bookingForm = document.getElementById('bookingForm');
            const bookingBtn = document.getElementById('bookingBtn');
            if (bookingForm && bookingBtn) {
                bookingForm.addEventListener('submit', function(e) {
                    const isAuthorized = bookingBtn.getAttribute('data-auth') === 'true';

                    if (!isAuthorized) {
                        e.preventDefault();
                        const loginModal = new bootstrap.Modal(document.getElementById('loginAlertModal'));
                        loginModal.show();
                    }
                });
            }
        });
    </script>
@endpush
