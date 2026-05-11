@extends('core::components.layouts.public')

@section('title', 'Fonctionnalités')

@section('content')
<section class="py-5" style="min-height:70vh;background:#0f172a;padding-top:5rem!important;">
    <div class="container">
        <h1 style="font-family:'Poppins',sans-serif;font-weight:800;color:white;text-align:center;margin-bottom:1rem;">Fonctionnalités</h1>
        <p style="color:#64748b;text-align:center;margin-bottom:3rem;">Tout ce dont vous avez besoin pour gérer votre organisation.</p>
        
        <div class="row g-4">
            @foreach([
                ['🔐','Sécurité Enterprise','CSRF, XSS, SQL Injection protection, CSP Headers, chiffrement AES/RSA, Audit logs'],
                ['🌍','Multilingue','Français, Anglais, Swahili, Lingala. URLs multilingues, sitemap multilingue, meta tags traduits'],
                ['📱','Progressive Web App','Mode hors-ligne, notifications push, installable sur iOS/Android'],
                ['⚡','Temps Réel','Laravel Echo + WebSockets. Notifications, chat, tableaux de bord live'],
                ['👥','RBAC Multi-rôles','SuperAdmin, Admin, Manager, Teacher, Student, Parent, Accountant, Employee, Vendor, Recruiter, Customer'],
                ['📊','Analytics Avancés','Dashboards interactifs, graphiques, rapports PDF/Excel, métriques en temps réel'],
                ['🚀','API-First','API RESTful complète avec Sanctum. Documentation auto-générée'],
                ['📧','Communication','Email, SMS, notifications push, chat temps réel, audio/vidéo'],
                ['💳','Paiements','Wallet, Mobile Money, carte bancaire, anti-fraude intégré'],
            ] as $f)
            <div class="col-md-6 col-lg-4">
                <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:1.25rem;padding:2rem;height:100%;">
                    <div style="font-size:2rem;margin-bottom:1rem;">{{ $f[0] }}</div>
                    <h5 style="color:white;font-weight:700;margin-bottom:0.5rem;">{{ $f[1] }}</h5>
                    <p style="color:#64748b;font-size:0.875rem;margin:0;">{{ $f[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
