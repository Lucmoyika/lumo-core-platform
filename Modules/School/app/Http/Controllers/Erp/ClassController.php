<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\School\Models\SchoolClass;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::with(['academicProgram', 'enrollments', 'teachers'])
            ->orderBy('level')
            ->orderBy('section')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'    => SchoolClass::count(),
            'active'   => SchoolClass::where('status', 'active')->count(),
            'capacity' => SchoolClass::sum('capacity'),
        ];

        $module = \App\Support\Modules\ModuleRegistry::find('school');

        return view('school::erp.classes.index', compact('classes', 'stats', 'module'));
    }
}
