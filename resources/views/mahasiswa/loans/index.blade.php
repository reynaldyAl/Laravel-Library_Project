@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-semibold mb-4">My Loans</h1>
        <a href="{{ route('mahasiswa.loans.create') }}" class="btn btn-primary mb-4">Add Book</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Book Title</th>
                    <th scope="col">Loan Date</th>
                    <th scope="col">Return Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->book->title }}</td>
                        <td>{{ $loan->loan_date }}</td>
                        <td>{{ $loan->return_date }}</td>
                        <td>{{ $loan->loanStatus->name }}</td>
                        <td>
                            @if($loan->loanStatus->name == 'borrowed')
                                <form action="{{ route('mahasiswa.loans.return', $loan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Return</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection