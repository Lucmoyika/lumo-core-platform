<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\AcademicProgram;
use Modules\School\Models\Enrollment;
use Modules\School\Models\FeePayment;
use Modules\School\Models\FeeStructure;

class FeeController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');
        $structures = FeeStructure::with('academicProgram')->orderBy('academic_year', 'desc')->paginate(20);

        return view('school::erp.fees.index', compact('module', 'structures'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');
        $programs = AcademicProgram::where('status', 'active')->get();

        return view('school::erp.fees.create', compact('module', 'programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:100',
            'academic_program_id' => 'required|exists:academic_programs,id',
            'academic_year'       => 'required|string|max:20',
            'amount'              => 'required|numeric|min:0',
            'currency'            => 'required|string|max:3',
            'fee_type'            => 'required|in:tuition,registration,uniform,book,activity,transport,other',
            'due_date'            => 'nullable|date',
            'is_mandatory'        => 'boolean',
            'description'         => 'nullable|string',
        ]);

        FeeStructure::create($data);

        return redirect()->route('school.erp.fees.index')->with('success', 'Structure de frais créée.');
    }

    public function payments()
    {
        $module = ModuleRegistry::find('school');
        $payments = FeePayment::with('enrollment.student')->latest('paid_at')->paginate(20);

        $stats = [
            'total'      => FeePayment::sum('amount'),
            'today'      => FeePayment::whereDate('paid_at', today())->sum('amount'),
            'this_month' => FeePayment::whereMonth('paid_at', now()->month)->sum('amount'),
        ];

        return view('school::erp.fees.payments', compact('module', 'payments', 'stats'));
    }

    public function createPayment()
    {
        $module = ModuleRegistry::find('school');
        $enrollments = Enrollment::with('student', 'schoolClass')->where('status', 'active')->get();
        $feeStructures = FeeStructure::all();

        return view('school::erp.fees.create_payment', compact('module', 'enrollments', 'feeStructures'));
    }

    public function recordPayment(Request $request)
    {
        $data = $request->validate([
            'enrollment_id'    => 'required|exists:school_enrollments,id',
            'fee_structure_id' => 'nullable|exists:school_fee_structures,id',
            'amount'           => 'required|numeric|min:1',
            'currency'         => 'required|string|max:3',
            'payment_method'   => 'required|in:cash,bank,mobile_money',
            'reference'        => 'nullable|string|max:100',
            'paid_at'          => 'required|date',
            'received_by'      => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);

        FeePayment::create($data);

        $enrollment = Enrollment::find($data['enrollment_id']);
        $enrollment->increment('fee_paid', $data['amount']);

        return redirect()->route('school.erp.fees.payments')->with('success', 'Paiement enregistré.');
    }
}
