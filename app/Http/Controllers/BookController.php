<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(5);
        return view('book.index', compact('books'));
    }

    public function create()
    {
        return view('book.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'auther_id' => 'required|exists:authers,id', 'publisher_id' => 'required|exists:publishers,id', 'status' => 'required']);
        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('book.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'auther_id' => 'required|exists:authers,id', 'publisher_id' => 'required|exists:publishers,id', 'status' => 'required']);
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
}