<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffLoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('book', 'user', 'loanStatus')->get();
        return view('staff.loans.index', compact('loans'));
    }

    public function approveLoan(Loan $loan)
    {
        $borrowedStatus = LoanStatus::where('name', 'borrowed')->first();

        if (!$borrowedStatus) {
            return redirect()->back()->withErrors(['error' => 'Loan status not found. Please seed the database with loan statuses.']);
        }

        $loan->update([
            'is_approved' => true,
            'loan_status_id' => $borrowedStatus->id,
        ]);

        // Kurangi jumlah salinan buku yang tersedia
        $loan->book->decrement('available_copies');

        // Kirim notifikasi ke mahasiswa
        Notification::create([
            'user_id' => $loan->user_id,
            'message' => 'Your loan request for the book "' . $loan->book->title . '" has been approved.',
            'read_status' => false,
        ]);

        return redirect()->route('staff.loans.index')->with('success', 'Loan approved successfully.');
    }

    public function rejectLoan(Loan $loan)
    {
        $rejectedStatus = LoanStatus::where('name', 'rejected')->first();

        if (!$rejectedStatus) {
            return redirect()->back()->withErrors(['error' => 'Loan status not found. Please seed the database with loan statuses.']);
        }

        $loan->update([
            'loan_status_id' => $rejectedStatus->id,
        ]);

        // Kirim notifikasi ke mahasiswa
        Notification::create([
            'user_id' => $loan->user_id,
            'message' => 'Your loan request for the book "' . $loan->book->title . '" has been rejected.',
            'read_status' => false,
        ]);

        return redirect()->route('staff.loans.index')->with('success', 'Loan rejected successfully.');
    }

    public function confirmReturn(Loan $loan)
    {
        $loan->update([
            'actual_return_date' => Carbon::now(),
            'loan_status_id' => LoanStatus::where('name', 'returned')->first()->id,
            'is_returned' => true,
        ]);

        // Tambahkan jumlah salinan buku yang tersedia
        $loan->book->increment('available_copies');

        // Hitung denda jika terlambat
        $due_date = Carbon::parse($loan->due_date);
        $return_date = Carbon::parse($loan->actual_return_date);
        $overdue_days = $return_date->diffInDays($due_date, false);
        $fine = 0;

        if ($overdue_days > 0) {
            $fine = ceil($overdue_days / 2) * 5000; // Denda 5000 per 2 hari
        }

        // Kirim notifikasi ke mahasiswa
        Notification::create([
            'user_id' => $loan->user_id,
            'message' => 'Your return for the book "' . $loan->book->title . '" has been confirmed. Fine: Rp ' . $fine,
            'read_status' => false,
        ]);

        // Kirim notifikasi ke staff
        Notification::create([
            'user_id' => $loan->user_id,
            'message' => 'Mahasiswa ' . $loan->user->name . ' telah mengembalikan buku "' . $loan->book->title . '".',
            'read_status' => false,
        ]);

        return redirect()->route('staff.loans.index')->with('success', 'Book return confirmed successfully.');
    }
}