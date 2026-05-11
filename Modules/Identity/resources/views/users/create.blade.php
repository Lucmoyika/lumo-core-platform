@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Créer un utilisateur</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.users.store') }}">
@csrf
<div class="mb-2"><label class="form-label">Nom</label><input name="name" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Téléphone</label><input name="phone" class="form-control"></div>
<div class="mb-2"><label class="form-label">Mot de passe</label><input name="password" type="password" class="form-control" required></div>
<div class="mb-2"><label class="form-label">Confirmer</label><input name="password_confirmation" type="password" class="form-control" required></div>
<div class="mb-3">@foreach($roles as $role)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="r{{ $role->id }}"><label class="form-check-label" for="r{{ $role->id }}">{{ $role->name }}</label></div>@endforeach</div>
<button class="btn btn-primary">Créer</button>
</form>
</div>
@endsection
