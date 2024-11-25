@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1>Welcome to Our Library</h1>
            <p>Explore a wide range of books and resources.</p>
            <a href="{{ route('home.catalog') }}" class="btn btn-primary">View Book Catalog</a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('home') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by title or author" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Buku Terbaru -->
        <h2>New Arrivals</h2>
        <div class="row">
            @if($books->isEmpty())
                <p>No new books available.</p>
            @else
                @foreach($books as $book)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 book-card">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ asset($book->image_path) }}" class="card-img book-image" alt="{{ $book->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <p class="card-text">{{ $book->author }}</p>
                                        <p class="card-text">
                                            Rating: 
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($book->reviews->avg('rating')))
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </p>
                                        <a href="{{ route('home.detail', $book->id) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        

        <!-- Buku Populer -->
        <h2>Popular Books</h2>
        <div class="row">
            @if($popularBooks->isEmpty())
                <p>No popular books available.</p>
            @else
                @foreach($popularBooks as $book)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 book-card">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ asset($book->image_path) }}" class="card-img book-image" alt="{{ $book->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <p class="card-text">{{ $book->author }}</p>
                                        <p class="card-text">
                                            Rating: 
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($book->reviews->avg('rating')))
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </p>
                                        <a href="{{ route('home.detail', $book->id) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .book-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .book-image {
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
@endpush