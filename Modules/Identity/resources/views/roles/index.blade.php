@extends('core::components.layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Rôles</h4>
  <a class="btn btn-primary btn-sm" href="{{ route('identity.roles.create') }}">Nouveau rôle</a>
</div>
<div class="row g-3">
@foreach($roles as $role)
  <div class="col-md-4"><div class="stat-card"><h6>{{ $role->name }}</h6><small class="text-muted">{{ $role->users_count }} users · {{ $role->permissions_count }} permissions</small></div></div>
@endforeach
</div>
@endsection
