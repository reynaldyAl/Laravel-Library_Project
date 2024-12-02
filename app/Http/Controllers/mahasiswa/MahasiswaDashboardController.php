<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        //cek apakah user yang login adalah mahasiswa
        if (!Auth::check() || Auth::user()->role->name !== 'mahasiswa') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $user = Auth::user();

        // Ambil data buku yang dipinjam oleh mahasiswa
        $booksBorrowed = Loan::where('user_id', $user->id)->with('book')->get();
        $totalBooksBorrowed = $booksBorrowed->count();

        // Ambil data buku yang dipinjam berdasarkan tanggal
        $loansByDate = Loan::where('user_id', $user->id)
            ->selectRaw('DATE(loan_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Ambil data review yang diberikan oleh mahasiswa
        $reviews = Review::where('user_id', $user->id)->with('book')->get();
        $totalReviews = $reviews->count();

        return view('mahasiswa.dashboard.index', compact('totalBooksBorrowed', 'loansByDate', 'totalReviews', 'booksBorrowed', 'reviews'));
    }
}