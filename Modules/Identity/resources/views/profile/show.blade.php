@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Mon profil</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.profile.update') }}">
@csrf @method('PUT')
<div class="mb-2"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name',$user->name) }}" required></div>
<div class="mb-2"><label class="form-label">Email</label><input class="form-control" name="email" type="email" value="{{ old('email',$user->email) }}" required></div>
<div class="mb-2"><label class="form-label">Téléphone</label><input class="form-control" name="phone" value="{{ old('phone',$user->phone) }}"></div>
<div class="mb-3"><label class="form-label">Langue</label><select class="form-select" name="locale"><option value="fr" @selected(($user->locale ?? 'fr')==='fr')>FR</option><option value="en" @selected(($user->locale ?? 'fr')==='en')>EN</option><option value="sw" @selected(($user->locale ?? 'fr')==='sw')>SW</option><option value="ln" @selected(($user->locale ?? 'fr')==='ln')>LN</option></select></div>
<button class="btn btn-primary">Enregistrer</button>
</form>
</div>
@endsection
