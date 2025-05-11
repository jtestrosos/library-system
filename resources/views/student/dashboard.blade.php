@extends('layouts.app')

@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Dashboard</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $authers }}</p>
                        <h5 class="card-title mb-0">Authors Listed</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $publishers }}</p>
                        <h5 class="card-title mb-0">Publishers Listed</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $category }}</p>
                        <h5 class="card-title mb-0">Categories Listed</h5>
                    </div>
                </div>
            </div>
   <div class="col-md-3 mb-4">
    <a href="{{ route('student.books.index') }}" style="text-decoration: none; color: inherit;">
        <div class="card">
            <div class="card-body text-center">
                <p class="card-text">{{ $books }}</p>
                <h5 class="card-title mb-0">Books Listed</h5>
            </div>
        </div>
    </a>
</div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $student }}</p>
                        <h5 class="card-title mb-0">Register Students</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $book_issue }}</p>
                        <h5 class="card-title mb-0">Book Issued</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection