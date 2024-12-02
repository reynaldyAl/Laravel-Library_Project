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
                    <th>Due Date</th>
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
                        <td>
                            @if($loan->loanStatus->name == 'returned')
                                Return completed
                            @elseif($loan->loanStatus->name == 'rejected')
                                Approval rejected
                            @elseif($loan->loanStatus->name == 'waiting')
                                Loan application is waiting for approval
                            @elseif($loan->loanStatus->name == 'Loan application is waiting for approval')
                                Loan application is waiting for approval
                            @elseif($loan->is_approved)
                                <span class="countdown text-success" data-loan-date="{{ $loan->loan_date }}" data-return-date="{{ $loan->return_date }}"></span>
                            @else
                                Waiting for approval
                            @endif
                        </td>
                        <td>
                            @if($loan->loanStatus->name == 'waiting')
                            waiting
                            @elseif($loan->loanStatus->name == 'waiting for return confirmation')
                                Loan application is waiting for approval
                            @else
                                {{ $loan->loanStatus->name }}
                            @endif
                            @if(!$loan->is_approved && $loan->loanStatus->name != 'rejected')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown');

            countdownElements.forEach(function(element) {
                const loanDate = new Date(element.getAttribute('data-loan-date')).getTime();
                const returnDate = new Date(element.getAttribute('data-return-date')).getTime();

                const interval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = returnDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

                    if (distance < 0) {
                        clearInterval(interval);
                        element.innerHTML = "EXPIRED";
                    }
                }, 1000);
            });
        });
    </script>
@endsection