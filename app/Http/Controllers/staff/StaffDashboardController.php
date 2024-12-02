<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class StaffDashboardController extends Controller
{
    public function index()
    {   

        if (!Auth::check() || Auth::user()->role->name !== 'staff') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $totalBooks = Book::count();
        $totalMahasiswa = User::whereHas('role', function ($query) {
            $query->where('name', 'mahasiswa');
        })->count();

        // Only include roles 'staff' and 'mahasiswa'
        $roles = User::select('roles.name')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['staff', 'mahasiswa'])
            ->groupBy('roles.name')
            ->pluck('roles.name');

        $usersByRole = User::select(DB::raw('count(*) as count, roles.name'))
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['staff', 'mahasiswa'])
            ->groupBy('roles.name')
            ->pluck('count', 'roles.name');

        $categories = Book::select('categories.name')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->pluck('categories.name');

        $booksByCategory = Book::select(DB::raw('count(*) as count, categories.name'))
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->pluck('count', 'categories.name');

        $loansByDate = Loan::select(DB::raw('count(*) as count, DATE(loan_date) as date'))
            ->groupBy('date')
            ->pluck('count', 'date');

        return view('staff.dashboard.index', compact(
            'totalBooks',
            'totalMahasiswa',
            'roles',
            'usersByRole',
            'categories',
            'booksByCategory',
            'loansByDate'
        ));
    }
}