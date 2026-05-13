<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Modules\School\Models\Enrollment;
use Modules\School\Models\FeePayment;

class AccountantDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');

        $stats = [
            'total_fees_expected' => Enrollment::sum('fee_amount'),
            'total_fees_paid'     => Enrollment::sum('fee_paid'),
            'total_balance'       => Enrollment::selectRaw('SUM(fee_amount - fee_paid)')->value('SUM(fee_amount - fee_paid)') ?? 0,
            'payments_today'      => FeePayment::whereDate('paid_at', today())->sum('amount'),
            'payments_this_month' => FeePayment::whereMonth('paid_at', now()->month)->sum('amount'),
            'unpaid_count'        => Enrollment::whereRaw('fee_paid < fee_amount')->count(),
        ];

        $recentPayments = FeePayment::with('enrollment.student')->latest('paid_at')->take(10)->get();

        return view('school::dashboards.accountant', compact('module', 'stats', 'recentPayments'));
    }
}
