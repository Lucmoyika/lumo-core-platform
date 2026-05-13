<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\AcademicYear;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Exam;
use Modules\School\Models\ExamMark;
use Modules\School\Models\SchoolClass;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['schoolClass', 'academicYear'])->latest();

        if ($classId = $request->get('class_id')) {
            $query->where('school_class_id', $classId);
        }

        $exams = $query->paginate(20);
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $module = ModuleRegistry::find('school');

        return view('school::erp.exams.index', compact('exams', 'classes', 'module'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $years = AcademicYear::orderBy('name', 'desc')->get();

        return view('school::erp.exams.create', compact('module', 'classes', 'years'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'school_class_id'  => 'required|exists:school_classes,id',
            'academic_year_id' => 'nullable|exists:school_academic_years,id',
            'subject'          => 'required|string|max:100',
            'exam_type'        => 'required|in:exam,quiz,test,project',
            'period'           => 'required|string|max:50',
            'max_score'        => 'required|numeric|min:1|max:100',
            'date'             => 'nullable|date',
            'status'           => 'required|in:scheduled,ongoing,completed,cancelled',
            'description'      => 'nullable|string',
        ]);

        Exam::create($data);

        return redirect()->route('school.erp.exams.index')->with('success', 'Examen créé.');
    }

    public function show(Exam $exam)
    {
        $module = ModuleRegistry::find('school');
        $exam->load(['schoolClass.enrollments.student', 'marks.enrollment.student']);

        $enrollments = $exam->schoolClass->enrollments()
            ->with('student')
            ->where('status', 'active')
            ->get();

        $marks = ExamMark::where('exam_id', $exam->id)->pluck('score', 'enrollment_id');
        $absents = ExamMark::where('exam_id', $exam->id)->where('is_absent', true)->pluck('is_absent', 'enrollment_id');

        return view('school::erp.exams.show', compact('module', 'exam', 'enrollments', 'marks', 'absents'));
    }

    public function storeMarks(Request $request, Exam $exam)
    {
        $request->validate([
            'marks'              => 'required|array',
            'marks.*.score'      => 'nullable|numeric|min:0',
            'marks.*.is_absent'  => 'nullable|boolean',
        ]);

        foreach ($request->marks as $enrollmentId => $markData) {
            ExamMark::updateOrCreate(
                ['exam_id' => $exam->id, 'enrollment_id' => $enrollmentId],
                [
                    'score'      => $markData['is_absent'] ?? false ? null : ($markData['score'] ?? null),
                    'is_absent'  => $markData['is_absent'] ?? false,
                    'entered_at' => now(),
                ]
            );
        }

        $exam->update(['status' => 'completed']);

        return redirect()->route('school.erp.exams.show', $exam)->with('success', 'Notes enregistrées.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('school.erp.exams.index')->with('success', 'Supprimé.');
    }
}
