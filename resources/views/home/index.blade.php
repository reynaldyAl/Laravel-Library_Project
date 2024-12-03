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
                                        <p class="card-text">{{ Str::limit($book->synopsis, 100) }}</p> <!-- Menampilkan sinopsis -->
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
                                        <p class="card-text">{{ Str::limit($book->synopsis, 100) }}</p> <!-- Menampilkan sinopsis -->
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
        /* Hero Section */
    .jumbotron {
    background: linear-gradient(135deg, #000000, #0984e3);
    color: white;
    padding: 4rem 2rem;
    border-radius: 15px;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}

    .jumbotron::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h20v20H0V0zm10 10h10v10H10V10z" fill="rgba(255,255,255,0.05)"/></svg>');
    opacity: 0.1;
    z-index: -1;
}

.jumbotron .btn-primary {
    position: relative;
    z-index: 2;
}

/* Search and Content */
.input-group {
    position: relative;
    z-index: 1;
}

.container {
    position: relative;
    z-index: 1;
}

/* Button Styles */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
    transform: translateY(-1px);
}

.jumbotron .btn-primary {
    padding: 0.8rem 2rem;
    font-size: 1rem;
    border-radius: 8px;
}

/* Book Cards */
.book-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
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

</style>
@endpush