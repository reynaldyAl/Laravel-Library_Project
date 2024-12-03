@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Book Header -->
    <div class="book-header mb-5 text-center">
        <h1 class="display-4 fw-bold text-gradient">{{ $book->title }}</h1>
        <p class="lead text-muted">by {{ $book->author }}</p>
    </div>

    <!-- Book Details Card -->
    <div class="book-detail-card">
        <div class="row g-0">
            <div class="col-md-4 book-image-container">
                <img src="{{ asset($book->image_path) }}" alt="{{ $book->title }}" class="book-cover-image">
            </div>
            <div class="col-md-8">
                <div class="book-info p-4">
                    <div class="book-meta mb-4">
                        <span class="badge bg-primary">{{ $book->category->name ?? 'N/A' }}</span>
                        <span class="badge bg-info">{{ $book->published_year }}</span>
                    </div>
                    <h5 class="publisher mb-3">{{ $book->publisher }}</h5>
                    <div class="availability mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-book me-2"></i>
                            <span>{{ $book->available_copies }} of {{ $book->total_copies }} copies available</span>
                        </div>
                    </div>
                    <div class="synopsis mb-4">
                        <h5 class="fw-bold mb-2">Synopsis</h5>
                        <p class="text-muted">{{ $book->synopsis }}</p>
                    </div>
                    @auth
                        <a href="{{ route('mahasiswa.loans.create', ['book_id' => $book->id]) }}" 
                           class="btn btn-primary btn-lg borrow-btn">
                            <i class="fas fa-book-reader me-2"></i>Borrow Now
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Borrow
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section mt-5">
        <h3 class="section-title mb-4">Reader Reviews</h3>
        
        <!-- Reviews List -->
        <div class="reviews-list">
            @foreach($book->reviews as $review)
            <div class="review-card mb-3">
                <div class="review-header">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="reviewer-info ms-3">
                            <h6 class="mb-0">{{ $review->user->name }}</h6>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="review-content mt-3">
                    <p>{{ $review->comment }}</p>
                </div>
                @if(Auth::id() === $review->user_id)
                <div class="review-actions mt-2">
                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Review Form -->
        @auth
        <div class="review-form-card mt-4">
            <h5 class="mb-3">Write a Review</h5>
            <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Your Rating</label>
                    <div class="star-rating">
                        @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                        @endfor
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Your Review</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" 
                              placeholder="Share your thoughts about this book..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Submit Review
                </button>
            </form>
        </div>
        @else
        <div class="login-prompt text-center p-4">
            <p class="mb-2">Want to share your thoughts?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Review
            </a>
        </div>
        @endauth
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Enhanced Layout & Typography */
.container {
    max-width: 1140px;
    margin: 0 auto;
}

.book-header {
    position: relative;
    padding: 2rem 0 3rem;
}

.book-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(45deg, #2937f0, #9f1ae2);
    border-radius: 3px;
}

.text-gradient {
    background: linear-gradient(45deg, #2937f0, #9f1ae2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 2.5rem;
    letter-spacing: -0.5px;
    margin-bottom: 0.5rem;
}

/* Book Card Refinements */
.book-detail-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.book-image-container {
    height: 450px;
    padding: 0rem;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.book-cover-image {
    max-height: 100%;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.book-cover-image:hover {
    transform: scale(1.02);
}

.book-info {
    position: relative;
    min-height: 450px;
    padding: 2rem !important;
    padding-bottom: 90px !important;
}

/* Book Meta Information */
.book-meta .badge {
    padding: 6px 12px;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.availability {
    background: #e3f2fd;
    color: #1565c0;
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
}

.synopsis {
    background: #f8f9fa;
    padding: 1.2rem;
    border-radius: 8px;
    margin-bottom: 60px;
    border: 1px solid rgba(0,0,0,0.05);
}

/* Button Positioning & Styling */
.borrow-btn,
.btn-warning {
    position: absolute;
    bottom: 25px;
    left: 25px;
    padding: 10px 25px;
    font-size: 0.9rem;
    border-radius: 8px;
    min-width: 160px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

/* Reviews Section Enhancement */
.reviews-section {
    background: #fff;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.section-title {
    font-size: 1.4rem;
    color: #2d3436;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f2f6;
    margin-bottom: 1.5rem;
}

.review-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.2rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
    border-radius: 50%;
    font-size: 1.8rem;
}

/* Rating System Refinement */
.rating i {
    color: #ffc107;
    font-size: 0.9rem;
}

.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    transition: color 0.2s;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}
/* Form Styling */
.review-form-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.form-control {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.8rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #2937f0;
    box-shadow: 0 0 0 3px rgba(41,55,240,0.1);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .book-image-container {
        height: 320px;
    }
    
    .book-info {
        min-height: auto;
    }
    
    .borrow-btn,
    .btn-warning {
        width: calc(100% - 50px);
    }
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.review-card {
    animation: fadeIn 0.3s ease forwards;
}

/* Interactive Elements */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-sm {
    padding: 4px 10px;
    font-size: 0.8rem;
}
</style>
@endpush