@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>My Loans</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Loan Date</th>
                    <th>Expected Return Date</th>
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
                            @if($loan->is_approved && is_null($loan->actual_return_date))
                                <form action="{{ route('mahasiswa.loans.return', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Return</button>
                                </form>
                            @elseif($loan->is_approved && !is_null($loan->actual_return_date))
                                <p>Book returned on {{ $loan->actual_return_date }}</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection