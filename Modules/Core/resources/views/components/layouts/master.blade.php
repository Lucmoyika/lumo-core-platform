<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description ?? 'Lumo Core Platform - SaaS ERP Modulaire' }}">
    <meta name="theme-color" content="#6366f1">
    
    <title>{{ $title ?? config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --sidebar-bg: #1e1e2e;
            --sidebar-text: #cdd6f4;
            --sidebar-active: #6366f1;
        }
        
        * { transition: background-color 0.2s, color 0.2s; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .dark body, body.dark {
            background: #0f172a;
            color: #e2e8f0;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: width 0.3s ease;
            overflow: hidden;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .sidebar .brand-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            white-space: nowrap;
        }
        
        .sidebar .nav-section {
            padding: 1rem 1rem 0;
        }
        
        .sidebar .nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            padding: 0.5rem 0.5rem;
            white-space: nowrap;
        }
        
        .sidebar .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            border-radius: 0.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            margin-bottom: 2px;
            white-space: nowrap;
            font-size: 0.875rem;
        }
        
        .sidebar .nav-item:hover, .sidebar .nav-item.active {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }
        
        .sidebar .nav-item.active {
            background: var(--primary);
            color: white;
        }
        
        .sidebar .nav-item i {
            font-size: 1.1rem;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }
        
        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Topbar */
        .topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .dark .topbar {
            background: #1e293b;
            border-color: #334155;
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        
        .dark .stat-card {
            background: #1e293b;
            border-color: #334155;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        
        /* Animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease;
        }
        
        /* Module color badges */
        .badge-indigo { background: #6366f1; }
        .badge-blue { background: #3b82f6; }
        .badge-emerald { background: #10b981; }
        .badge-amber { background: #f59e0b; }
        .badge-rose { background: #f43f5e; }
        .badge-violet { background: #8b5cf6; }
        .badge-orange { background: #f97316; }
        .badge-teal { background: #14b8a6; }
        .badge-cyan { background: #06b6d4; }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
    </style>
    
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar" x-bind:class="{ 'collapsed': !sidebarOpen }">
    <!-- Brand -->
    <div class="brand">
        <div class="brand-icon">⚡</div>
        <div class="brand-text" x-show="sidebarOpen" x-transition>Lumo Platform</div>
    </div>
    
    <!-- Navigation -->
    <div class="nav-section overflow-auto" style="height: calc(100vh - 80px);">
        
        @if(auth()->check())
        <div class="nav-label" x-show="sidebarOpen">PRINCIPAL</div>
        <a href="{{ route('identity.dashboard') }}" class="nav-item {{ request()->routeIs('identity.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span x-show="sidebarOpen" x-transition>{{ __('messages.dashboard') }}</span>
        </a>
        @endif
        
        <div class="nav-label" x-show="sidebarOpen">MODULES</div>
        
        <a href="{{ route('school.home') }}" class="nav-item {{ request()->routeIs('school.*') ? 'active' : '' }}">
            <i class="bi bi-mortarboard-fill"></i>
            <span x-show="sidebarOpen" x-transition>School</span>
        </a>
        
        <a href="{{ route('university.home') }}" class="nav-item {{ request()->routeIs('university.*') ? 'active' : '' }}">
            <i class="bi bi-building-fill"></i>
            <span x-show="sidebarOpen" x-transition>University</span>
        </a>
        
        <a href="{{ route('companies.home') }}" class="nav-item {{ request()->routeIs('companies.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase-fill"></i>
            <span x-show="sidebarOpen" x-transition>Companies</span>
        </a>
        
        <a href="{{ route('jobs.home') }}" class="nav-item {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
            <i class="bi bi-person-workspace"></i>
            <span x-show="sidebarOpen" x-transition>Jobs</span>
        </a>
        
        <a href="{{ route('ecommerce.home') }}" class="nav-item {{ request()->routeIs('ecommerce.*') ? 'active' : '' }}">
            <i class="bi bi-bag-fill"></i>
            <span x-show="sidebarOpen" x-transition>E-Commerce</span>
        </a>
        
        <a href="{{ route('payment.home') }}" class="nav-item {{ request()->routeIs('payment.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-fill"></i>
            <span x-show="sidebarOpen" x-transition>Payment</span>
        </a>
        
        <a href="{{ route('logistics.home') }}" class="nav-item {{ request()->routeIs('logistics.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span x-show="sidebarOpen" x-transition>Logistics</span>
        </a>
        
        <a href="{{ route('communication.home') }}" class="nav-item {{ request()->routeIs('communication.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots-fill"></i>
            <span x-show="sidebarOpen" x-transition>Communication</span>
        </a>
        
        <a href="{{ route('analytics.home') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>
            <span x-show="sidebarOpen" x-transition>Analytics</span>
        </a>
        
        @auth
        <div class="nav-label" x-show="sidebarOpen">COMPTE</div>
        <a href="{{ route('identity.profile') }}" class="nav-item">
            <i class="bi bi-person-fill"></i>
            <span x-show="sidebarOpen" x-transition>{{ __('messages.profile') }}</span>
        </a>
        <a href="{{ route('identity.logout') }}" class="nav-item" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span x-show="sidebarOpen" x-transition>{{ __('messages.logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('identity.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        @endauth
        
        @guest
        <a href="{{ route('identity.login') }}" class="nav-item">
            <i class="bi bi-box-arrow-in-right"></i>
            <span x-show="sidebarOpen" x-transition>{{ __('messages.login') }}</span>
        </a>
        @endguest
    </div>
</aside>

<!-- Main Content -->
<div class="main-content" id="mainContent" x-bind:class="{ 'expanded': !sidebarOpen }">
    
    <!-- Topbar -->
    <nav class="topbar">
        <div class="d-flex align-items-center gap-3">
            <!-- Sidebar Toggle -->
            <button class="btn btn-sm btn-outline-secondary" @click="sidebarOpen = !sidebarOpen">
                <i class="bi bi-list fs-5"></i>
            </button>
            
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- Language Switcher -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-globe"></i>
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('locale.switch', 'fr') }}">🇫🇷 Français</a></li>
                    <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">🇬🇧 English</a></li>
                    <li><a class="dropdown-item" href="{{ route('locale.switch', 'sw') }}">🇰🇪 Swahili</a></li>
                </ul>
            </div>
            
            <!-- Dark Mode Toggle -->
            <button class="btn btn-sm btn-outline-secondary" 
                    @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)">
                <i class="bi" :class="darkMode ? 'bi-sun-fill' : 'bi-moon-fill'"></i>
            </button>
            
            @auth
            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary position-relative" data-bs-toggle="dropdown">
                    <i class="bi bi-bell-fill"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end" style="width:320px">
                    <div class="dropdown-header d-flex justify-content-between align-items-center">
                        <strong>{{ __('messages.notifications') }}</strong>
                        <a href="#" class="text-primary small">{{ __('messages.mark_all_read') }}</a>
                    </div>
                    <div class="dropdown-item text-muted text-center py-3">
                        <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                        {{ __('messages.no_notifications') }}
                    </div>
                </div>
            </div>
            
            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <div style="width:32px;height:32px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;font-size:0.8rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="d-none d-md-inline small fw-600">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">{{ auth()->user()->email }}</li>
                    <li><a class="dropdown-item" href="{{ route('identity.profile') }}"><i class="bi bi-person me-2"></i>{{ __('messages.profile') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('identity.settings') }}"><i class="bi bi-gear me-2"></i>{{ __('messages.settings') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('identity.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.logout') }}
                        </a>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>
    
    <!-- Page Content -->
    <main class="p-4 animate-slide-in">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Dark mode init -->
<script>
    // Initialize dark mode from localStorage
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    }
    
    // Register service worker for PWA
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').then(() => {
            console.log('Service Worker registered');
        }).catch(console.error);
    }
</script>

@stack('scripts')
</body>
</html>
