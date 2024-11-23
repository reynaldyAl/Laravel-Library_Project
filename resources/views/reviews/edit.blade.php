@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Review</h1>
        <form action="{{ route('reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="rating">Rating</label>
                <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating', $review->rating) }}" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="5" required>{{ old('comment', $review->comment) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Review</button>
        </form>
    </div>
@endsection


