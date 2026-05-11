<?php

namespace Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
        ];

        $recentUsers = User::with('roles')->latest()->limit(10)->get();

        return view('identity::dashboard.index', [
            'user' => Auth::user(),
            'stats' => $stats,
            'recentUsers' => $recentUsers,
        ]);
    }
}
