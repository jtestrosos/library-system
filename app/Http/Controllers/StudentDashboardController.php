<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Book;
use App\Models\Auther;
use App\Models\Publisher;
use App\Models\Book_Issue;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $bookIssues = Book_Issue::where('student_id', $student->id)
            ->with(['book' => fn($query) => $query->select('id', 'title')])
            ->get();
        $purchasedBooks = Purchase::where('student_id', $student->id)->get();

        Log::info('Student Dashboard Data', [
            'student_id' => $student->id,
            'authers_count' => $authers->count(),
            'publishers_count' => $publishers->count(),
            'books_count' => $books->count(),
            'book_issues_count' => $bookIssues->count(),
            'book_issues_data' => $bookIssues->toArray(),
            'purchased_books_count' => $purchasedBooks->count(),
            'purchased_books_data' => $purchasedBooks->toArray(),
        ]);

        return view('student.dashboard', compact('student', 'books', 'authers', 'publishers', 'bookIssues', 'purchasedBooks'));
    }

    public function transactionConfirm($bookId, $action)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $book = Book::findOrFail($bookId);
        $student = Auth::guard('student')->user();

        Log::info('Transaction Confirm Page', [
            'book_id' => $bookId,
            'action' => $action,
            'book_data' => $book->toArray(),
            'student_id' => $student->id,
        ]);

        return view('student.transaction_confirm', compact('book', 'action', 'student'));
    }

    public function processTransaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        try {
            $student = Auth::guard('student')->user();
            $book = Book::findOrFail($bookId);

            Log::info('Authenticated Student', [
                'student_id' => $student->id,
                'student_name' => $student->name,
            ]);

            Log::info('Skipping Validation for Debugging');

            if ($request->input('action') === 'borrow') {
                Log::info('Processing Borrow Action');

                $bookIssue = Book_Issue::create([
                    'student_id' => $student->id,
                    'book_id' => $bookId,
                    'issue_date' => now(),
                    'return_date' => $request->input('return_date', now()->addDays(7)),
                    'returned' => false,
                ]);

                $book->status = 'N';
                $book->save();

                Log::info('Book Borrowed', [
                    'book_id' => $bookId,
                    'student_id' => $student->id,
                    'book_issue_id' => $bookIssue->id,
                    'book_issue_data' => $bookIssue->toArray(),
                ]);

                $receipt = [
                    'action' => 'Borrowed',
                    'book_title' => $book->title,
                    'user_id' => $student->id,
                    'full_name' => $student->name,
                    'issue_date' => now()->format('Y-m-d'),
                    'return_date' => $request->input('return_date', now()->addDays(7)),
                ];

                Log::info('Receipt Generated', ['receipt' => $receipt]);
                return view('student.receipt', compact('receipt'));
            }

            return redirect()->route('student.dashboard')->withErrors(['action' => 'Invalid action specified.']);
        } catch (\Exception $e) {
            Log::error('Transaction Failed', [
                'book_id' => $bookId,
                'action' => $request->input('action'),
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('student.dashboard')->withErrors([
                'error' => 'Transaction failed: ' . $e->getMessage(),
            ]);
        }
    }
}
