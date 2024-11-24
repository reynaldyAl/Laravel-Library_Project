@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Profile</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ $user->profile_image_url }}" alt="Profile Image" class="img-thumbnail mt-2" width="150">
                </div>
                <h3 class="text-center mt-3">{{ $user->name }}</h3>
                <p class="text-center">{{ $user->email }}</p>
                <div class="text-center">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection