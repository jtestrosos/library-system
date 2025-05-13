<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Reader’s Garden Library</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
        }
        .dashboard-card {
            border: 1px solid #d1d5db;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #ffffff;
            max-width: 900px;
            width: 100%;
            margin: 2rem 0;
        }
        .card-header {
            background: #f9fafb;
            color: #1f2937;
            padding: 1.5rem;
            border-bottom: 1px solid #d1d5db;
            text-align: center;
        }
        .card-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .card-body {
            padding: 2rem;
        }
        h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }
        h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        p {
            color: #374151;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            font-size: 0.9rem;
            border: 1px solid #f87171;
        }
        .alert-success {
            border-color: #34d399;
        }
        .list-group-item {
            border-radius: 8px;
            margin-bottom: 0.5rem;
            background: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
            transition: background 0.3s ease;
        }
        .list-group-item.disabled {
            background: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }
        .list-group-item strong {
            color: #1f2937;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table thead {
            background: #f9fafb;
            color: #1f2937;
            border-bottom: 1px solid #d1d5db;
        }
        .table th, .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .table th {
            font-weight: 600;
        }
        .table td {
            color: #374151;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #6b7280;
            border: none;
            color: #ffffff;
        }
        .btn-primary:hover {
            background: #4b5563;
            color: #f0f2f5;
        }
        .btn-success {
            background: #34d399;
            border: none;
            color: #ffffff;
        }
        .btn-success:hover {
            background: #2cb082;
            color: #f0f2f5;
        }
        .btn-warning {
            background: #f87171;
            border: none;
            color: #ffffff;
        }
        .btn-warning:hover {
            background: #ef4444;
            color: #f0f2f5;
        }
        .btn-danger {
            background: #f87171;
            border: none;
            color: #ffffff;
        }
        .btn-danger:hover {
            background: #ef4444;
            color: #f0f2f5;
        }
        .ms-3 {
            margin-left: 1rem !important;
        }
    </style>
</head>
<body>
    <div class="dashboard-card">
        <div class="card-header">
            <h3>Student Dashboard</h3>
        </div>
        <div class="card-body">
            <!-- Display Flash Messages -->
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            <h4>Welcome, {{ $student->name }}!</h4>
            <p>Email: {{ $student->email }}</p>

            <!-- Authors Section (View Only) -->
            <h5>Authors</h5>
            @if($authers->isEmpty())
                <p>No authors available.</p>
            @else
                <div class="list-group">
                    @foreach($authers as $auther)
                        <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">
                            {{ $auther->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Publishers Section (View Only) -->
            <h5>Publishers</h5>
            @if($publishers->isEmpty())
                <p>No publishers available.</p>
            @else
                <div class="list-group">
                    @foreach($publishers as $publisher)
                        <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">
                            {{ $publisher->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Books Section (Transact: Buy or Borrow) -->
            <h5>Books (Available for Transaction)</h5>
            @if($books->isEmpty())
                <p>No books available for transaction.</p>
            @else
                <div class="list-group">
                    @foreach($books as $book)
                        <div class="list-group-item">
                            <strong>{{ $book->name }}</strong>
                            <form id="form-{{ $book->id }}-borrow" action="{{ route('student.transaction', $book->id) }}" method="POST" class="d-inline ms-3">
                                @csrf
                                <input type="hidden" name="action" value="borrow">
                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to borrow this book?')">Borrow</button>
                            </form>
                            <form id="form-{{ $book->id }}-buy" action="{{ route('student.transaction', $book->id) }}" method="POST" class="d-inline ms-3">
                                @csrf
                                <input type="hidden" name="action" value="buy">
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to buy this book?')">Buy</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Book Issues Section (Pending, Deadlines, Fines) -->
            <h5>Book Issues</h5>
            @if(!isset($book_issue) || $book_issue->isEmpty())
                <p>No books issued.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Issue Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Fine (if overdue)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book_issue as $issue)
                            <tr>
                                <td>{{ $issue->book->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($issue->return_date)->format('Y-m-d') }}</td>
                                <td>
                                    @php
                                        $returnDate = \Carbon\Carbon::parse($issue->return_date);
                                    @endphp
                                    @if($returnDate->isPast() && $issue->issue_status === 'Y')
                                        Overdue
                                    @elseif($issue->issue_status === 'Y')
                                        Pending (Deadline: {{ $returnDate->diffForHumans() }})
                                    @else
                                        Returned
                                    @endif
                                </td>
                                <td>
                                    @if($returnDate->isPast() && $issue->issue_status === 'Y')
                                        @php
                                            $daysOverdue = $returnDate->diffInDays(now());
                                            $fineUSD = $daysOverdue * 0.50;
                                            $finePHP = $daysOverdue * 25;
                                        @endphp
                                        ${{ number_format($fineUSD, 2) }} (PHP {{ number_format($finePHP, 2) }})
                                    @else
                                        $0.00
                                    @endif
                                </td>
                                <td>
                                    @if($issue->issue_status === 'Y')
                                        <form action="{{ route('student.return', $issue->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to return this book?')">Return</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <!-- Purchase History Section -->
            <h5>Purchase History</h5>
            @if($purchases->isEmpty())
                <p>No purchases made.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Price</th>
                            <th>Payment Method</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->book_title }}</td>
                                <td>${{ number_format($purchase->price, 2) }}</td>
                                <td>{{ $purchase->payment_method }}</td>
                                <td>{{ $purchase->purchase_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <form method="POST" action="{{ route('student.logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>