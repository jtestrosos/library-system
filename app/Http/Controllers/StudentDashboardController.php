<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Book;
use App\Models\Auther;
use App\Models\Publisher;
use App\Models\Book_Issue; // Updated from BookIssue to Book_Issue
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }
    
        $student = Auth::guard('student')->user();
        $books = Book::where('status', 'Y')->get(); // Available books for transaction
        $authers = Auther::all();
        $publishers = Publisher::all();
        $bookIssues = Book_Issue::where('student_id', $student->id) // Updated from BookIssue to Book_Issue
            ->with(['book' => fn ($query) => $query->select('id', 'title')])
            ->get();
    
        return view('student.dashboard', compact('student', 'books', 'authers', 'publishers', 'bookIssues'));
    }

    public function transaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $book = Book::findOrFail($bookId);
        if ($request->input('action') == 'borrow') {
            Book_Issue::create([ // Updated from BookIssue to Book_Issue
                'student_id' => Auth::guard('student')->user()->id,
                'book_id' => $bookId,
                'issue_date' => now(),
                'return_date' => now()->addDays(14), // 2-week loan period
                'returned' => false,
            ]);
            $book->status = 'N'; // Mark as unavailable
            $book->save();
            return redirect()->route('student.dashboard')->with('success', 'Book borrowed successfully!');
        } elseif ($request->input('action') == 'buy') {
            // Logic to process purchase
            return redirect()->route('student.dashboard')->with('success', 'Book purchase initiated!');
        }
    }
}