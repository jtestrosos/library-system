<?php

namespace App\Http\Controllers;

use App\Models\Auther;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Book;
use App\Models\Student;
use App\Models\Book_Issue; // Adjust based on your schema

class StudentDashboardController extends Controller
{
    public function index()
    {
        $authers = Auther::count();
        $publishers = Publisher::count();
        $category = Category::count();
        $books = Book::count();
        $student = Student::count();
        $book_issue = Book_Issue::where('return_date', null)->count(); // Adjust based on your schema

        return view('student.dashboard', compact('authers', 'publishers', 'category', 'books', 'student', 'book_issue'));
    }
}