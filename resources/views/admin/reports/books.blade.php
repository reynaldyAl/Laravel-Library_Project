@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Books Report</h1>
        <table id="books-report-table" class="table table-striped">
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#books-report-table').DataTable();
        });
    </script>
@endpush