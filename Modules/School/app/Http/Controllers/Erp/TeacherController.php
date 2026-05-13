<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\School\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query()->orderBy('last_name');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        $teachers = $query->paginate(20)->withQueryString();
        $stats = [
            'total'    => Teacher::count(),
            'active'   => Teacher::where('status', 'active')->count(),
            'inactive' => Teacher::where('status', 'inactive')->count(),
        ];

        $module = \App\Support\Modules\ModuleRegistry::find('school');

        return view('school::erp.teachers.index', compact('teachers', 'stats', 'module'));
    }
}
