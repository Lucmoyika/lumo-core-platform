<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\Book;
use Modules\School\Models\BookLoan;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $query = Book::query();

        if ($search = $request->get('q')) {
            $query->where('title', 'like', "%$search%")->orWhere('author', 'like', "%$search%");
        }

        $books = $query->orderBy('title')->paginate(20)->withQueryString();

        $stats = [
            'total'     => Book::count(),
            'available' => Book::where('available_copies', '>', 0)->count(),
            'loaned'    => BookLoan::where('status', 'active')->count(),
            'overdue'   => BookLoan::where('status', 'active')->where('due_date', '<', today())->count(),
        ];

        return view('school::erp.library.index', compact('module', 'books', 'stats'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');

        return view('school::erp.library.create', compact('module'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn'             => 'nullable|string|max:20|unique:school_books',
            'title'            => 'required|string|max:200',
            'author'           => 'required|string|max:150',
            'publisher'        => 'nullable|string|max:150',
            'edition'          => 'nullable|string|max:50',
            'subject'          => 'nullable|string|max:100',
            'total_copies'     => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'location'         => 'nullable|string|max:100',
            'is_active'        => 'boolean',
        ]);

        Book::create($data);

        return redirect()->route('school.erp.library.index')->with('success', 'Livre ajouté.');
    }

    public function loans(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $loans = BookLoan::with('book')->latest()->paginate(20);

        return view('school::erp.library.loans', compact('module', 'loans'));
    }

    public function createLoan(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();

        return view('school::erp.library.create_loan', compact('module', 'books'));
    }

    public function storeLoan(Request $request)
    {
        $data = $request->validate([
            'book_id'       => 'required|exists:school_books,id',
            'borrower_type' => 'required|in:student,teacher,staff',
            'borrower_id'   => 'required|integer',
            'loan_date'     => 'required|date',
            'due_date'      => 'required|date|after:loan_date',
            'notes'         => 'nullable|string',
        ]);

        $loan = BookLoan::create(array_merge($data, ['status' => 'active']));
        $loan->book->decrement('available_copies');

        return redirect()->route('school.erp.library.loans')->with('success', 'Emprunt enregistré.');
    }

    public function returnBook(Request $request, BookLoan $loan)
    {
        $loan->update(['returned_at' => today(), 'status' => 'returned']);
        $loan->book->increment('available_copies');

        return redirect()->back()->with('success', 'Livre retourné.');
    }
}
