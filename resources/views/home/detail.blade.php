@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <!-- Judul dan Penulis Buku -->
        <div class="jumbotron text-center">
            <h1 class="display-4">{{ $book->title }}</h1>
            <p class="lead">by {{ $book->author }}</p>
        </div>

        <!-- Card Buku -->
        <div class="card custom-card shadow-lg border-light rounded-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <!-- Gambar Buku -->
                    <img src="{{ asset($book->image_path) }}" class="card-img-top img-fluid" alt="{{ $book->title }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <!-- Detail Buku -->
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text"><strong>Publisher:</strong> {{ $book->publisher }}</p>
                        <p class="card-text"><strong>Published Year:</strong> {{ $book->published_year }}</p>
                        <p class="card-text"><strong>Category:</strong> {{ $book->category->name ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Available Copies:</strong> {{ $book->available_copies }}</p>
                        <p class="card-text"><strong>Total Copies:</strong> {{ $book->total_copies }}</p>

                        <!-- Button untuk Pinjam Buku -->
                        @auth
                            <a href="{{ route('mahasiswa.loans.create', ['book_id' => $book->id]) }}" class="btn btn-primary">Borrow Book</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">Login to Borrow</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Ulasan Buku -->
        <div class="mt-4">
            <h3>Reviews</h3>
            @foreach($book->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Rating: {{ $review->rating }} / 5</h5>
                        <p class="card-text">{{ $review->comment }}</p>
                        <p class="card-text"><small class="text-muted">by {{ $review->user->name }}</small></p>
                    </div>
                </div>
            @endforeach

            <!-- Form untuk Menambahkan Ulasan Baru -->
            @auth
                <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Login</a> to leave a review.</p>
            @endauth
        </div>
    </div>
@endsection