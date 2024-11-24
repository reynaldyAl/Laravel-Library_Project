<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function books()
    {
        $books = Book::all();
        return view('admin.reports.books', compact('books'));
    }

    public function loans()
    {
        $loans = Loan::with('book', 'user')->get();
        return view('admin.reports.loans', compact('loans'));
    }
}