@extends('core::components.layouts.master')
@section('content')
<div class="stat-card">
    <h4>{{ $user->name }}</h4>
    <p class="mb-1">{{ $user->email }}</p>
    <p class="mb-1">{{ $user->phone }}</p>
    <div>@foreach($user->roles as $role)<span class="badge text-bg-secondary me-1">{{ $role->name }}</span>@endforeach</div>
</div>
@endsection
