@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <!-- Sidebar Toggle Button -->
                <button class="btn btn-primary d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="col-md-3 col-sm-12" id="sidebarContainer">
                <!-- Sidebar -->
                <div class="d-flex flex-column p-3 bg-light border" id="sidebar" style="min-width: 250px;">
                    <h5 class="my-3">Staff Dashboard</h5>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('staff.dashboard') }}" class="nav-link active">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('staff.books.index') }}" class="nav-link">Manage Books</a>
                        </li>
                        <li>
                            <a href="{{ route('staff.loans.index') }}" class="nav-link">Manage Loans</a>
                        </li>
                        <li>
                            <a href="{{ route('staff.reports.books') }}" class="nav-link">Books Report</a>
                        </li>
                        <li>
                            <a href="{{ route('staff.reports.loans') }}" class="nav-link">Loans Report</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-sm-12" id="mainContent">
                <div class="p-3 border bg-white">
                    <h1 class="text-2xl font-bold mb-4">Staff Dashboard</h1>
                    <p>Welcome to the staff dashboard. Here you can manage books and view reports.</p>
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/book.png" alt="Books Icon">
                                <h5 class="card-title mt-2">Total Books</h5>
                                <p class="card-text">{{ $totalBooks }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/student-male.png" alt="Mahasiswa Icon">
                                <h5 class="card-title mt-2">Total Mahasiswa</h5>
                                <p class="card-text">{{ $totalMahasiswa }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Users by Role</h5>
                                <div id="usersChart" class="chart-container" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Books Overview</h5>
                                <div id="booksChart" class="chart-container" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Loans Overview</h5>
                                <div id="loansChart" class="chart-container" style="height: 400px;"></div>
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
            return ['value' => $usersByRole[$role], 'name' => $role];
        })->values()) !!}
    </script>
    <script id="booksData" type="application/json">
        {!! json_encode(['categories' => $categories->values(), 'counts' => $booksByCategory->values()]) !!}
    </script>
    <script id="loansData" type="application/json">
        {!! json_encode(['dates' => $loansByDate->keys(), 'counts' => $loansByDate->values()]) !!}
    </script>
@endsection

@push('styles')
    <style>
        .chart-container {
            width: 100%;
            height: 100%;
        }
        #sidebarContainer {
            transition: max-height 0.3s ease;
        }
        #sidebarContainer.collapsed {
            max-height: 0;
            overflow: hidden;
        }
        #mainContent {
            transition: margin-top 0.3s ease;
        }
        #mainContent.expanded {
            margin-top: 0;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var usersData = JSON.parse(document.getElementById('usersData').textContent);
            var booksData = JSON.parse(document.getElementById('booksData').textContent);
            var loansData = JSON.parse(document.getElementById('loansData').textContent);

            var usersChart = echarts.init(document.getElementById('usersChart'));
            var booksChart = echarts.init(document.getElementById('booksChart'));
            var loansChart = echarts.init(document.getElementById('loansChart'));

            var usersOption = {
                title: {
                    text: 'Users by Role'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    top: '5%',
                    left: 'center'
                },
                series: [
                    {
                        name: 'Users',
                        type: 'pie',
                        radius: '50%',
                        data: usersData,
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };

            var booksOption = {
                title: {
                    text: 'Books Overview'
                },
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: booksData.categories
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        data: booksData.counts,
                        type: 'bar'
                    }
                ]
            };

            var loansOption = {
                title: {
                    text: 'Loans Overview'
                },
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: loansData.dates
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        data: loansData.counts,
                        type: 'line'
                    }
                ]
            };

            usersChart.setOption(usersOption);
            booksChart.setOption(booksOption);
            loansChart.setOption(loansOption);

            // Make charts responsive
            window.addEventListener('resize', function() {
                usersChart.resize();
                booksChart.resize();
                loansChart.resize();
            });

            // Toggle sidebar
            document.getElementById('sidebarToggle').addEventListener('click', function () {
                var sidebarContainer = document.getElementById('sidebarContainer');
                var mainContent = document.getElementById('mainContent');
                sidebarContainer.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        });
    </script>
@endpush