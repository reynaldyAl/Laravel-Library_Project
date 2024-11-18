<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\AdminBookController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminReportController;
use App\Http\Controllers\staff\StaffBookController;
use App\Http\Controllers\staff\StaffDashboardController;
use App\Http\Controllers\staff\StaffReportController;
use App\Http\Controllers\mahasiswa\MahasiswaBookController;
use App\Http\Controllers\mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\mahasiswa\MahasiswaLoanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('home/{book}', [HomeController::class, 'show'])->name('home.detail');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', AdminBookController::class);
    Route::resource('users', AdminUserController::class);
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
});

// Staff Routes
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', StaffBookController::class);
    Route::get('reports', [StaffReportController::class, 'index'])->name('reports.index');
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('loans', [MahasiswaLoanController::class, 'index'])->name('loans.index'); // Tambahkan rute untuk melihat pinjaman
    Route::get('loans/create', [MahasiswaLoanController::class, 'create'])->name('loans.create');
    Route::post('loans', [MahasiswaLoanController::class, 'store'])->name('loans.store');
    Route::resource('books', MahasiswaBookController::class)->only(['index', 'show']);
});

// General Dashboard Route
Route::get('dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->name;
        return redirect()->route($role . '.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');