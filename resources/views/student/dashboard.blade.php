<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Student Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h4>Welcome, {{ $student->name }}!</h4>
                        <p>Email: {{ $student->email }}</p>
                        <p>Class: {{ $student->class }}</p>

                        <!-- Authors Section (View Only) -->
                        <h5 class="mt-4">Authors</h5>
                        <div class="list-group">
                            @foreach($authors as $author)
                                <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">
                                    {{ $author->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Publishers Section (View Only) -->
                        <h5 class="mt-4">Publishers</h5>
                        <div class="list-group">
                            @foreach($publishers as $publisher)
                                <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">
                                    {{ $publisher->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Books Section (Transact: Buy or Borrow) -->
                        <h5 class="mt-4">Books (Available for Transaction)</h5>
                        <div class="list-group">
                            @foreach($books as $book)
                                <div class="list-group-item">
                                    <strong>{{ $book->title }}</strong> by {{ $book->author->name }}
                                    <form action="{{ route('student.transaction', $book->id) }}" method="POST" class="d-inline ms-3" style="display: inline;">
                                        @csrf
                                        <button type="submit" name="action" value="borrow" class="btn btn-sm btn-primary">Borrow</button>
                                        <button type="submit" name="action" value="buy" class="btn btn-sm btn-success">Buy</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Book Issues Section (Pending, Deadlines, Fines) -->
                        <h5 class="mt-4">Book Issues</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Issue Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Fine (if overdue)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookIssues as $issue)
                                    <tr>
                                        <td>{{ $issue->book->title }}</td>
                                        <td>{{ $issue->issue_date->format('Y-m-d') }}</td>
                                        <td>{{ $issue->return_date->format('Y-m-d') }}</td>
                                        <td>
                                            @if($issue->return_date->isPast() && !$issue->returned)
                                                Overdue
                                            @elseif(!$issue->returned)
                                                Pending (Deadline: {{ $issue->return_date->diffForHumans() }})
                                            @else
                                                Returned
                                            @endif
                                        </td>
                                        <td>
                                            @if($issue->return_date->isPast() && !$issue->returned)
                                                ${{ number_format(($issue->return_date->diffInDays(now()) * 0.50), 2) }} (PHP {{ number_format(($issue->return_date->diffInDays(now()) * 25), 2) }})
                                            @else
                                                $0.00
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form method="POST" action="{{ route('student.logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>