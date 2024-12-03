<!-- resources/views/staff/books/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Book</h1>
        <form action="{{ route('staff.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
            </div>
            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control" id="publisher" name="publisher" value="{{ $book->publisher }}" required>
            </div>
            <div class="form-group">
                <label for="published_year">Published Year</label>
                <input type="number" class="form-control" id="published_year" name="published_year" value="{{ $book->published_year }}" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="available_copies">Available Copies</label>
                <input type="number" class="form-control" id="available_copies" name="available_copies" value="{{ $book->available_copies }}" required>
            </div>
            <div class="form-group">
                <label for="total_copies">Total Copies</label>
                <input type="number" class="form-control" id="total_copies" name="total_copies" value="{{ $book->total_copies }}" required>
            </div>
            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea class="form-control" id="synopsis" name="synopsis" rows="3" required>{{ $book->synopsis }}</textarea>
            </div>
            <div class="form-group">
                <label for="image_path">Book Image</label>
                <input type="file" class="form-control-file" id="image_path" name="image_path">
                <img src="{{ asset($book->image_path) }}" class="img-fluid mt-2" alt="{{ $book->title }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
@endsection