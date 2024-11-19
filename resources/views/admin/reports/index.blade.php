<!-- resources/views/admin/reports/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Admin Reports</h1>
        <p>Here you can view various reports and statistics.</p>

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

        <h2>Loans</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>User</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->loan_date }}</td>
                        <td>{{ $loan->return_date }}</td>
                        <td>{{ $loan->Loanstatus->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection