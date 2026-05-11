<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lumo Core Platform - Plateforme SaaS modulaire ERP pour organisations">
    <meta name="theme-color" content="#6366f1">
    <title>{{ config('app.name') }} — Plateforme SaaS ERP Modulaire</title>
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
        }
        
        * { font-family: 'Inter', sans-serif; }
        
        body {
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar-lumo {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        
        /* Hero */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            padding: 6rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }
        
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            line-height: 1.1;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            color: #a5b4fc;
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .btn-primary-lumo {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary-lumo:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99,102,241,0.4);
            color: white;
        }
        
        .btn-outline-lumo {
            background: transparent;
            color: #a5b4fc;
            border: 1px solid rgba(99,102,241,0.4);
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-outline-lumo:hover {
            background: rgba(99,102,241,0.1);
            color: white;
        }
        
        /* Stats */
        .stats-bar {
            background: rgba(255,255,255,0.03);
            border-top: 1px solid rgba(255,255,255,0.06);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding: 2rem 0;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
        }
        
        /* Modules section */
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: white;
        }
        
        .module-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 1.25rem;
            padding: 2rem;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }
        
        .module-card:hover {
            background: rgba(99,102,241,0.08);
            border-color: rgba(99,102,241,0.3);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            color: white;
        }
        
        .module-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .module-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .module-desc {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.5;
        }
        
        /* Features */
        .feature-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }
        
        .feature-icon {
            width: 44px;
            height: 44px;
            background: rgba(99,102,241,0.15);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }
        
        /* Footer */
        footer {
            background: rgba(0,0,0,0.3);
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 3rem 0 1.5rem;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
    </style>
</head>
<body x-data="{ mobileMenu: false }">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-lumo sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('core.home') }}">
            <div style="width:36px;height:36px;background:#6366f1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;">⚡</div>
            <span style="font-family:'Poppins',sans-serif;font-weight:700;color:white;">Lumo Platform</span>
        </a>
        
        <button class="navbar-toggler" type="button" @click="mobileMenu = !mobileMenu" style="border-color:rgba(255,255,255,0.2)">
            <i class="bi bi-list" style="color:white;font-size:1.5rem;"></i>
        </button>
        
        <div class="collapse navbar-collapse" :class="{ 'show': mobileMenu }">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 gap-2 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('core.features') }}" style="color:#94a3b8;">Fonctionnalités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('core.pricing') }}" style="color:#94a3b8;">Tarification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('core.contact') }}" style="color:#94a3b8;">Contact</a>
                </li>
                
                <!-- Language -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" style="color:#94a3b8;">
                        🌍 {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="background:#1e293b;border-color:#334155;">
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'fr') }}" style="color:#e2e8f0;">🇫🇷 Français</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}" style="color:#e2e8f0;">🇬🇧 English</a></li>
                    </ul>
                </li>
                
                @auth
                <li class="nav-item">
                    <a href="{{ route('identity.dashboard') }}" class="btn btn-sm" style="background:#6366f1;color:white;border-radius:0.5rem;padding:0.4rem 1rem;">
                        <i class="bi bi-grid me-1"></i>Tableau de bord
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('identity.login') }}" class="nav-link" style="color:#94a3b8;">Connexion</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('identity.register') }}" class="btn btn-sm" style="background:#6366f1;color:white;border-radius:0.5rem;padding:0.4rem 1rem;">
                        Inscription
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <span>✨</span>
                    <span>Plateforme SaaS Modulaire</span>
                </div>
                
                <h1 class="hero-title mb-4">
                    {{ __('core::messages.hero_title') }}
                </h1>
                
                <p class="mb-5" style="font-size:1.1rem;color:#94a3b8;line-height:1.7;">
                    {{ __('core::messages.hero_subtitle') }}
                </p>
                
                <div class="d-flex flex-wrap gap-3">
                    @auth
                    <a href="{{ route('identity.dashboard') }}" class="btn-primary-lumo">
                        <i class="bi bi-grid-fill"></i>
                        Mon Tableau de bord
                    </a>
                    @else
                    <a href="{{ route('identity.register') }}" class="btn-primary-lumo">
                        <i class="bi bi-rocket"></i>
                        {{ __('core::messages.get_started') }}
                    </a>
                    <a href="{{ route('core.features') }}" class="btn-outline-lumo">
                        {{ __('core::messages.learn_more') }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    @endauth
                </div>
            </div>
            
            <div class="col-lg-6 mt-5 mt-lg-0">
                <!-- Dashboard Preview -->
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:1.5rem;padding:1.5rem;backdrop-filter:blur(10px);">
                    <div class="d-flex gap-2 mb-3">
                        <div style="width:12px;height:12px;background:#ef4444;border-radius:50%;"></div>
                        <div style="width:12px;height:12px;background:#f59e0b;border-radius:50%;"></div>
                        <div style="width:12px;height:12px;background:#22c55e;border-radius:50%;"></div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        @foreach([['📚','School','1,250'],['🏛️','University','450'],['💼','Jobs','3,200'],['🛒','E-Commerce','8,900']] as $s)
                        <div class="col-6">
                            <div style="background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.2);border-radius:0.75rem;padding:1rem;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size:1.5rem;">{{ $s[0] }}</span>
                                    <span style="font-size:0.65rem;color:#22c55e;background:rgba(34,197,94,0.15);padding:0.2rem 0.5rem;border-radius:100px;">+12%</span>
                                </div>
                                <div style="font-size:1.2rem;font-weight:700;color:white;margin-top:0.5rem;">{{ $s[2] }}</div>
                                <div style="font-size:0.75rem;color:#64748b;">{{ $s[1] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div style="background:rgba(99,102,241,0.08);border-radius:0.75rem;padding:0.75rem;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small style="color:#94a3b8;">Activité récente</small>
                            <small style="color:#6366f1;">Voir tout →</small>
                        </div>
                        @foreach(['Nouvel élève inscrit','Paiement reçu','Offre d\'emploi publiée'] as $a)
                        <div class="d-flex align-items-center gap-2 py-1" style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <div style="width:6px;height:6px;background:#6366f1;border-radius:50%;"></div>
                            <small style="color:#94a3b8;">{{ $a }}</small>
                            <small style="color:#475569;margin-left:auto;">il y a 5m</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-4">
            @foreach([['11','Modules'],['100+','Fonctionnalités'],['∞','Scalable'],['24/7','Support']] as $s)
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <div class="stat-number">{{ $s[0] }}</div>
                    <div class="stat-label">{{ $s[1] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modules Section -->
<section class="py-5" style="background:#0f172a;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ __('core::messages.our_modules') }}</h2>
            <p style="color:#64748b;">{{ __('core::messages.our_modules_subtitle') }}</p>
        </div>
        
        <div class="row g-4">
            @foreach($modules as $module)
            @php
                $colors = [
                    'indigo' => '#6366f1', 'blue' => '#3b82f6', 'emerald' => '#10b981',
                    'amber' => '#f59e0b', 'rose' => '#f43f5e', 'violet' => '#8b5cf6',
                    'orange' => '#f97316', 'teal' => '#14b8a6', 'cyan' => '#06b6d4',
                ];
                $color = $colors[$module['color']] ?? '#6366f1';
            @endphp
            <div class="col-md-6 col-lg-4">
                @php
                    try { $url = route($module['route']); } catch(\Exception $e) { $url = '#'; }
                @endphp
                <a href="{{ $url }}" class="module-card">
                    <span class="module-icon">{{ $module['icon'] }}</span>
                    <div class="module-name" style="color:{{ $color }};">{{ $module['name'] }}</div>
                    <div class="module-desc">{{ $module['description'] }}</div>
                    <div class="mt-3" style="font-size:0.8rem;color:{{ $color }};">
                        Découvrir <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background:rgba(255,255,255,0.02);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title mb-4">Architecture Enterprise-Ready</h2>
                
                <div class="d-flex flex-column gap-4">
                    @foreach([
                        ['🔐','Sécurité Maximale','CSRF, XSS, SQL Injection, CSP Headers, chiffrement AES/RSA'],
                        ['🌍','Multilingue Global','Français, Anglais, Swahili, Lingala et plus — i18n natif'],
                        ['📱','Progressive Web App','Mode hors-ligne, notifications push, installable sur mobile'],
                        ['⚡','Temps Réel','Laravel Echo + WebSockets pour notifications et chat live'],
                        ['♾️','Scalable','Architecture modulaire nwidart, Clean Code, SOLID principles'],
                    ] as $f)
                    <div class="feature-item">
                        <div class="feature-icon">{{ $f[0] }}</div>
                        <div>
                            <div style="font-weight:600;color:white;margin-bottom:0.25rem;">{{ $f[1] }}</div>
                            <div style="font-size:0.85rem;color:#64748b;">{{ $f[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="col-lg-6">
                <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:1.25rem;padding:2rem;">
                    <div style="font-weight:700;color:white;margin-bottom:1rem;">Stack Technique</div>
                    @foreach(['Laravel 11 (PHP 8.3)','MySQL 8 + Redis','Spatie RBAC Permissions','Laravel Sanctum API','Laravel Horizon Queues','Vue.js 3 + Alpine.js','Tailwind CSS + Bootstrap 5','nwidart/laravel-modules'] as $tech)
                    <div class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid rgba(255,255,255,0.05);">
                        <i class="bi bi-check-circle-fill" style="color:#22c55e;font-size:0.9rem;"></i>
                        <span style="color:#94a3b8;font-size:0.9rem;">{{ $tech }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background:linear-gradient(135deg,rgba(99,102,241,0.15) 0%,rgba(139,92,246,0.1) 100%);border-top:1px solid rgba(99,102,241,0.2);border-bottom:1px solid rgba(99,102,241,0.2);">
    <div class="container text-center">
        <h2 class="section-title mb-3">Prêt à commencer ?</h2>
        <p style="color:#94a3b8;font-size:1.1rem;margin-bottom:2rem;">Rejoignez des milliers d'organisations qui font confiance à Lumo.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('identity.register') }}" class="btn-primary-lumo">
                <i class="bi bi-rocket"></i>
                Démarrer gratuitement
            </a>
            <a href="{{ route('core.contact') }}" class="btn-outline-lumo">
                <i class="bi bi-chat"></i>
                Parler à l'équipe
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:36px;height:36px;background:#6366f1;border-radius:10px;display:flex;align-items:center;justify-content:center;">⚡</div>
                    <span style="font-family:'Poppins',sans-serif;font-weight:700;color:white;font-size:1.1rem;">Lumo Platform</span>
                </div>
                <p style="color:#64748b;font-size:0.875rem;">Plateforme SaaS modulaire pour gérer vos organisations avec efficacité.</p>
            </div>
            
            @foreach([
                ['Modules',['School','University','Companies','Jobs','E-Commerce','Payment','Logistics','Communication','Analytics']],
                ['Plateforme',['Fonctionnalités','Tarification','Documentation','API Reference']],
                ['Entreprise',['À propos','Contact','Confidentialité','Conditions d\'utilisation']],
            ] as $col)
            <div class="col-6 col-lg-2">
                <h6 style="color:white;font-weight:600;margin-bottom:1rem;">{{ $col[0] }}</h6>
                @foreach($col[1] as $link)
                <div><a href="#" style="color:#64748b;text-decoration:none;font-size:0.875rem;display:block;margin-bottom:0.5rem;">{{ $link }}</a></div>
                @endforeach
            </div>
            @endforeach
        </div>
        
        <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:1.5rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
            <p style="color:#475569;font-size:0.8rem;margin:0;">© {{ date('Y') }} Lumo Core Platform. Tous droits réservés.</p>
            <div class="d-flex gap-3">
                <a href="{{ route('locale.switch', 'fr') }}" style="color:#64748b;text-decoration:none;font-size:0.8rem;">🇫🇷 FR</a>
                <a href="{{ route('locale.switch', 'en') }}" style="color:#64748b;text-decoration:none;font-size:0.8rem;">🇬🇧 EN</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- PWA Service Worker -->
<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(console.error);
}
</script>
</body>
</html>
