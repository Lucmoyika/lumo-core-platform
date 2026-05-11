@extends('core::components.layouts.master')
@section('content')
<div class="stat-card">
  <h4>{{ $role->name }}</h4>
  <div class="mb-2">Permissions: @foreach($role->permissions as $permission)<span class="badge text-bg-secondary me-1">{{ $permission->name }}</span>@endforeach</div>
  <div>Users: {{ $role->users->count() }}</div>
</div>
@endsection
