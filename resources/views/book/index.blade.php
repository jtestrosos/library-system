@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>All Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add Book</a>
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
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td><a href="{{ route('books.edit', $book->id) }}" class="btn btn-success btn-sm">Edit</a></td>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button></td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $books->links() }}
    </div>
@endsection