@props(['module', 'pageTitle' => null, 'pageDescription' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? $module['label'].' · '.config('app.name') }}</title>
    <meta name="description" content="{{ $pageDescription ?? $module['summary'] }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --module-accent: {{ $module['accent'] }}; }
        body { margin:0; font-family:ui-sans-serif,system-ui,sans-serif; background:linear-gradient(180deg,#020617 0%,#0f172a 100%); color:#e2e8f0; }
        .shell { max-width:1180px; margin:0 auto; padding:0 1.25rem; }
        .nav { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 0; }
        .brand { display:flex; align-items:center; gap:.75rem; color:#fff; text-decoration:none; font-weight:700; }
        .brand-badge { width:2.5rem; height:2.5rem; border-radius:.85rem; background:var(--module-accent); display:grid; place-items:center; }
        .nav-links { display:flex; gap:.75rem; flex-wrap:wrap; }
        .nav-links a { color:#cbd5e1; text-decoration:none; padding:.65rem .9rem; border-radius:999px; border:1px solid rgba(148,163,184,.2); }
        .nav-links a:hover { border-color: var(--module-accent); color:#fff; }
        .hero, .panel { background:rgba(15,23,42,.76); border:1px solid rgba(148,163,184,.18); border-radius:1.5rem; box-shadow:0 24px 60px rgba(2,6,23,.25); }
        .hero { padding:2rem; margin:1rem 0 2rem; }
        .hero-grid, .card-grid, .stats-grid, .roles-grid { display:grid; gap:1rem; }
        .hero-grid { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); align-items:center; }
        .card-grid, .roles-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .stats-grid { grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
        .badge { display:inline-flex; align-items:center; gap:.4rem; padding:.4rem .75rem; border-radius:999px; background:rgba(255,255,255,.06); color:#cbd5e1; text-decoration:none; }
        .headline { font-size: clamp(2rem, 4vw, 3.5rem); line-height:1.1; margin:.8rem 0; }
        .muted { color:#94a3b8; }
        .cta { display:inline-flex; align-items:center; gap:.6rem; padding:.9rem 1.2rem; border-radius:1rem; background:var(--module-accent); color:#fff; text-decoration:none; font-weight:600; }
        .panel { padding:1.25rem; }
        .card, .stat, .role-card, .table-wrapper { background:rgba(15,23,42,.7); border:1px solid rgba(148,163,184,.16); border-radius:1.2rem; padding:1rem; }
        .card h3, .role-card h3 { margin:.25rem 0 .65rem; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:.85rem .5rem; border-bottom:1px solid rgba(148,163,184,.14); text-align:left; }
        footer { color:#64748b; text-align:center; padding:2rem 0 3rem; }
        .status { padding:.35rem .65rem; border-radius:999px; font-size:.85rem; background:rgba(34,197,94,.15); color:#86efac; }
        @media (max-width: 768px) { .nav { flex-direction: column; align-items:flex-start; } }
    </style>
</head>
<body>
    <header class="shell">
        <div class="nav">
            <a class="brand" href="{{ route($module['route_prefix'].'.home') }}">
                <span class="brand-badge">{{ $module['icon'] }}</span>
                <span>{{ $module['label'] }} · Lumo</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route($module['route_prefix'].'.home') }}">Site public</a>
                @if (Route::has($module['portal_route']))<a href="{{ route($module['portal_route']) }}">Portail</a>@endif
                @if (Route::has($module['erp_route']))<a href="{{ route($module['erp_route']) }}">ERP</a>@endif
                <a href="{{ $module['api_path'] }}">API</a>
                @guest
                    <a href="{{ route('login') }}">Connexion</a>
                @else
                    <a href="{{ route('identity.dashboard') }}">Dashboard</a>
                @endguest
            </nav>
        </div>
    </header>
    <main class="shell">{{ $slot }}</main>
    <footer class="shell">{{ config('app.name') }} · {{ $module['summary'] }}</footer>
</body>
</html>
