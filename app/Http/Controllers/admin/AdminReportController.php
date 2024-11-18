<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $loans = Loan::with('book', 'user')->get();
        return view('admin.reports.index', compact('books', 'loans'));
    }
}