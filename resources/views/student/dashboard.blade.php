<!-- resources/views/student/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
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

                        <!-- Authers Section (View Only) -->
                        <h5 class="mt-4">Authers</h5>
                        <div class="list-group">
                            @foreach($authers as $auther)
                                <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">
                                    {{ $auther->name }}
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
                                    <strong>{{ $book->title }}</strong> by {{ $book->auther->name }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection