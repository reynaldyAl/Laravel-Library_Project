<!-- resources/views/home/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1>Welcome to Our Library</h1>
            <p>Explore a wide range of books and resources.</p>
        </div>
        <div class="row">
            @if($books->isEmpty())
                <p>No books available.</p>
            @else
                @foreach($books as $book)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">{{ $book->author }}</p>
                                <a href="{{ route('home.detail', $book->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
