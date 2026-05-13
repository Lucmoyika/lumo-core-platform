<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Modules\School\Models\Book;
use Modules\School\Models\BookLoan;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');

        $stats = [
            'total_books'    => Book::count(),
            'available_books'=> Book::where('available_copies', '>', 0)->count(),
            'active_loans'   => BookLoan::where('status', 'active')->count(),
            'overdue_loans'  => BookLoan::where('status', 'active')->where('due_date', '<', today())->count(),
            'returned_today' => BookLoan::whereDate('returned_at', today())->count(),
        ];

        $recentLoans = BookLoan::latest()->take(10)->get();
        $overdueLoans = BookLoan::where('status', 'active')->where('due_date', '<', today())->with('book')->get();

        return view('school::dashboards.librarian', compact('module', 'stats', 'recentLoans', 'overdueLoans'));
    }
}
