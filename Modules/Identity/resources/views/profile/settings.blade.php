@extends('core::components.layouts.master')
@section('content')
<h4 class="mb-3">Paramètres</h4>
<div class="stat-card" style="max-width: 720px;">
<form method="POST" action="{{ route('identity.settings.password') }}">
@csrf @method('PUT')
<div class="mb-2"><label class="form-label">Mot de passe actuel</label><input type="password" class="form-control" name="current_password" required></div>
<div class="mb-2"><label class="form-label">Nouveau mot de passe</label><input type="password" class="form-control" name="password" required></div>
<div class="mb-3"><label class="form-label">Confirmation</label><input type="password" class="form-control" name="password_confirmation" required></div>
<button class="btn btn-primary">Mettre à jour</button>
</form>
</div>
@endsection
