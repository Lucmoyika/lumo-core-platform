@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Créer rôle</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.roles.store') }}">
@csrf
<div class="mb-3"><label class="form-label">Nom</label><input class="form-control" name="name" required></div>
@foreach($permissions as $group => $items)
<div class="mb-2"><strong>{{ $group }}</strong><div>
@foreach($items as $permission)
<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="p{{ $permission->id }}"><label class="form-check-label" for="p{{ $permission->id }}">{{ $permission->name }}</label></div>
@endforeach
</div></div>
@endforeach
<button class="btn btn-primary">Créer</button>
</form>
</div>
@endsection
