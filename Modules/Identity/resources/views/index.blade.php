@extends('core::components.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">Identity Module</h4>
        <small class="text-muted">Gestion complète des utilisateurs, rôles et sécurité</small>
    </div>
    <a href="{{ route('identity.dashboard') }}" class="btn btn-primary btn-sm">Tableau de bord</a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Utilisateurs</h6>
            <p class="text-muted mb-3">Créer, éditer et activer les comptes utilisateurs.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('identity.users.index') }}">Gérer</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Rôles & permissions</h6>
            <p class="text-muted mb-3">RBAC avec Spatie pour contrôler les accès par module.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('identity.roles.index') }}">Voir les rôles</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card h-100">
            <h6 class="mb-2">Compte personnel</h6>
            <p class="text-muted mb-3">Profil, paramètres, mot de passe et préférences.</p>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('identity.profile') }}">Mon profil</a>
        </div>
    </div>
</div>
@endsection
