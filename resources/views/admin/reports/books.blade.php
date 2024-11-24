@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Books Report</h1>
        <p>Here you can view various reports and statistics about books.</p>

        <h2>Books</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Published Year</th>
                    <th>Category</th>
                    <th>Available Copies</th>
                    <th>Total Copies</th>
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
                        <td>{{ $book->available_copies }}</td>
                        <td>{{ $book->total_copies }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection