@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Notifications</h1>
        <table id="notificationsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($notifications as $notification)
                    <tr class="{{ $notification->read_status ? '' : 'bg-yellow-100' }}">
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $notification->message }}</td>
                        <td class="px-4 py-2 whitespace-nowrap border border-gray-200">{{ $notification->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-2 whitespace-nowrap border border-gray-200">No notifications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.tailwind.min.css">
    <style>
        #notificationsTable tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .bg-yellow-100 {
            background-color: #fff3cd !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem;
            margin-left: 0.25rem;
            margin-right: 0.25rem;
            border-radius: 0.25rem;
            background-color: #007bff;
            color: #fff !important;
            border: none;
            transition: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #007bff;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #0056b3;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background-color: #e9ecef;
            color: #6c757d !important;
        }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            padding: 0.25rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.tailwind.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#notificationsTable').DataTable({
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