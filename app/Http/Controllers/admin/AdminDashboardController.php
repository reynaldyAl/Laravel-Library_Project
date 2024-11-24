<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil data buku berdasarkan kategori
        $booksByCategory = Book::selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->pluck('count', 'category_id');

        $categories = Category::whereIn('id', $booksByCategory->keys())->pluck('name', 'id');

        // Ambil data pengguna berdasarkan peran
        $usersByRole = User::selectRaw('role_id, COUNT(*) as count')
            ->groupBy('role_id')
            ->pluck('count', 'role_id');

        $roles = Role::whereIn('id', $usersByRole->keys())->pluck('name', 'id');

        // Ambil data pinjaman berdasarkan bulan
        $loansByMonth = Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('admin.dashboard.index', compact('booksByCategory', 'categories', 'usersByRole', 'roles', 'loansByMonth'));
    }
}