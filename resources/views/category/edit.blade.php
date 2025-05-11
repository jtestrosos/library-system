<!-- resources/views/category/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Category</h1>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection