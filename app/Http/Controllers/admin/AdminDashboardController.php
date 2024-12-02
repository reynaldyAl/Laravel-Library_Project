<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Cek apakah pengguna adalah admin
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        

        // Ambil data buku berdasarkan kategori
        $booksByCategory = Book::selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        $categories = Category::whereIn('id', $booksByCategory->keys())->pluck('name', 'id');

        // Ambil total buku
        $totalBooks = Book::count();

        // Ambil data pengguna berdasarkan peran
        $usersByRole = User::selectRaw('role_id, COUNT(*) as count')
            ->groupBy('role_id')
            ->pluck('count', 'role_id');

        $roles = Role::whereIn('id', $usersByRole->keys())->pluck('name', 'id');

        // Ambil total pengguna berdasarkan peran
        $totalAdmins = User::where('role_id', Role::where('name', 'admin')->first()->id)->count();
        $totalStaff = User::where('role_id', Role::where('name', 'staff')->first()->id)->count();
        $totalMahasiswa = User::where('role_id', Role::where('name', 'mahasiswa')->first()->id)->count();

        // Ambil data pinjaman berdasarkan tanggal pinjaman
        $loansByDate = Loan::selectRaw('DATE(loan_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return view('admin.dashboard.index', compact('booksByCategory', 'categories', 'totalBooks', 'totalAdmins', 'totalStaff', 'totalMahasiswa', 'usersByRole', 'roles', 'loansByDate'));
    }
}