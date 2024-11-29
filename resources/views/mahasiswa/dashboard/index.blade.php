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
                <div class="d-flex flex-column p-3 bg-light border" id="sidebar">
                    <h5 class="my-3">Mahasiswa Dashboard</h5>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link active">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.books.index') }}" class="nav-link">View Books</a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.loans.index') }}" class="nav-link">My Loans</a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.reviews.index') }}" class="nav-link">My Reviews</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-sm-12" id="mainContent">
                <div class="p-3 border bg-white">
                    <h1 class="text-2xl font-bold mb-4">Mahasiswa Dashboard</h1>
                    <p>Welcome to your dashboard. Here you can view your borrowed books, loans, and reviews.</p>
                    
                    <div class="row">
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/book.png" alt="Books Icon">
                                <h5 class="card-title mt-2">Total Books Borrowed</h5>
                                <p class="card-text">{{ $totalBooksBorrowed }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="p-3 border bg-light text-center">
                                <img src="https://img.icons8.com/ios-filled/50/000000/comments.png" alt="Reviews Icon">
                                <h5 class="card-title mt-2">Total Reviews</h5>
                                <p class="card-text">{{ $totalReviews }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light">
                                <h5 class="card-title">Books Borrowed Over Time</h5>
                                <div id="loansChart" class="chart-container" style="height: 300px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="p-3 border bg-light" style="max-height: 300px; overflow-y: auto;">
                                <h5 class="card-title sticky-top bg-light">Books Borrowed</h5>
                                <ul class="list-group">
                                    @foreach($booksBorrowed as $loan)
                                        <li class="list-group-item">{{ $loan->book->title }} (Borrowed on: {{ $loan->loan_date }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-4">
                            <div class="p-3 border bg-light" style="max-height: 300px; overflow-y: auto;">
                                <h5 class="card-title sticky-top bg-light">My Reviews</h5>
                                <ul class="list-group">
                                    @foreach($reviews as $review)
                                        <li class="list-group-item">
                                            <img src="https://img.icons8.com/ios-filled/50/000000/comments.png" alt="Comments Icon">
                                            <strong>{{ $review->book->title }}</strong>: {{ $review->comment }} (Rating: {{ $review->rating }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data dari server -->
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
            var loansData = JSON.parse(document.getElementById('loansData').textContent);
            var loansChart = echarts.init(document.getElementById('loansChart'));

            var loansOption = {
                title: {
                    text: 'Books Borrowed Over Time'
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
                series: [{
                    data: loansData.counts,
                    type: 'line'
                }]
            };

            loansChart.setOption(loansOption);

            // Make charts responsive
            window.addEventListener('resize', function() {
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