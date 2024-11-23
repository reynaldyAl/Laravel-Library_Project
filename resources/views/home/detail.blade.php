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
                    <img src="{{ asset($book->image_path) }}" class="card-img-top img-fluid book-image" alt="{{ $book->title }}">
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
                        <h5 class="card-title">
                            Rating: 
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </h5>
                        <p class="card-text">{{ $review->comment }}</p>
                        <p class="card-text"><small class="text-muted">by {{ $review->user->name }}</small></p>
                        @if(Auth::id() === $review->user_id)
                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Form untuk Menambahkan Ulasan Baru -->
            @auth
                <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <div class="rating">
                            <input type="radio" name="rating" id="rating-5" value="5"><label for="rating-5" class="fas fa-star"></label>
                            <input type="radio" name="rating" id="rating-4" value="4"><label for="rating-4" class="fas fa-star"></label>
                            <input type="radio" name="rating" id="rating-3" value="3"><label for="rating-3" class="fas fa-star"></label>
                            <input type="radio" name="rating" id="rating-2" value="2"><label for="rating-2" class="fas fa-star"></label>
                            <input type="radio" name="rating" id="rating-1" value="1"><label for="rating-1" class="fas fa-star"></label>
                        </div>
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

@push('styles')
    <style>
        .book-image {
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffc107;
        }
    </style>
@endpush