<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <link rel="manifest" href="/manifest.json">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f172a; color: #e2e8f0; }
        .navbar-lumo { background: rgba(15,23,42,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.08); }
        footer { background: rgba(0,0,0,0.3); border-top: 1px solid rgba(255,255,255,0.06); padding: 2rem 0; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-lumo sticky-top" x-data="{ open: false }">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('core.home') }}">
            <div style="width:36px;height:36px;background:#6366f1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;">⚡</div>
            <span style="font-family:'Poppins',sans-serif;font-weight:700;color:white;">Lumo Platform</span>
        </a>
        <button class="navbar-toggler" @click="open=!open" style="border-color:rgba(255,255,255,0.2)"><i class="bi bi-list" style="color:white;font-size:1.5rem;"></i></button>
        <div class="collapse navbar-collapse" :class="{'show':open}">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('core.features') }}" style="color:#94a3b8;">Fonctionnalités</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('core.pricing') }}" style="color:#94a3b8;">Tarification</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('core.contact') }}" style="color:#94a3b8;">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" style="color:#94a3b8;">🌍 {{ strtoupper(app()->getLocale()) }}</a>
                    <ul class="dropdown-menu" style="background:#1e293b;border-color:#334155;">
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'fr') }}" style="color:#e2e8f0;">🇫🇷 Français</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}" style="color:#e2e8f0;">🇬🇧 English</a></li>
                    </ul>
                </li>
                @auth
                <li class="nav-item"><a href="{{ route('identity.dashboard') }}" class="btn btn-sm" style="background:#6366f1;color:white;border-radius:0.5rem;padding:0.4rem 1rem;">Dashboard</a></li>
                @else
                <li class="nav-item"><a href="{{ route('identity.login') }}" class="nav-link" style="color:#94a3b8;">Connexion</a></li>
                <li class="nav-item"><a href="{{ route('identity.register') }}" class="btn btn-sm" style="background:#6366f1;color:white;border-radius:0.5rem;padding:0.4rem 1rem;">Inscription</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>@yield('content')</main>

<footer>
    <div class="container text-center">
        <p style="color:#475569;font-size:0.875rem;margin:0;">© {{ date('Y') }} Lumo Core Platform. Tous droits réservés.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
