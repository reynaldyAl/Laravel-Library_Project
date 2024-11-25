@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Notifications</h1>
        <div class="list-group">
            @forelse ($notifications as $notification)
                <a href="#" class="list-group-item list-group-item-action {{ $notification->read_status ? '' : 'list-group-item-warning' }}">
                    {{ $notification->message }}
                    <span class="badge badge-secondary float-right">{{ $notification->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <p class="list-group-item">No notifications found.</p>
            @endforelse
        </div>
    </div>
@endsection