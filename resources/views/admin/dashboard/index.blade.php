<!-- resources/views/admin/dashboard/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin dashboard. Here you can manage books, users, and view reports.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Books</h5>
                        <p class="card-text">Add, edit, and delete books in the library.</p>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-primary">Go to Books</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">Add, edit, and delete users in the system.</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Go to Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Reports</h5>
                        <p class="card-text">View various reports and statistics.</p>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">Go to Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection