<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class StaffReportController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return view('staff.reports.index');
    }

    public function books()
    {   

        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $books = Book::all();
        return view('staff.reports.books', compact('books'));
    }

    public function loans()
    {   
        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        
        $loans = Loan::with('book', 'user')->get();
        return view('staff.reports.loans', compact('loans'));
    }
}