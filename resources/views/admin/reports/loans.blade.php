@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-semibold mb-4">Loans Report</h1>
        <table id="loans-report-table" class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <thead class="bg-blue-100 border border-gray-200">
                <tr>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Book Title</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">User</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Loan Date</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Return Date</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 border border-gray-200">
                @foreach($loans as $loan)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $loan->book->title }}</td>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $loan->user->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $loan->loan_date }}</td>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $loan->return_date }}</td>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $loan->Loanstatus->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.tailwind.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            margin-left: 0.25rem;
            margin-right: 0.25rem;
            border-radius: 0.25rem;
            background-color: #007bff;
            color: #fff !important;
            border: none;
            transition: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #0056b3;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background-color: #e9ecef;
            color: #6c757d ! penting;
        }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
        }
        #loans-report-table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .dataTables_wrapper .dataTables_info {
            margin-top: 1rem;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.tailwind.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loans-report-table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 10,
                "language": {
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<"
                    }
                }
            });
        });
    </script>
@endpush