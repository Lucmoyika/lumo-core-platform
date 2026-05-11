<?php

namespace App\Support\Modules;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BaseModulePolicy
{
    public function viewAny(?User $user = null): bool
    {
        return true;
    }

    public function view(?User $user = null, ?Model $model = null): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'manager']);
    }

    public function update(User $user, ?Model $model = null): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, ?Model $model = null): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }
}
