@extends('layouts.app')

@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Student Dashboard</h2>
            </div>
        </div>

        <!-- Debug Output -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <p>Authers Count: {{ $authers->count() }}</p>
                <p>Publishers Count: {{ $publishers->count() }}</p>
                <p>Books Count: {{ $books->count() }}</p>
                <p>Book Issues Count: {{ $bookIssues->count() }}</p>
                <p>Purchased Books Count: {{ $purchasedBooks->count() }}</p>
            </div>
        </div>

        <!-- Authers and Publishers Section -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $authers->count() }}</p>
                        <h5 class="card-title mb-0">Authers Listed</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $publishers->count() }}</p>
                        <h5 class="card-title mb-0">Publishers Listed</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Books Section with Buy/Borrow Options -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <h3>Available Books</h3>
                @if ($books->isEmpty())
                    <p>No books available at the moment.</p>
                @else
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $book->title ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('student.transaction.confirm', ['bookId' => $book->id, 'action' => 'borrow']) }}" class="btn btn-primary btn-sm">Borrow</a>
                                        <a href="{{ route('student.transaction.confirm', ['bookId' => $book->id, 'action' => 'buy']) }}" class="btn btn-success btn-sm">Buy</a>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Book Issues Section with Deadlines and Fines -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <h3>Your Book Issues</h3>
                @if ($bookIssues->isEmpty())
                    <p>No books issued.</p>
                @else
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Book Title</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Days Remaining</th>
                                <th>Fine (if Overdue)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookIssues as $issue)
                                <tr>
                                    <td>{{ $issue->book ? $issue->book->title : 'Book Not Found' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($issue->return_date)->format('Y-m-d') }}</td>
                                    <td class="{{ $issue->days_remaining <= 3 && $issue->days_remaining >= 0 ? 'text-warning' : ($issue->days_remaining < 0 ? 'text-danger' : '') }}">
                                        {{ $issue->days_remaining >= 0 ? $issue->days_remaining . ' days' : 'Overdue by ' . abs($issue->days_remaining) . ' days' }}
                                    </td>
                                    <td class="{{ $issue->fine > 0 ? 'text-danger' : '' }}">
                                        {{ $issue->fine > 0 ? '₱' . number_format($issue->fine, 2) : 'None' }}
                                    </td>
                                    <td>{{ $issue->returned ? 'Returned' : 'Not Returned' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Purchased Books Section -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <h3>Your Purchased Books</h3>
                @if ($purchasedBooks->isEmpty())
                    <p>No books purchased.</p>
                @else
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Book Title</th>
                                <th>Purchase Date</th>
                                <th>Price</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchasedBooks as $purchase)
                                <tr>
                                    <td>{{ $purchase->book_title ?? 'N/A' }}</td>
                                    <td>{{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $purchase->price ? '₱' . number_format($purchase->price, 2) : 'N/A' }}</td>
                                    <td>{{ $purchase->payment_method ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection