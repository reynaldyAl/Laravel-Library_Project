<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaLoanController extends Controller
{
    public function create(Request $request)
    {
        $books = Book::all();
        return view('mahasiswa.loans.create', compact('books'));
    }

    public function store(Request $request)
    {
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

        $borrowedStatus = LoanStatus::where('name', 'borrowed')->first();
        $overdueStatus = LoanStatus::where('name', 'overdue')->first();

        if (!$borrowedStatus || !$overdueStatus) {
            return redirect()->back()->withErrors(['error' => 'Loan status not found. Please seed the database with loan statuses.']);
        }

        $loan_status_id = $borrowedStatus->id;

        if ($return_date->greaterThan($due_date)) {
            $loan_status_id = $overdueStatus->id;
        }

        // Kurangi jumlah salinan buku yang tersedia
        $book->decrement('available_copies');

        Loan::create([
            'user_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
            'due_date' => $due_date,
            'loan_status_id' => $loan_status_id,
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Loan created successfully.');
    }

    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())->with('book', 'loanStatus')->get();
        return view('mahasiswa.loans.index', compact('loans'));
    }

    public function returnBook(Loan $loan)
    {
        $loan->update([
            'return_date' => Carbon::now(),
            'loan_status_id' => LoanStatus::where('name', 'returned')->first()->id,
        ]);

        // Tambahkan jumlah salinan buku yang tersedia
        $loan->book->increment('available_copies');

        return redirect()->route('mahasiswa.loans.index')->with('success', 'Book returned successfully.');
    }
}