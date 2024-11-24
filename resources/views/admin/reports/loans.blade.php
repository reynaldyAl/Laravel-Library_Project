@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Loans Report</h1>
        <table id="loans-report-table" class="table table-striped">
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#loans-report-table').DataTable();
        });
    </script>
@endpush