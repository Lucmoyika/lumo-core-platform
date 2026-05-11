@extends('core::components.layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Utilisateurs</h4>
  <a class="btn btn-primary btn-sm" href="{{ route('identity.users.create') }}">Nouveau</a>
</div>
<div class="stat-card">
  <table class="table table-sm">
    <thead><tr><th>Nom</th><th>Email</th><th>Rôles</th><th>Actions</th></tr></thead>
    <tbody>
      @foreach($users as $user)
        <tr>
          <td>{{ $user->name }}</td><td>{{ $user->email }}</td>
          <td>@foreach($user->roles as $role)<span class="badge text-bg-secondary me-1">{{ $role->name }}</span>@endforeach</td>
          <td><a class="btn btn-sm btn-outline-primary" href="{{ route('identity.users.edit',$user) }}">Edit</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $users->links() }}
</div>
@endsection
