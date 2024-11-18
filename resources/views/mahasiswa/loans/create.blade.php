<!-- resources/views/mahasiswa/loans/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Create Loan</h1>
        <form action="{{ route('mahasiswa.loans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="book_id">Book</label>
                <select class="form-control" id="book_id" name="book_id" required>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="loan_date">Loan Date</label>
                <input type="date" class="form-control" id="loan_date" name="loan_date" required>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Loan</button>
        </form>
    </div>
@endsection