<!-- resources/views/staff/dashboard/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Staff Dashboard</h1>
        <p>Welcome to the staff dashboard. Here you can manage books and view reports.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Books</h5>
                        <p class="card-text">Add, edit, and delete books in the library.</p>
                        <a href="{{ route('staff.books.index') }}" class="btn btn-primary">Go to Books</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Loans</h5>
                        <p class="card-text">Approve and manage book loans.</p>
                        <a href="{{ route('staff.loans.index') }}" class="btn btn-primary">Go to Loans</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Reports</h5>
                        <p class="card-text">View various reports and statistics.</p>
                        <a href="{{ route('staff.reports.index') }}" class="btn btn-primary">Go to Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection