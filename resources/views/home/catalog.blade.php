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