@extends('layouts.app')

@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="admin-heading">Confirm {{ ucfirst($action) }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <p>Are you sure you want to {{ $action }} "{{ $book->title }}"?</p>
                <form action="{{ route('student.transaction', $book->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="{{ $action }}">
                    <div class="form-group">
                        <label for="user_id">User ID</label>
                        <input type="number" name="user_id" class="form-control" value="{{ Auth::guard('student')->user()->id }}" required>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ Auth::guard('student')->user()->name }}" required>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($action === 'borrow')
                        <div class="form-group">
                            <label for="return_date">Return Date</label>
                            <input type="date" name="return_date" class="form-control" required>
                            @error('return_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($action === 'buy')
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="Cash">Cash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                            @error('payment_method')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <p>Price: ₱4000</p>
                    @endif
                    <button type="submit" class="btn btn-primary mt-3">Confirm</button>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection