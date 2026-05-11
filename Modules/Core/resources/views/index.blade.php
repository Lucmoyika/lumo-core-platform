@extends('core::components.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Core Module</h4>
        <small class="text-muted">Point d’entrée global de la plateforme Lumo</small>
    </div>
    <a href="{{ route('core.home') }}" class="btn btn-primary btn-sm">Aller au site public</a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Site public</h6>
            <p class="text-muted mb-3">Présente les offres, fonctionnalités et contact.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('core.features') }}">Fonctionnalités</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Identité & accès</h6>
            <p class="text-muted mb-3">Authentification, rôles, permissions et profils.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('identity.dashboard') }}">Dashboard</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Modules métier</h6>
            <p class="text-muted mb-3">School, University, Companies, Jobs, Ecommerce, Payment, Logistics, Communication, Analytics.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('school.home') }}">Explorer un module</a>
        </div>
    </div>
</div>

<div class="mt-4" data-vue-component="core-insights" data-props='@json([
    "title" => "Core Platform",
    "accent" => "#0ea5e9",
    "features" => ["Site public", "SSO/Auth", "Portails multi-modules", "API unifiée"]
])'></div>
@endsection
