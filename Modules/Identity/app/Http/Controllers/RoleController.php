<?php

namespace Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('identity::roles.index', [
            'roles' => Role::withCount('users', 'permissions')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('identity::roles.create', [
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($permission) => explode('.', $permission->name)[0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $request->string('name'), 'guard_name' => 'web']);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('identity.roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role): View
    {
        $role->load('permissions', 'users');

        return view('identity::roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        return view('identity::roles.edit', [
            'role' => $role,
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($permission) => explode('.', $permission->name)[0]),
            'rolePermissions' => $role->permissions->pluck('name')->all(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name,'.$role->id],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->update(['name' => $request->string('name')]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('identity.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('identity.roles.index')->with('success', 'Role deleted.');
    }
}
