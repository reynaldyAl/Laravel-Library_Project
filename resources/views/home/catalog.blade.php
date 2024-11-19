@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Book Catalog</h1>

        <!-- Filter dan Opsi Pengurutan -->
        <form action="{{ route('home.catalog') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="published_year">Published Year</label>
                        <input type="number" class="form-control" id="published_year" name="published_year" value="{{ request('published_year') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sort_by">Sort By</label>
                        <select class="form-control" id="sort_by" name="sort_by">
                            <option value="">Default</option>
                            <option value="popularity" {{ request('sort_by') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                            <option value="published_year" {{ request('sort_by') == 'published_year' ? 'selected' : '' }}>Published Year</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Daftar Buku -->
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