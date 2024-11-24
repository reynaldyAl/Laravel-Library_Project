@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Manage Books</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">Add New Book</a>
        <table id="books-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Published Year</th>
                    <th>Category</th>
                    <th>Available Copies</th>
                    <th>Total Copies</th>
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
                        <td>{{ $book->available_copies }}</td>
                        <td>{{ $book->total_copies }}</td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#books-table').DataTable();
        });
    </script>
@endpush