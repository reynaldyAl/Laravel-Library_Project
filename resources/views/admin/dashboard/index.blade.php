@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="d-flex flex-column p-3 bg-light" style="height: 100vh;">
                    <h5 class="my-3">Admin Dashboard</h5>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link active">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.books.index') }}" class="nav-link">Manage Books</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="nav-link">Manage Users</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reports.books') }}" class="nav-link">Books Report</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.reports.loans') }}" class="nav-link">Loans Report</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
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
                                <a href="{{ route('admin.reports.books') }}" class="btn btn-primary">Go to Books Report</a>
                                <a href="{{ route('admin.reports.loans') }}" class="btn btn-primary">Go to Loans Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection