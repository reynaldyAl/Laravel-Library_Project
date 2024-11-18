<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after:loan_date',
        ]);

        Loan::create([
            'user_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Loan created successfully.');
    }
}