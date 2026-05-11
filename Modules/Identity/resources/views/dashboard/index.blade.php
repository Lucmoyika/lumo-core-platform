@extends('core::components.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Tableau de bord</h4>
    <small class="text-muted">{{ now()->translatedFormat('l d F Y') }}</small>
</div>
<div class="row g-3">
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">Utilisateurs</div><div class="fs-3 fw-bold">{{ $stats['total_users'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">Actifs</div><div class="fs-3 fw-bold">{{ $stats['active_users'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">Rôles</div><div class="fs-3 fw-bold">{{ $stats['total_roles'] }}</div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="text-muted small">Permissions</div><div class="fs-3 fw-bold">{{ $stats['total_permissions'] }}</div></div></div>
</div>
@endsection
