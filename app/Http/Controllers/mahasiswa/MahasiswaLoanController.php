<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\Notification;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaLoanController extends Controller
{
    public function index()
    {

        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $loans = Loan::where('user_id', Auth::id())->with('book', 'loanStatus')->get();
        return view('mahasiswa.loans.index', compact('loans'));
    }

    public function create()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $books = Book::all();
        return view('mahasiswa.loans.create', compact('books'));
    }

    public function store(Request $request)
    {
        
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date|after_or_equal:today', // Validasi loan_date tidak di masa lalu
            'return_date' => 'required|date|after:loan_date',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek apakah buku tersedia
        if ($book->available_copies < 1) {
            return redirect()->back()->withErrors(['error' => 'Book is not available for loan.']);
        }

        // Cek apakah pengguna sudah meminjam buku yang sama
        $existingLoan = Loan::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->whereNull('return_date')
            ->first();

        if ($existingLoan) {
            return redirect()->back()->withErrors(['error' => 'You have already borrowed this book. Please return it before borrowing again.']);
        }

        $loan_date = Carbon::parse($request->loan_date);
        $due_date = $loan_date->copy()->addDays(14); // Hitung due_date otomatis (misalnya, 14 hari dari loan_date)
        $return_date = Carbon::parse($request->return_date);

        $waitingStatus = LoanStatus::where('name', 'waiting')->first();
        $overdueStatus = LoanStatus::where('name', 'overdue')->first();

        if (!$waitingStatus || !$overdueStatus) {
            return redirect()->back()->withErrors(['error' => 'Loan status not found. Please seed the database with loan statuses.']);
        }

        $loan_status_id = $waitingStatus->id;

        if ($return_date->greaterThan($due_date)) {
            $loan_status_id = $overdueStatus->id;
        }

        Loan::create([
            'user_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
            'due_date' => $due_date,
            'loan_status_id' => $loan_status_id,
            'is_approved' => false, 
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Loan request created successfully. Please wait for approval.');
    }

    public function returnBook(Request $request, $id)
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $loan = Loan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Kirim notifikasi ke staff
        $staffRole = Role::where('name', 'staff')->first();
        $staffUsers = $staffRole->users;

        foreach ($staffUsers as $staff) {
            Notification::create([
                'user_id' => $staff->id,    
                'message' => 'Mahasiswa ' . Auth::user()->name . ' ingin mengembalikan buku "' . $loan->book->title . '".',
                'read_status' => false,
            ]);
        }

        // pinjam buku
        $waitingReturnStatus = LoanStatus::where('name', 'waiting')->first();
        $loan->update([
            'loan_status_id' => $waitingReturnStatus->id,
        ]);

        return redirect()->back()->with('success', 'Book return request sent successfully. Please wait for staff confirmation.');
    }
}   