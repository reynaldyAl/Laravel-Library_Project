@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Loan Management</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>User</th>
                    <th>Loan Date</th>
                    <th>Expected Return Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->loan_date }}</td>
                        <td>{{ $loan->return_date }}</td>
                        <td>{{ $loan->actual_return_date }}</td>
                        <td>{{ $loan->loanStatus->name }}</td>
                        <td>
                            @if(!$loan->is_approved)
                                <form action="{{ route('staff.loans.approve', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('staff.loans.reject', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @endif
                            @if($loan->loanStatus->name == 'waiting')
                                <form action="{{ route('staff.loans.confirmReturn', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Confirm Return</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection