@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Modifier rôle</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.roles.update',$role) }}">
@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name',$role->name) }}" required></div>
@foreach($permissions as $group => $items)
<div class="mb-2"><strong>{{ $group }}</strong><div>
@foreach($items as $permission)
<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="ep{{ $permission->id }}" {{ in_array($permission->name,$rolePermissions,true)?'checked':'' }}><label class="form-check-label" for="ep{{ $permission->id }}">{{ $permission->name }}</label></div>
@endforeach
</div></div>
@endforeach
<button class="btn btn-primary">Enregistrer</button>
</form>
</div>
@endsection
