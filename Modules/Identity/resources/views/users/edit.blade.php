@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Modifier utilisateur</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.users.update',$user) }}">
@csrf @method('PUT')
<div class="mb-2"><label class="form-label">Nom</label><input name="name" class="form-control" value="{{ old('name',$user->name) }}" required></div>
<div class="mb-2"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ old('email',$user->email) }}" required></div>
<div class="mb-2"><label class="form-label">Téléphone</label><input name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
<div class="mb-3">@foreach($roles as $role)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="re{{ $role->id }}" {{ in_array($role->name,$userRoles,true)?'checked':'' }}><label class="form-check-label" for="re{{ $role->id }}">{{ $role->name }}</label></div>@endforeach</div>
<button class="btn btn-primary">Enregistrer</button>
</form>
</div>
@endsection
