<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;

class StaffReportController extends Controller
{
    public function index()
    {
        return view('staff.reports.index');
    }

    public function books()
    {
        $books = Book::all();
        return view('staff.reports.books', compact('books'));
    }

    public function loans()
    {
        $loans = Loan::with('book', 'user')->get();
        return view('staff.reports.loans', compact('loans'));
    }
}