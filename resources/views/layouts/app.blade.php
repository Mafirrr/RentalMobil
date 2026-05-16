<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CAPSTONE — Premium Car Rental')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg-base: #0a0a0c;
            --bg-surface: #111115;
            --bg-card: #16161c;
            --bg-card-hover: #1c1c24;
            --accent: #c8ff00;
            --accent-dim: rgba(200, 255, 0, 0.12);
            --accent-glow: rgba(200, 255, 0, 0.35);
            --text-primary: #f0f0f0;
            --text-secondary: #8a8a9a;
            --text-muted: #55556a;
            --border: rgba(255, 255, 255, 0.07);
            --border-accent: rgba(200, 255, 0, 0.3);
            --gradient-hero: linear-gradient(135deg, #0a0a0c 0%, #0f0f18 50%, #0a0a0c 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-base);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 2px;
        }

        .font-display {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.04em;
        }

        .font-mono {
            font-family: 'Space Mono', monospace;
        }

        .navbar-capstone {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.4s ease;
            background: transparent;
        }

        .navbar-capstone.scrolled {
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(20px);
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .nav-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--text-primary) !important;
            letter-spacing: 0.1em;
            text-decoration: none;
        }

        .nav-brand span {
            color: var(--accent);
        }

        .nav-link-capstone {
            color: var(--text-secondary) !important;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link-capstone:hover {
            color: var(--accent) !important;
        }

        .btn-nav {
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            padding: 9px 22px;
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            border-radius: 2px;
            transition: all 0.25s;
            text-decoration: none;
        }

        .btn-nav:hover {
            background: var(--accent);
            color: #000;
        }

        .btn-nav-login {
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            padding: 9px 20px;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            background: transparent;
            border-radius: 2px;
            transition: all 0.25s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-nav-login:hover {
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        footer {
            background: var(--bg-surface);
            border-top: 1px solid var(--border);
            padding: 64px 0 32px;
        }

        .footer-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            letter-spacing: 0.1em;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .footer-brand span {
            color: var(--accent);
        }

        .footer-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.75;
            max-width: 260px;
        }

        .footer-heading {
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            font-size: 0.88rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-divider {
            border-color: var(--border);
            margin: 40px 0 24px;
        }

        .footer-copy {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-family: 'Space Mono', monospace;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @if (!isset($hideFooter) || !$hideFooter)
        @include('layouts.footer')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        const fadeEls = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        fadeEls.forEach(el => observer.observe(el));
    </script>
</body>

</html>
