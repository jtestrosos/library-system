<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Book;
use App\Models\Auther;
use App\Models\Publisher;
use App\Models\Book_Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // For debugging

class StudentDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }
    
        $student = Auth::guard('student')->user();
        $books = Book::where('status', 'Y')->get();
        $authers = Auther::all();
        $publishers = Publisher::all();
        $book_issue = Book_Issue::where('student_id', $student->id)
            ->with(['book' => fn ($query) => $query->select('id', 'title')])
            ->get();
    
        // Debug logging to confirm data fetching
        Log::info('Student Dashboard Data', [
            'student_id' => $student->id,
            'authers_count' => $authers->count(),
            'publishers_count' => $publishers->count(),
            'books_count' => $books->count(),
            'book_issue_count' => $book_issue->count(),
        ]);
    
        return view('student.dashboard', compact('student', 'books', 'authers', 'publishers', 'book_issue'));
    }

    public function transaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $book = Book::findOrFail($bookId);
        if ($request->input('action') == 'borrow') {
            Book_Issue::create([
                'student_id' => Auth::guard('student')->user()->id,
                'book_id' => $bookId,
                'issue_date' => now(),
                'return_date' => now()->addDays(14),
                'returned' => false,
            ]);
            $book->status = 'N';
            $book->save();
            return redirect()->route('student.dashboard')->with('success', 'Book borrowed successfully!');
        } elseif ($request->input('action') == 'buy') {
            return redirect()->route('student.dashboard')->with('success', 'Book purchase initiated!');
        }
    }
}