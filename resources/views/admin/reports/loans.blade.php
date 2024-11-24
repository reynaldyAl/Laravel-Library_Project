@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Loans Report</h1>
        <p>Here you can view various reports and statistics about loans.</p>

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