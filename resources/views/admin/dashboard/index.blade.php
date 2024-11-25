@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="d-flex flex-column p-3 bg-light border" style="height: 100vh;">
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
                <div class="p-3 border bg-white">
                    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
                    <p>Welcome to the admin dashboard. Here you can manage books, users, and view reports.</p>
                    
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/book.png" alt="Books Icon">
                                <h5 class="card-title mt-2">Total Books</h5>
                                <p class="card-text">{{ $totalBooks }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/admin-settings-male.png" alt="Admin Icon">
                                <h5 class="card-title mt-2">Total Admins</h5>
                                <p class="card-text">{{ $totalAdmins }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/staff.png" alt="Staff Icon">
                                <h5 class="card-title mt-2">Total Staff</h5>
                                <p class="card-text">{{ $totalStaff }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/student-male.png" alt="Mahasiswa Icon">
                                <h5 class="card-title mt-2">Total Mahasiswa</h5>
                                <p class="card-text">{{ $totalMahasiswa }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Users by Role</h5>
                                <div id="usersChart" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Books Overview</h5>
                                <div id="booksChart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Loans Overview</h5>
                                <div id="loansChart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data dari server -->
    <script id="usersData" type="application/json">
        {!! json_encode($roles->map(function($role, $key) use ($usersByRole) {
            return ['value' => $usersByRole[$key], 'name' => $role];
        })->values()) !!}
    </script>
    <script id="booksData" type="application/json">
        {!! json_encode(['categories' => $categories->values(), 'counts' => $booksByCategory->values()]) !!}
    </script>
    <script id="loansData" type="application/json">
        {!! json_encode(['dates' => $loansByDate->keys(), 'counts' => $loansByDate->values()]) !!}
    </script>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endpush