@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Confirm {{ ucfirst($action) }} Book</h2>
    <p>Book: {{ $book->title }}</p>
    <p>Student: {{ $student->name }}</p>
    <form action="{{ route('student.transaction', $book->id) }}" method="POST">
        @csrf
        <input type="hidden" name="action" value="{{ $action }}">
        <input type="hidden" name="user_id" value="{{ $student->id }}">
        <input type="hidden" name="full_name" value="{{ $student->name }}">
        @if ($action === 'borrow')
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" name="return_date" class="form-control" required>
            </div>
        @endif
        @if ($action === 'buy')
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select name="payment_method" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                </select>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Confirm</button>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection