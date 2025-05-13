@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Transaction Receipt</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h3>{{ $receipt['action'] }} Successfully</h3>
            <p><strong>Book Title:</strong> {{ $receipt['book_title'] }}</p>
            <p><strong>User ID:</strong> {{ $receipt['user_id'] }}</p>
            <p><strong>Full Name:</strong> {{ $receipt['full_name'] }}</p>
            @if ($receipt['action'] === 'Borrowed')
                <p><strong>Issue Date:</strong> {{ $receipt['issue_date'] }}</p>
                <p><strong>Return Date:</strong> {{ $receipt['return_date'] }}</p>
            @elseif ($receipt['action'] === 'Purchased')
                <p><strong>Purchase Date:</strong> {{ $receipt['purchase_date'] }}</p>
                <p><strong>Price:</strong> ₱{{ number_format($receipt['price'], 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $receipt['payment_method'] }}</p>
            @endif
            <a href="{{ route('student.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection