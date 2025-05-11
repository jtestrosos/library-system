@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>All Book Issues</h1>
        <a href="{{ route('book_issue.create') }}" class="btn btn-primary mb-3">Add Book Issue</a>
        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Book Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookIssues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->book->title }}</td>
                        <td><a href="{{ route('book_issue.edit', $issue->id) }}" class="btn btn-success btn-sm">Edit</a></td>
                        <form action="{{ route('book_issue.destroy', $issue->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button></td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $bookIssues->links() }}
    </div>
@endsection