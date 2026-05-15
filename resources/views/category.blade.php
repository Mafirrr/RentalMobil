<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Kendaraan — CAPSTONE Car Rental</title>
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
            --accent-dim: rgba(200,255,0,0.12);
            --accent-glow: rgba(200,255,0,0.35);
            --text-primary: #f0f0f0;
            --text-secondary: #8a8a9a;
            --text-muted: #55556a;
            --border: rgba(255,255,255,0.07);
            --border-accent: rgba(200,255,0,0.3);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'DM Sans', sans-serif; background-color: var(--bg-base); color: var(--text-primary); overflow-x: hidden; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 2px; }

        /* NAVBAR */
        .navbar-capstone {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            padding: 20px 0; transition: all 0.4s ease;
            background: rgba(10,10,12,0.92); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .nav-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--text-primary) !important; letter-spacing: 0.1em; text-decoration: none; }
        .nav-brand span { color: var(--accent); }
        .nav-link-capstone { color: var(--text-secondary) !important; font-size: 0.82rem; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; text-decoration: none; transition: color 0.2s; }
        .nav-link-capstone:hover { color: var(--accent) !important; }
        .btn-nav { font-family: 'Space Mono', monospace; font-size: 0.75rem; letter-spacing: 0.08em; padding: 9px 22px; border: 1px solid var(--accent); color: var(--accent); background: transparent; border-radius: 2px; transition: all 0.25s; text-decoration: none; }
        .btn-nav:hover { background: var(--accent); color: #000; }
        .btn-nav-login { font-family: 'Space Mono', monospace; font-size: 0.75rem; letter-spacing: 0.08em; padding: 9px 20px; border: 1px solid var(--border); color: var(--text-secondary); background: transparent; border-radius: 2px; transition: all 0.25s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-nav-login:hover { border-color: var(--text-secondary); color: var(--text-primary); }

        /* PAGE HEADER */
        .page-header { padding: 140px 0 60px; background: var(--bg-base); position: relative; overflow: hidden; }
        .page-header::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(200,255,0,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(200,255,0,0.025) 1px, transparent 1px); background-size: 60px 60px; pointer-events: none; }
        .page-header-orb { position: absolute; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,255,0,0.06) 0%, transparent 70%); filter: blur(100px); top: -100px; right: -50px; pointer-events: none; }
        .breadcrumb-velox { display: flex; align-items: center; gap: 8px; font-family: 'Space Mono', monospace; font-size: 0.68rem; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 20px; }
        .breadcrumb-velox a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
        .breadcrumb-velox a:hover { color: var(--accent); }
        .breadcrumb-velox .sep { color: var(--border-accent); }
        .breadcrumb-velox .current { color: var(--accent); }
        .page-title { font-family: 'Bebas Neue', sans-serif; font-size: clamp(3rem, 6vw, 5.5rem); line-height: 0.95; letter-spacing: 0.03em; color: var(--text-primary); margin-bottom: 16px; }
        .page-title span { color: var(--accent); }
        .page-subtitle { font-size: 0.95rem; color: var(--text-secondary); line-height: 1.75; max-width: 500px; }
        .vehicle-count-badge { display: inline-flex; align-items: center; gap: 8px; font-family: 'Space Mono', monospace; font-size: 0.7rem; letter-spacing: 0.12em; padding: 6px 14px; background: var(--accent-dim); border: 1px solid var(--border-accent); border-radius: 2px; color: var(--accent); margin-top: 20px; }

        /* FILTER BAR */
        .filter-bar { background: var(--bg-surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 20px 0; position: sticky; top: 65px; z-index: 100; }
        .filter-tabs { display: flex; gap: 4px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 3px; padding: 4px; }
        .filter-tab { font-family: 'Space Mono', monospace; font-size: 0.7rem; letter-spacing: 0.1em; padding: 8px 18px; border: none; background: transparent; color: var(--text-muted); border-radius: 2px; cursor: pointer; transition: all 0.2s; text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
        .filter-tab.active { background: var(--accent); color: #000; font-weight: 700; }
        .filter-tab:not(.active):hover { color: var(--text-primary); background: rgba(255,255,255,0.05); }
        .filter-select { font-family: 'Space Mono', monospace; font-size: 0.7rem; letter-spacing: 0.08em; padding: 8px 14px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 2px; color: var(--text-secondary); cursor: pointer; text-transform: uppercase; transition: border-color 0.2s; appearance: none; padding-right: 30px; }
        .filter-select:focus { outline: none; border-color: var(--accent); }
        .search-input-category { font-family: 'DM Sans', sans-serif; font-size: 0.88rem; padding: 9px 16px 9px 38px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 2px; color: var(--text-primary); width: 220px; transition: all 0.2s; }
        .search-input-category:focus { outline: none; border-color: var(--accent); width: 260px; }
        .search-input-category::placeholder { color: var(--text-muted); }
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem; pointer-events: none; }

        /* SECTION DIVIDER */
        .section-divider { display: flex; align-items: center; gap: 16px; margin: 48px 0 32px; }
        .section-divider-line { flex: 1; height: 1px; background: var(--border); }
        .section-divider-label { font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 0.15em; color: var(--text-muted); display: flex; align-items: center; gap: 10px; white-space: nowrap; }
        .section-divider-label i { color: var(--accent); font-size: 1rem; }
        .section-divider-count { font-family: 'Space Mono', monospace; font-size: 0.65rem; padding: 3px 8px; background: var(--accent-dim); border: 1px solid var(--border-accent); border-radius: 2px; color: var(--accent); }

        /* VEHICLE CARDS */
        .vehicle-grid { padding: 40px 0 80px; }
        .card-link { text-decoration: none; color: inherit; display: block; height: 100%; cursor: pointer; }
        .car-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; transition: all 0.35s ease; position: relative; height: 100%; }
        .car-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--accent); transform: scaleX(0); transform-origin: left; transition: transform 0.35s ease; }
        .card-link:hover .car-card { border-color: var(--border-accent); background: var(--bg-card-hover); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(0,0,0,0.4); }
        .card-link:hover .car-card::before { transform: scaleX(1); }
        .motor-card::before { background: #00d4ff; }
        .card-link:hover .motor-card { border-color: rgba(0,212,255,0.3); }
        .motor-card .car-badge { background: #00d4ff; color: #000; }
        .motor-card .btn-rent { border-color: #00d4ff; color: #00d4ff; }
        .card-link:hover .motor-card .btn-rent { background: #00d4ff; color: #000; }
        .car-img-wrap { background: var(--bg-surface); padding: 28px; position: relative; overflow: hidden; height: 175px; display: flex; align-items: center; justify-content: center; }
        .car-img-wrap::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: linear-gradient(transparent, var(--bg-card)); pointer-events: none; }
        .car-badge { position: absolute; top: 14px; left: 14px; font-family: 'Space Mono', monospace; font-size: 0.58rem; letter-spacing: 0.12em; padding: 4px 9px; background: var(--accent); color: #000; border-radius: 1px; font-weight: 700; z-index: 2; }
        .avail-badge { position: absolute; top: 14px; right: 14px; font-family: 'Space Mono', monospace; font-size: 0.55rem; letter-spacing: 0.1em; padding: 3px 8px; border-radius: 1px; font-weight: 700; z-index: 2; display: flex; align-items: center; gap: 4px; }
        .avail-badge.available { background: rgba(0,200,80,0.15); border: 1px solid rgba(0,200,80,0.4); color: #00c850; }
        .avail-badge.booked { background: rgba(255,80,80,0.12); border: 1px solid rgba(255,80,80,0.3); color: #ff6060; }
        .avail-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; display: inline-block; }
        .car-body { padding: 20px 22px 24px; }
        .car-category { font-size: 0.67rem; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px; }
        .car-name { font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; letter-spacing: 0.04em; color: var(--text-primary); margin-bottom: 14px; line-height: 1; }
        .car-specs { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--border); }
        .spec-item { display: flex; align-items: center; gap: 5px; font-size: 0.75rem; color: var(--text-secondary); }
        .spec-item i { color: var(--accent); font-size: 0.8rem; }
        .car-footer { display: flex; align-items: center; justify-content: space-between; }
        .car-price { line-height: 1; }
        .price-amount { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--text-primary); }
        .price-label { font-family: 'DM Sans', sans-serif; font-size: 0.68rem; color: var(--text-muted); letter-spacing: 0.05em; display: block; margin-top: 2px; }
        .btn-rent { font-family: 'Space Mono', monospace; font-size: 0.68rem; letter-spacing: 0.08em; padding: 9px 16px; border: 1px solid var(--accent); color: var(--accent); background: transparent; border-radius: 2px; transition: all 0.2s; display: flex; align-items: center; gap: 6px; white-space: nowrap; }
        .card-link:hover .btn-rent { background: var(--accent); color: #000; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 80px 20px; display: none; }
        .empty-state i { font-size: 3rem; color: var(--text-muted); margin-bottom: 16px; }
        .empty-state p { color: var(--text-secondary); font-size: 0.9rem; }

        /* FADE UP */
        .fade-up { opacity: 0; transform: translateY(24px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        .result-info { font-family: 'Space Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; color: var(--text-muted); text-transform: uppercase; }
        .result-info span { color: var(--accent); }

        @media (max-width: 768px) {
            .filter-bar .d-flex { flex-wrap: wrap; gap: 8px !important; }
            .search-input-category { width: 100%; }
            .filter-tabs { width: 100%; }
            .filter-tab { flex: 1; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-capstone" id="navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="nav-brand">CAP<span>STONE</span></a>
            <div class="d-none d-lg-flex align-items-center gap-4">
                <a href="index.html#category" class="nav-link-capstone">Mobil</a>
                <a href="index.html#why" class="nav-link-capstone">Layanan</a>
                <a href="index.html#how" class="nav-link-capstone">Cara Sewa</a>
                <a href="index.html#testi" class="nav-link-capstone">Ulasan</a>
            </div>
            <div class="d-none d-md-flex align-items-center gap-2">
                <a href="login.html" class="btn-nav-login"><i class="bi bi-person"></i> LOGIN</a>
                <a href="index.html#booking" class="btn-nav">PESAN SEKARANG</a>
            </div>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="page-header-orb"></div>
    <div class="container position-relative">
        <div class="breadcrumb-velox">
            <a href="index.html">Beranda</a>
            <span class="sep">/</span>
            <span class="current">Semua Kendaraan</span>
        </div>
        <h1 class="page-title">SEMUA<br><span>KENDARAAN</span></h1>
        <p class="page-subtitle">Temukan kendaraan yang sempurna untuk setiap perjalananmu. Mobil premium dan motor tangguh tersedia dengan harga terbaik.</p>
        <div class="vehicle-count-badge">
            <i class="bi bi-collection-fill"></i>
            <span id="totalCount">16 Kendaraan Tersedia</span>
        </div>
    </div>
</section>

<!-- FILTER BAR -->
<div class="filter-bar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all"><i class="bi bi-grid-3x3-gap"></i> Semua</button>
                    <button class="filter-tab" data-filter="mobil"><i class="bi bi-car-front"></i> Mobil</button>
                    <button class="filter-tab" data-filter="motor"><i class="bi bi-bicycle"></i> Motor</button>
                </div>
                <div style="position:relative">
                    <select class="filter-select" id="categoryFilter">
                        <option value="">Semua Kategori</option>
                        <option value="City Car">City Car</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Luxury">Luxury</option>
                        <option value="Sport">Sport</option>
                        <option value="Matic">Motor Matic</option>
                        <option value="Trail">Motor Trail</option>
                    </select>
                    <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.7rem;pointer-events:none"></i>
                </div>
                <div style="position:relative">
                    <select class="filter-select" id="sortFilter">
                        <option value="default">Urutkan</option>
                        <option value="price-asc">Harga Terendah</option>
                        <option value="price-desc">Harga Tertinggi</option>
                        <option value="name-asc">Nama A–Z</option>
                    </select>
                    <i class="bi bi-chevron-down" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.7rem;pointer-events:none"></i>
                </div>
            </div>
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input-category" id="searchInput" placeholder="Cari kendaraan...">
            </div>
        </div>
    </div>
</div>

<!-- VEHICLE GRID -->
<div class="vehicle-grid">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="result-info">Menampilkan <span id="visibleCount">16</span> kendaraan</div>
        </div>

        <!-- MOBIL SECTION -->
        <div class="section-divider" id="mobilDivider">
            <div class="section-divider-line"></div>
            <div class="section-divider-label"><i class="bi bi-car-front-fill"></i> MOBIL <span class="section-divider-count" id="mobilCount">10</span></div>
            <div class="section-divider-line"></div>
        </div>

        <div class="row g-4" id="mobilGrid">

            <!-- Yaris -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="City Car" data-name="toyota yaris" data-price="350000" style="transition-delay:0s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">TERLARIS</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc0" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 78 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 78 Z" fill="url(#mc0)" stroke="#282828" stroke-width="1"/><path d="M70 78 L88 50 Q95 42 107 42 L173 42 Q185 42 192 50 L210 78 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">City Car · Putih Pearl</div>
                            <div class="car-name">Toyota Yaris</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 5 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 350.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Fortuner -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="SUV" data-name="fortuner vrz" data-price="750000" style="transition-delay:0.06s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">POPULER</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 75 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 75 Z" fill="url(#mc1)" stroke="#282828" stroke-width="1"/><path d="M68 75 L90 44 Q98 38 112 38 L170 38 Q184 38 192 44 L212 75 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">SUV · Hitam Metalik</div>
                            <div class="car-name">Fortuner VRZ</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 7 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Diesel</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 750.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- BMW -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="Sedan" data-name="bmw 320i" data-price="1200000" style="transition-delay:0.12s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">PREMIUM</span>
                            <span class="avail-badge booked">DIPESAN</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 80 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 80 Z" fill="url(#mc2)" stroke="#282828" stroke-width="1"/><path d="M72 80 L92 55 Q100 48 114 48 L168 48 Q182 48 188 55 L208 80 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Sedan · Abu Titanium</div>
                            <div class="car-name">BMW 320i</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 5 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 1.200.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent opacity-50">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Innova Zenix -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="MPV" data-name="innova zenix" data-price="600000" style="transition-delay:0.18s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">BARU</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 76 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 76 Z" fill="url(#mc3)" stroke="#282828" stroke-width="1"/><path d="M66 76 L86 46 Q94 40 108 40 L174 40 Q188 40 194 46 L214 76 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">MPV · Silver</div>
                            <div class="car-name">Innova Zenix</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 7 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Hybrid</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 600.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Brio -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="City Car" data-name="honda brio" data-price="250000" style="transition-delay:0.24s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">HEMAT</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 78 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 78 Z" fill="url(#mc4)" stroke="#282828" stroke-width="1"/><path d="M70 78 L88 50 Q95 42 107 42 L173 42 Q185 42 192 50 L210 78 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">City Car · Merah</div>
                            <div class="car-name">Honda Brio</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 5 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Manual</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 250.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Alphard -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="Luxury" data-name="alphard hev" data-price="1800000" style="transition-delay:0.30s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">EKSKLUSIF</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc5" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#2a2a2a"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M25 74 L25 94 Q25 101 32 101 L248 101 Q255 101 255 94 L255 74 Z" fill="url(#mc5)" stroke="#282828" stroke-width="1"/><path d="M65 74 L82 48 Q90 42 104 42 L176 42 Q190 42 198 48 L215 74 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="21" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="21" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Luxury · Putih Pearl</div>
                            <div class="car-name">Alphard HEV</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 7 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Hybrid</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 1.800.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- CRV -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="SUV" data-name="honda cr-v turbo" data-price="680000" style="transition-delay:0.36s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">SPORTY</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc6" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 75 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 75 Z" fill="url(#mc6)" stroke="#282828" stroke-width="1"/><path d="M68 75 L90 44 Q98 38 112 38 L170 38 Q184 38 192 44 L212 75 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">SUV · Sonic Grey</div>
                            <div class="car-name">Honda CR-V Turbo</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 5 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 680.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Xpander -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="MPV" data-name="xpander cross" data-price="520000" style="transition-delay:0.42s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">KELUARGA</span>
                            <span class="avail-badge booked">DIPESAN</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc7" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 76 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 76 Z" fill="url(#mc7)" stroke="#282828" stroke-width="1"/><path d="M66 76 L86 46 Q94 40 108 40 L174 40 Q188 40 194 46 L214 76 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="20" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">MPV · Putih</div>
                            <div class="car-name">Xpander Cross</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 7 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 520.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent opacity-50">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Agya -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="City Car" data-name="agya trd" data-price="220000" style="transition-delay:0.48s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">HEMAT</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc8" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 80 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 80 Z" fill="url(#mc8)" stroke="#282828" stroke-width="1"/><path d="M74 80 L90 55 Q97 48 110 48 L170 48 Q183 48 190 55 L206 80 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">City Car · Merah</div>
                            <div class="car-name">Agya TRD</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 4 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 220.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Mercedes -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="mobil" data-cat="Luxury" data-name="mercedes e300" data-price="2200000" style="transition-delay:0.54s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">VIP</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:240px;position:relative;z-index:1;"><defs><linearGradient id="mc9" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#282828"/><stop offset="100%" style="stop-color:#141414"/></linearGradient></defs><ellipse cx="140" cy="110" rx="110" ry="7" fill="rgba(0,0,0,0.45)"/><path d="M28 82 L28 94 Q28 101 35 101 L245 101 Q252 101 252 94 L252 82 Z" fill="url(#mc9)" stroke="#282828" stroke-width="1"/><path d="M72 82 L95 58 Q103 50 118 50 L162 50 Q177 50 185 58 L208 82 Z" fill="#1c1c1c" stroke="#222" stroke-width="1"/><circle cx="72" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/><circle cx="208" cy="101" r="18" fill="#0e0e0e" stroke="#333" stroke-width="1.5"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Luxury · Obsidian Black</div>
                            <div class="car-name">Mercedes E300</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-people-fill"></i> 5 Kursi</div>
                                <div class="spec-item"><i class="bi bi-gear-fill"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 2.200.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- MOTOR SECTION -->
        <div class="section-divider" id="motorDivider">
            <div class="section-divider-line"></div>
            <div class="section-divider-label" style="color:#00d4ff;">
                <i class="bi bi-bicycle" style="color:#00d4ff"></i> MOTOR
                <span class="section-divider-count" style="background:rgba(0,212,255,0.1);border-color:rgba(0,212,255,0.3);color:#00d4ff;" id="motorCount">6</span>
            </div>
            <div class="section-divider-line"></div>
        </div>

        <div class="row g-4" id="motorGrid">

            <!-- Vario -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Matic" data-name="honda vario 160" data-price="120000" style="transition-delay:0s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">TERLARIS</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg0" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="80" cy="98" r="26" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="80" cy="98" r="17" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="80" cy="98" r="6" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><line x1="80" y1="81" x2="80" y2="115" stroke="#282828" stroke-width="1.5"/><line x1="63" y1="98" x2="97" y2="98" stroke="#282828" stroke-width="1.5"/><circle cx="210" cy="98" r="24" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="210" cy="98" r="15" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="210" cy="98" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M80 96 L105 60 L165 55 L200 72 L210 80" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M105 60 L165 55 L195 68 L175 80 L120 82 Z" fill="url(#mg0)" stroke="#333" stroke-width="1"/><ellipse cx="212" cy="70" rx="10" ry="7" fill="rgba(0,212,255,0.8)" opacity="0.7"/><rect x="76" y="68" width="10" height="5" rx="2" fill="rgba(255,50,50,0.9)"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Matic · 160cc · Hitam</div>
                            <div class="car-name">Honda Vario 160</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 160cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 120.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- R15 -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Sport" data-name="yamaha r15" data-price="180000" style="transition-delay:0.06s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">SPORTY</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="80" cy="98" r="26" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="80" cy="98" r="17" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="80" cy="98" r="6" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><line x1="80" y1="81" x2="80" y2="115" stroke="#282828" stroke-width="1.5"/><line x1="63" y1="98" x2="97" y2="98" stroke="#282828" stroke-width="1.5"/><circle cx="210" cy="98" r="24" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="210" cy="98" r="15" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="210" cy="98" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M80 96 L105 58 L168 52 L202 68 L210 80" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M105 58 L168 52 L198 65 L178 78 L122 80 Z" fill="url(#mg1)" stroke="#333" stroke-width="1"/><ellipse cx="212" cy="68" rx="10" ry="7" fill="rgba(0,212,255,0.8)" opacity="0.7"/><rect x="76" y="66" width="10" height="5" rx="2" fill="rgba(255,50,50,0.9)"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Sport · 155cc · Racing Blue</div>
                            <div class="car-name">Yamaha R15</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 155cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Manual</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 180.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Nmax -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Matic" data-name="yamaha nmax" data-price="140000" style="transition-delay:0.12s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">POPULER</span>
                            <span class="avail-badge booked">DIPESAN</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="80" cy="98" r="26" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="80" cy="98" r="17" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="80" cy="98" r="6" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><circle cx="210" cy="98" r="24" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="210" cy="98" r="15" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="210" cy="98" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M80 96 L105 60 L165 55 L200 72 L210 80" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M105 60 L165 55 L195 68 L175 80 L120 82 Z" fill="url(#mg2)" stroke="#333" stroke-width="1"/><ellipse cx="212" cy="70" rx="10" ry="7" fill="rgba(0,212,255,0.8)" opacity="0.7"/><rect x="76" y="68" width="10" height="5" rx="2" fill="rgba(255,50,50,0.9)"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Matic · 155cc · Putih</div>
                            <div class="car-name">Yamaha Nmax</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 155cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 140.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent opacity-50">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- CRF -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Trail" data-name="honda crf150l" data-price="160000" style="transition-delay:0.18s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">ADVENTURE</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="75" cy="95" r="28" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="75" cy="95" r="19" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="75" cy="95" r="6" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><circle cx="215" cy="97" r="26" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="215" cy="97" r="17" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="215" cy="97" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M75 93 L100 55 L165 50 L200 68 L215 82" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M100 55 L165 50 L195 63 L175 76 L118 78 Z" fill="url(#mg3)" stroke="#333" stroke-width="1"/><ellipse cx="217" cy="66" rx="10" ry="7" fill="rgba(0,212,255,0.8)" opacity="0.7"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Trail · 150cc · Merah</div>
                            <div class="car-name">Honda CRF150L</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 150cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Manual</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 160.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- PCX -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Matic" data-name="honda pcx 160" data-price="150000" style="transition-delay:0.24s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">PREMIUM</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="80" cy="98" r="26" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="80" cy="98" r="17" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="80" cy="98" r="6" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><circle cx="210" cy="98" r="24" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="210" cy="98" r="15" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="210" cy="98" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M80 96 L108 58 L170 53 L204 70 L210 80" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M108 58 L170 53 L198 66 L178 79 L124 81 Z" fill="url(#mg4)" stroke="#333" stroke-width="1"/><ellipse cx="212" cy="68" rx="10" ry="7" fill="rgba(0,212,255,0.8)" opacity="0.7"/><rect x="78" y="66" width="10" height="5" rx="2" fill="rgba(255,50,50,0.9)"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Matic · 160cc · Silver</div>
                            <div class="car-name">Honda PCX 160</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 160cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 150.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Beat -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-up vehicle-item" data-type="motor" data-cat="Matic" data-name="honda beat" data-price="90000" style="transition-delay:0.30s">
                <a href="{{ route('detail') }}" class="card-link">
                    <div class="car-card motor-card">
                        <div class="car-img-wrap">
                            <span class="car-badge">HEMAT</span>
                            <span class="avail-badge available">TERSEDIA</span>
                            <svg viewBox="0 0 280 120" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:220px;position:relative;z-index:1;"><defs><linearGradient id="mg5" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#252525"/><stop offset="100%" style="stop-color:#151515"/></linearGradient></defs><ellipse cx="140" cy="112" rx="105" ry="6" fill="rgba(0,0,0,0.4)"/><circle cx="80" cy="100" r="24" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="80" cy="100" r="16" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="80" cy="100" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><circle cx="205" cy="100" r="22" fill="#111" stroke="#2a2a2a" stroke-width="2"/><circle cx="205" cy="100" r="14" fill="#0a0a0a" stroke="#333" stroke-width="1.5"/><circle cx="205" cy="100" r="5" fill="#1a1a1a" stroke="rgba(0,212,255,0.4)" stroke-width="1.2"/><path d="M80 98 L105 65 L160 60 L195 75 L205 88" fill="none" stroke="#2a2a2a" stroke-width="3" stroke-linecap="round"/><path d="M105 65 L160 60 L190 72 L170 82 L118 84 Z" fill="url(#mg5)" stroke="#333" stroke-width="1"/><ellipse cx="207" cy="72" rx="9" ry="6" fill="rgba(0,212,255,0.8)" opacity="0.7"/></svg>
                        </div>
                        <div class="car-body">
                            <div class="car-category">Matic · 110cc · Biru</div>
                            <div class="car-name">Honda Beat</div>
                            <div class="car-specs">
                                <div class="spec-item"><i class="bi bi-speedometer2" style="color:#00d4ff"></i> 110cc</div>
                                <div class="spec-item"><i class="bi bi-gear-fill" style="color:#00d4ff"></i> Matic</div>
                                <div class="spec-item"><i class="bi bi-droplet-fill" style="color:#00d4ff"></i> Bensin</div>
                            </div>
                            <div class="car-footer">
                                <div class="car-price"><span class="price-amount">Rp 90.000</span><span class="price-label">per hari</span></div>
                                <div class="btn-rent">DETAIL <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Empty state -->
        <div class="empty-state" id="emptyState">
            <i class="bi bi-search d-block"></i>
            <h5 style="font-family:'Bebas Neue',sans-serif;font-size:1.8rem;letter-spacing:0.05em;margin-bottom:8px;">TIDAK DITEMUKAN</h5>
            <p>Coba ubah filter atau kata kunci pencarian.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fade-up observer
    const fadeEls = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.08 });
    fadeEls.forEach(el => observer.observe(el));

    // Filter / Search Logic
    const items       = document.querySelectorAll('.vehicle-item');
    const tabs        = document.querySelectorAll('.filter-tab');
    const catFilter   = document.getElementById('categoryFilter');
    const sortFilter  = document.getElementById('sortFilter');
    const searchInput = document.getElementById('searchInput');
    const visCount    = document.getElementById('visibleCount');
    const totalCount  = document.getElementById('totalCount');
    const emptyState  = document.getElementById('emptyState');
    const mobilDiv    = document.getElementById('mobilDivider');
    const motorDiv    = document.getElementById('motorDivider');
    const mobilCnt    = document.getElementById('mobilCount');
    const motorCnt    = document.getElementById('motorCount');

    let activeType = 'all';

    function applyFilters() {
        const cat    = catFilter.value.toLowerCase();
        const search = searchInput.value.toLowerCase();
        let vis = 0, mobVis = 0, motVis = 0;

        const sorted = [...items].sort((a, b) => {
            const sv = sortFilter.value;
            if (sv === 'price-asc')  return +a.dataset.price - +b.dataset.price;
            if (sv === 'price-desc') return +b.dataset.price - +a.dataset.price;
            if (sv === 'name-asc')   return a.dataset.name.localeCompare(b.dataset.name);
            return 0;
        });

        sorted.forEach(item => {
            const typeMatch = activeType === 'all' || item.dataset.type === activeType;
            const catMatch  = !cat    || item.dataset.cat.toLowerCase().includes(cat);
            const nameMatch = !search || item.dataset.name.includes(search);
            const show = typeMatch && catMatch && nameMatch;
            item.style.display = show ? '' : 'none';
            if (show) {
                vis++;
                if (item.dataset.type === 'mobil') mobVis++;
                else motVis++;
                item.classList.add('visible');
            }
        });

        const mobilGrid = document.getElementById('mobilGrid');
        const motorGrid = document.getElementById('motorGrid');
        sorted.filter(i => i.dataset.type === 'mobil').forEach(i => mobilGrid.appendChild(i));
        sorted.filter(i => i.dataset.type === 'motor').forEach(i => motorGrid.appendChild(i));

        visCount.textContent   = vis;
        totalCount.textContent = vis + ' Kendaraan Tersedia';
        mobilCnt.textContent   = mobVis;
        motorCnt.textContent   = motVis;

        mobilDiv.style.display = (activeType === 'motor') ? 'none' : '';
        motorDiv.style.display = (activeType === 'mobil') ? 'none' : '';

        emptyState.style.display = vis === 0 ? 'block' : 'none';
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeType = tab.dataset.filter;
            catFilter.value = '';
            applyFilters();
        });
    });

    catFilter.addEventListener('change', applyFilters);
    sortFilter.addEventListener('change', applyFilters);
    searchInput.addEventListener('input', applyFilters);
</script>
</body>
</html>