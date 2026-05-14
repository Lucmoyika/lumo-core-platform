<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\School\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->orderBy('last_name')->orderBy('first_name');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $students = $query->paginate(20)->withQueryString();
        $stats = [
            'total'     => Student::count(),
            'active'    => Student::where('status', 'active')->count(),
            'suspended' => Student::where('status', 'suspended')->count(),
        ];

        $module = \App\Support\Modules\ModuleRegistry::find('school');

        return view('school::erp.students.index', compact('students', 'stats', 'module'));
    }

    public function show(int $id)
    {
        $student = Student::with([
            'enrollments.schoolClass.academicProgram',
            'enrollments.grades',
            'enrollments.attendances',
            'enrollments.reportCards',
            'enrollments.invoices',
        ])->findOrFail($id);
        $module = \App\Support\Modules\ModuleRegistry::find('school');

        return view('school::erp.students.show', compact('student', 'module'));
    }
}
