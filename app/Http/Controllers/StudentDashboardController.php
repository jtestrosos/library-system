<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\book;
use App\Models\author;
use App\Models\publisher;
use App\Models\book_issue;
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
        $books = book::where('status', 'Y')->get(); // Available books for transaction
        $authors = author::all();
        $publishers = publisher::all();
        $bookIssues = book_issue::where('student_id', $student->id)
            ->with(['book' => fn ($query) => $query->select('id', 'title')])
            ->get();
    
        return view('student.dashboard', compact('student', 'books', 'authors', 'publishers', 'bookIssues'));
    }

    public function transaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $book = book::findOrFail($bookId);
        if ($request->input('action') == 'borrow') {
            book_issue::create([
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