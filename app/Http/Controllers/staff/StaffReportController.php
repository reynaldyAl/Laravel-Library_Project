<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class StaffReportController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $loans = Loan::with('book', 'user')->get();
        return view('staff.reports.index', compact('books', 'loans'));
    }
}