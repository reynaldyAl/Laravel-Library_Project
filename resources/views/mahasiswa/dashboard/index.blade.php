<!-- resources/views/mahasiswa/dashboard/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Mahasiswa Dashboard</h1>
        <p>Welcome to the mahasiswa dashboard. Here you can view and manage your book loans and reviews.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Books</h5>
                        <p class="card-text">Browse and view details of available books.</p>
                        <a href="{{ route('mahasiswa.books.index') }}" class="btn btn-primary">Go to Books</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Loans</h5>
                        <p class="card-text">View and manage your book loans.</p>
                        <a href="{{ route('mahasiswa.loans.create') }}" class="btn btn-primary">Go to Loans</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Reviews</h5>
                        <p class="card-text">View and manage your book reviews.</p>
                        <a href="#" class="btn btn-primary">Go to Reviews</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection