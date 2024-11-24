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
                                <canvas id="usersChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Books Overview</h5>
                                <canvas id="booksChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="p-3 border bg-light">
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
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
            var loansLabels = {!! json_encode($loansByDate->keys()) !!};
            var loansData = {!! json_encode($loansByDate->values()) !!};
            console.log('Loans Labels:', loansLabels);
            console.log('Loans Data:', loansData);

            var loansChart = new Chart(ctxLoans, {
                type: 'line',
                data: {
                    labels: loansLabels,
                    datasets: [{
                        label: 'Number of Loans',
                        data: loansData,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'll'
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Loans'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush