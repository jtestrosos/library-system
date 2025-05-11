@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Not Returned Books</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Book Title</th>
                    <th>Student</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notReturned as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->book->title }}</td>
                        <td>{{ $issue->student->name }}</td>
                        <td>{{ $issue->issue_date }}</td>
                        <td>{{ $issue->return_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $notReturned->links() }}
    </div>
@endsection