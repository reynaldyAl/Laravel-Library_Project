<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function books()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $books = Book::all();
        return view('admin.reports.books', compact('books'));
    }

    public function loans()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $loans = Loan::with('book', 'user')->get();
        return view('admin.reports.loans', compact('loans'));
    }
}