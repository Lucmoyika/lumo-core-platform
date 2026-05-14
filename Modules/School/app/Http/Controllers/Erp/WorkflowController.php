<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\School\Models\Enrollment;
use Modules\School\Services\ReportCardPdfService;
use Modules\School\Services\SchoolErpService;

class WorkflowController extends Controller
{
    public function __construct(
        protected SchoolErpService $erpService,
        protected ReportCardPdfService $pdfService,
    ) {
    }

    public function adminDashboard()
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->adminDashboardData();

        return view('school::erp.dashboard.admin', array_merge($data, compact('module')));
    }

    public function teacherDashboard(Request $request)
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->teacherDashboardData($request->integer('teacher_id'));

        return view('school::erp.dashboard.teacher', array_merge($data, compact('module')));
    }

    public function studentDashboard(Request $request)
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->studentDashboardData($request->integer('student_id'));

        return view('school::erp.dashboard.student', array_merge($data, compact('module')));
    }

    public function parentDashboard(Request $request)
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->parentDashboardData($request->integer('parent_id'));

        return view('school::erp.dashboard.parent', array_merge($data, compact('module')));
    }

    public function timetable(Request $request)
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->timetableData($request->integer('class_id'));

        return view('school::erp.timetables.index', array_merge($data, compact('module')));
    }

    public function reportCard(Request $request, int $enrollmentId)
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $period = $request->string('period', '1er trimestre')->toString();
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $data = $this->erpService->reportCardData($enrollment, $period);

        return view('school::erp.report-cards.show', array_merge($data, compact('module')));
    }

    public function reportCardPdf(Request $request, int $enrollmentId)
    {
        $period = $request->string('period', '1er trimestre')->toString();
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $data = $this->erpService->reportCardData($enrollment, $period);

        $lines = [
            'Eleve: ' . $data['enrollment']->student->full_name,
            'Classe: ' . $data['enrollment']->schoolClass->full_name,
            'Periode: ' . $period,
            'Moyenne: ' . $data['average'] . '%',
            'Rang: ' . ($data['rank'] ?? '-'),
            'Presence: ' . $data['attendance_rate'] . '%',
            'Commentaire: ' . ($data['report_card']->teacher_comment ?? '-'),
        ];

        foreach ($data['subjects'] as $subject) {
            $lines[] = sprintf('%s: %.2f%%', $subject['subject'], $subject['average']);
        }

        $pdf = $this->pdfService->make('Bulletin scolaire', $lines);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="report-card-' . $enrollmentId . '.pdf"',
        ]);
    }

    public function fees()
    {
        $module = \App\Support\Modules\ModuleRegistry::find('school');
        $data = $this->erpService->feesData();

        return view('school::erp.fees.index', array_merge($data, compact('module')));
    }

    public function generateInvoices(): RedirectResponse
    {
        $count = $this->erpService->generateInvoicesForCurrentEnrollments();

        return back()->with('status', $count . ' facture(s) générée(s).');
    }

    public function promote(Request $request): RedirectResponse
    {
        $request->validate([
            'from_class_id' => ['required', 'integer', 'exists:school_classes,id'],
            'to_class_id' => ['required', 'integer', 'exists:school_classes,id'],
            'current_year' => ['required', 'string'],
            'next_year' => ['required', 'string'],
        ]);

        $count = $this->erpService->promoteClass(
            $request->integer('from_class_id'),
            $request->integer('to_class_id'),
            $request->string('current_year')->toString(),
            $request->string('next_year')->toString(),
        );

        return back()->with('status', $count . ' élève(s) promu(s).');
    }
}
