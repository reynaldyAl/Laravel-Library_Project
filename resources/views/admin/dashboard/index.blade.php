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
                <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
                <p>Welcome to the admin dashboard. Here you can manage books, users, and view reports.</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Manage Books</h5>
                                <p class="card-text">Add, edit, and delete books in the library.</p>
                                <a href="{{ route('admin.books.index') }}" class="btn btn-primary">Go to Books</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Manage Users</h5>
                                <p class="card-text">Add, edit, and delete users in the system.</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Go to Users</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">View Reports</h5>
                                <p class="card-text">View various reports and statistics.</p>
                                <a href="{{ route('admin.reports.books') }}" class="btn btn-primary">Go to Books Report</a>
                                <a href="{{ route('admin.reports.loans') }}" class="btn btn-primary">Go to Loans Report</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Books Overview</h5>
                                <canvas id="booksChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Users Overview</h5>
                                <canvas id="usersChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Loans Overview</h5>
                                <canvas id="loansChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Books Chart
            var ctxBooks = document.getElementById('booksChart').getContext('2d');
            var booksChart = new Chart(ctxBooks, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categories->values()) !!},
                    datasets: [{
                        label: 'Number of Books',
                        data: {!! json_encode($booksByCategory->values()) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Users Chart
            var ctxUsers = document.getElementById('usersChart').getContext('2d');
            var usersChart = new Chart(ctxUsers, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($roles->values()) !!},
                    datasets: [{
                        label: 'Number of Users',
                        data: {!! json_encode($usersByRole->values()) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Loans Chart
            var ctxLoans = document.getElementById('loansChart').getContext('2d');
            var loansChart = new Chart(ctxLoans, {
                type: 'line',
                data: {
                    labels: {!! json_encode($loansByMonth->keys()->map(function($month) {
                        return DateTime::createFromFormat('!m', $month)->format('F');
                    })) !!},
                    datasets: [{
                        label: 'Number of Loans',
                        data: {!! json_encode($loansByMonth->values()) !!},
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush