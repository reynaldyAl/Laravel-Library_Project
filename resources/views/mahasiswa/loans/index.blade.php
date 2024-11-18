<!-- resources/views/mahasiswa/loans/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>My Loans</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->loan_date }}</td>
                        <td>{{ $loan->return_date }}</td>
                        <td>{{ $loan->due_date }}</td>
                        <td>{{ $loan->loanStatus->name }}</td>
                        <td>
                            @if(is_null($loan->return_date))
                                <form action="{{ route('loans.return', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Return</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection