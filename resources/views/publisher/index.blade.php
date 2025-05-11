@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>All Publishers</h1>
        <a href="{{ route('publishers.create') }}" class="btn btn-primary mb-3 float-right">Add Publisher</a>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>Publisher Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publishers as $publisher)
                    <tr>
                        <td>{{ $publisher->id }}</td>
                        <td>{{ $publisher->name }}</td>
                        <td><a href="{{ route('publishers.edit', $publisher->id) }}" class="btn btn-success btn-sm">Edit</a></td>
                        <td>
                            <form action="{{ route('publishers.destroy', $publisher->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $publishers->links() }}
        </div>
    </div>
@endsection