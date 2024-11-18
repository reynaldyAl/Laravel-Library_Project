<!-- resources/views/mahasiswa/books/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Books</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Published Year</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->published_year }}</td>
                        <td>{{ $book->category->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.books.show', $book->id) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection