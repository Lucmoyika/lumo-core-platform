@extends('core::components.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Créer une entrée Identity</h4>
    <a href="{{ route('identity.dashboard') }}" class="btn btn-outline-secondary btn-sm">Retour dashboard</a>
</div>

<div class="stat-card">
    <p class="text-muted mb-3">Cette page sert d’entrée de création globale pour le module Identity.</p>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-primary btn-sm" href="{{ route('identity.users.create') }}">Créer un utilisateur</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('identity.roles.create') }}">Créer un rôle</a>
    </div>
</div>
@endsection
