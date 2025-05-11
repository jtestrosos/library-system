<?php
namespace App\Http\Controllers;

use App\Models\Book;

class StudentBookController extends Controller
{
    public function index()
    {
        $books = Book::all(); // Fetch all books
        return view('student.book_student.index', compact('books'));
    }
}