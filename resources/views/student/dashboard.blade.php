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
                <h4>Debug Data</h4>
                <p>Authers Count: {{ $authers->count() }}</p>
                <p>Publishers Count: {{ $publishers->count() }}</p>
                <p>Books Count: {{ $books->count() }}</p>
                <p>Book Issues Count: {{ $book_issue->count() }}</p>
            </div>
        </div>

        <!-- Authors and Publishers Section -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="card-text">{{ $authers->count() }}</p>
                        <h5 class="card-title mb-0">Authors Listed</h5>
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
                    <table class="table table-bordered">
                        <thead>
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
                                        <form action="{{ route('student.transaction', $book->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="action" value="borrow">
                                            <button type="submit" class="btn btn-primary btn-sm">Borrow</button>
                                        </form>
                                        <form action="{{ route('student.transaction', $book->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="action" value="buy">
                                            <button type="submit" class="btn btn-success btn-sm">Buy</button>
                                        </form>
                                    </td>
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
                @if ($book_issue->isEmpty())
                    <p>No books issued.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Days Remaining</th>
                                <th>Fine (if Overdue)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $finePerDay = 1; // $1 per day fine
                                $warningDays = 3; // Highlight if due within 3 days
                                $today = now();
                            @endphp
                            @foreach ($book_issue as $issue)
                                @if (!$issue->returned) <!-- Show only pending (not returned) books -->
                                    @php
                                        $returnDate = \Carbon\Carbon::parse($issue->return_date);
                                        $daysRemaining = $today->diffInDays($returnDate, false); // Negative if overdue
                                        $fine = $daysRemaining < 0 ? abs($daysRemaining) * $finePerDay : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $issue->book->title ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('Y-m-d') }}</td>
                                        <td>{{ $returnDate->format('Y-m-d') }}</td>
                                        <td class="{{ $daysRemaining <= $warningDays && $daysRemaining >= 0 ? 'text-warning' : ($daysRemaining < 0 ? 'text-danger' : '') }}">
                                            {{ $daysRemaining >= 0 ? $daysRemaining . ' days' : 'Overdue by ' . abs($daysRemaining) . ' days' }}
                                        </td>
                                        <td class="{{ $fine > 0 ? 'text-danger' : '' }}">
                                            {{ $fine > 0 ? '$' . $fine : 'None' }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection