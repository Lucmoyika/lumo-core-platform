<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\Attendance;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Grade;
use Modules\School\Models\ReportCard;
use Modules\School\Models\SchoolClass;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $classId = $request->get('class_id');
        $period = $request->get('period', '1er trimestre');
        $periods = ['1er trimestre', '2ème trimestre', '3ème trimestre', 'Annuel'];
        $reportCards = collect();

        if ($classId) {
            $enrollmentIds = Enrollment::where('school_class_id', $classId)
                ->where('status', 'active')
                ->pluck('id');

            $reportCards = ReportCard::with('enrollment.student')
                ->whereIn('enrollment_id', $enrollmentIds)
                ->where('period', $period)
                ->get();
        }

        return view('school::erp.report_cards.index', compact('module', 'classes', 'classId', 'period', 'periods', 'reportCards'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'period'   => 'required|string',
        ]);

        $enrollments = Enrollment::where('school_class_id', $request->class_id)
            ->where('status', 'active')
            ->get();

        $generated = 0;

        foreach ($enrollments as $enrollment) {
            $grades = Grade::where('enrollment_id', $enrollment->id)
                ->where('period', $request->period)
                ->get();

            if ($grades->isEmpty()) {
                continue;
            }

            $average = round($grades->avg('score'), 2);
            $absences = Attendance::where('enrollment_id', $enrollment->id)
                ->where('status', 'absent')
                ->count();

            ReportCard::updateOrCreate(
                ['enrollment_id' => $enrollment->id, 'period' => $request->period],
                [
                    'average'      => $average,
                    'absences'     => $absences,
                    'status'       => 'draft',
                    'generated_at' => now(),
                ]
            );

            $generated++;
        }

        // Compute ranks
        $cards = ReportCard::with('enrollment')
            ->whereIn('enrollment_id', $enrollments->pluck('id'))
            ->where('period', $request->period)
            ->orderByDesc('average')
            ->get();

        $total = $cards->count();

        foreach ($cards as $i => $card) {
            $card->update(['rank' => $i + 1, 'total_students' => $total]);
        }

        return redirect()->route('school.erp.report-cards.index', ['class_id' => $request->class_id, 'period' => $request->period])
            ->with('success', "$generated bulletins générés.");
    }

    public function show(ReportCard $reportCard)
    {
        $module = ModuleRegistry::find('school');
        $reportCard->load('enrollment.student', 'enrollment.schoolClass.academicProgram');

        $grades = Grade::where('enrollment_id', $reportCard->enrollment_id)
            ->where('period', $reportCard->period)
            ->orderBy('subject')
            ->get();

        return view('school::erp.report_cards.show', compact('module', 'reportCard', 'grades'));
    }

    public function publish(Request $request)
    {
        $request->validate(['class_id' => 'required', 'period' => 'required']);

        $enrollmentIds = Enrollment::where('school_class_id', $request->class_id)->pluck('id');

        ReportCard::whereIn('enrollment_id', $enrollmentIds)
            ->where('period', $request->period)
            ->update(['status' => 'published']);

        return redirect()->back()->with('success', 'Bulletins publiés.');
    }
}
