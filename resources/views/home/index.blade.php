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
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">{{ $book->author }}</p>
                                <p class="card-text">Rating: {{ $book->reviews->avg('rating') }} / 5</p>
                                <a href="{{ route('home.detail', $book->id) }}" class="btn btn-primary">View Details</a>
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
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">{{ $book->author }}</p>
                                <p class="card-text">Rating: {{ $book->reviews->avg('rating') }} / 5</p>
                                <a href="{{ route('home.detail', $book->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection