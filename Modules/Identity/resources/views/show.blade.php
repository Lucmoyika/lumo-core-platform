@extends('core::components.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Identity · Détail</h4>
    <a href="{{ route('identity.dashboard') }}" class="btn btn-outline-secondary btn-sm">Retour</a>
</div>

<div class="stat-card">
    <p class="mb-1"><strong>Module :</strong> Identity</p>
    <p class="text-muted mb-0">Vue de consultation générique du module, prête à être reliée à une ressource spécifique si nécessaire.</p>
</div>
@endsection
