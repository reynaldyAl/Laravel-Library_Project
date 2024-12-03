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
use App\Http\Controllers\staff\StaffLoanController;
use App\Http\Controllers\mahasiswa\MahasiswaBookController;
use App\Http\Controllers\mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\mahasiswa\MahasiswaLoanController;
use App\Http\Controllers\mahasiswa\MahasiswaReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('home/{book}', [HomeController::class, 'show'])->name('home.detail');
Route::get('catalog', [HomeController::class, 'catalog'])->name('home.catalog');



// notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::get('/fetch-notifications', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');

// reviews
Route::post('reviews/{book}', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('profile', [UserController::class, 'showProfile'])->name('profile.show');
Route::get('profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::put('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', AdminBookController::class);
    Route::resource('users', AdminUserController::class);
    // Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/books', [AdminReportController::class, 'books'])->name('reports.books');
    Route::get('reports/loans', [AdminReportController::class, 'loans'])->name('reports.loans');
});

// Staff Routes
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', StaffBookController::class);
    Route::get('reports', [StaffReportController::class, 'index'])->name('reports.index');
    Route::get('loans', [StaffLoanController::class, 'index'])->name('loans.index');
    Route::post('loans/{loan}/approve', [StaffLoanController::class, 'approveLoan'])->name('loans.approve');
    Route::post('loans/{loan}/reject', [StaffLoanController::class, 'rejectLoan'])->name('loans.reject');
    Route::post('loans/{loan}/confirm-return', [StaffLoanController::class, 'confirmReturn'])->name('loans.confirmReturn');
    Route::get('reports/books', [StaffReportController::class, 'books'])->name('reports.books');
    Route::get('reports/loans', [StaffReportController::class, 'loans'])->name('reports.loans');
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('loans', [MahasiswaLoanController::class, 'index'])->name('loans.index'); // Tambahkan rute untuk melihat pinjaman
    Route::get('loans/create', [MahasiswaLoanController::class, 'create'])->name('loans.create');
    Route::post('loans', [MahasiswaLoanController::class, 'store'])->name('loans.store');
    Route::post('loans/{loan}/return', [MahasiswaLoanController::class, 'returnBook'])->name('loans.return'); // Tambahkan rute untuk mengembalikan buku
    Route::resource('books', MahasiswaBookController::class)->only(['index', 'show']);
    Route::get('reviews', [MahasiswaReviewController::class, 'index'])->name('reviews.index'); // Tambahkan rute untuk melihat ulasan
});

// General Dashboard Route
Route::get('dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role->name;
        return redirect()->route($role . '.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');