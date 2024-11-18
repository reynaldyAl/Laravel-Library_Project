<!-- resources/views/mahasiswa/loans/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Create Loan</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('mahasiswa.loans.store') }}" method="POST" onsubmit="return validateForm()">
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
                <div id="loan_date_error" class="text-danger" style="display: none;">Loan date cannot be in the past.</div>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
                <div id="return_date_error" class="text-danger" style="display: none;">Return date cannot be more than 14 days from the loan date.</div>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="text" class="form-control" id="due_date" name="due_date" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Create Loan</button>
        </form>
    </div>

    <script>
        document.getElementById('loan_date').addEventListener('change', calculateDueDate);
        document.getElementById('return_date').addEventListener('change', calculateDueDate);

        function calculateDueDate() {
            const loanDate = document.getElementById('loan_date').value;
            const returnDate = document.getElementById('return_date').value;
            const loanDateError = document.getElementById('loan_date_error');
            const returnDateError = document.getElementById('return_date_error');

            loanDateError.style.display = 'none';
            returnDateError.style.display = 'none';

            if (loanDate) {
                const today = new Date().toISOString().split('T')[0];
                if (loanDate < today) {
                    loanDateError.style.display = 'block';
                    document.getElementById('loan_date').value = '';
                    return;
                }

                const dueDate = new Date(loanDate);
                dueDate.setDate(dueDate.getDate() + 14); // Tambahkan 14 hari ke loan_date

                const formattedDueDate = dueDate.toISOString().split('T')[0];
                document.getElementById('due_date').value = formattedDueDate;

                if (returnDate && new Date(returnDate) > dueDate) {
                    returnDateError.style.display = 'block';
                    document.getElementById('return_date').value = '';
                }
            }
        }

        function validateForm() {
            const loanDate = document.getElementById('loan_date').value;
            const today = new Date().toISOString().split('T')[0];
            if (loanDate < today) {
                document.getElementById('loan_date_error').style.display = 'block';
                return false;
            }
            return true;
        }
    </script>
@endsection