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
            ->with(['book' => fn ($query) => $query->select('id', 'title')])
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
        Log::info('Transaction Confirm Page', [
            'book_id' => $bookId,
            'action' => $action,
            'book_data' => $book->toArray(),
        ]);
        return view('student.transaction_confirm', compact('book', 'action'));
    }

    public function transaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        Log::info('Transaction Attempt', [
            'book_id' => $bookId,
            'action' => $request->input('action'),
            'user_id' => $request->input('user_id'),
            'full_name' => $request->input('full_name'),
            'return_date' => $request->input('return_date'),
            'payment_method' => $request->input('payment_method'),
        ]);

        try {
            Log::info('Starting Validation');
            $request->validate([
                'user_id' => 'required|exists:students,id',
                'full_name' => 'required|string|max:255',
            ]);
            Log::info('Validation Passed');

            $student = Auth::guard('student')->user();
            $book = Book::findOrFail($bookId);

            Log::info('Authenticated Student', [
                'student_id' => $student->id,
                'student_name' => $student->name,
            ]);

            if ($request->user_id != $student->id) {
                Log::warning('User ID Mismatch', [
                    'submitted_user_id' => $request->user_id,
                    'authenticated_student_id' => $student->id,
                ]);
                return redirect()->back()->withErrors(['user_id' => 'User ID does not match the authenticated user.']);
            }

            if ($request->input('action') === 'borrow') {
                Log::info('Processing Borrow Action');
                $request->validate([
                    'return_date' => 'required|date|after_or_equal:today',
                ]);
                Log::info('Borrow Validation Passed');

                $bookIssue = Book_Issue::create([
                    'student_id' => $request->user_id,
                    'book_id' => $bookId,
                    'issue_date' => now(),
                    'return_date' => $request->return_date,
                    'returned' => false,
                ]);
                $book->status = 'N';
                $book->save();

                Log::info('Book Borrowed', [
                    'book_id' => $bookId,
                    'student_id' => $request->user_id,
                    'book_issue_id' => $bookIssue->id,
                    'book_issue_data' => $bookIssue->toArray(),
                ]);

                $receipt = [
                    'action' => 'Borrowed',
                    'book_title' => $book->title,
                    'user_id' => $request->user_id,
                    'full_name' => $request->full_name,
                    'issue_date' => now()->format('Y-m-d'),
                    'return_date' => $request->return_date,
                ];
            } elseif ($request->input('action') === 'buy') {
                Log::info('Processing Buy Action');
                $request->validate([
                    'payment_method' => 'required|in:E-Wallet,Cash,Bank Transfer',
                ]);
                Log::info('Buy Validation Passed');

                $price = 4000;
                $book->status = 'N';
                $book->save();

                $purchase = Purchase::create([
                    'student_id' => $request->user_id,
                    'book_id' => $bookId,
                    'book_title' => $book->title,
                    'full_name' => $request->full_name,
                    'payment_method' => $request->payment_method,
                    'price' => $price,
                    'purchase_date' => now(),
                ]);

                Log::info('Book Purchased', [
                    'book_id' => $bookId,
                    'student_id' => $request->user_id,
                    'purchase_id' => $purchase->id,
                    'purchase_data' => $purchase->toArray(),
                ]);

                $receipt = [
                    'action' => 'Purchased',
                    'book_title' => $book->title,
                    'user_id' => $request->user_id,
                    'full_name' => $request->full_name,
                    'payment_method' => $request->payment_method,
                    'price' => $price,
                    'purchase_date' => now()->format('Y-m-d'),
                ];
            } else {
                Log::error('Invalid Action', ['action' => $request->input('action')]);
                return redirect()->route('student.dashboard')->withErrors(['action' => 'Invalid action specified.']);
            }

            Log::info('Receipt Generated', ['receipt' => $receipt]);
            return view('student.receipt', compact('receipt'));
        } catch (\Exception $e) {
            Log::error('Transaction Failed', [
                'book_id' => $bookId,
                'action' => $request->input('action'),
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('student.dashboard')->withErrors(['error' => 'An error occurred while processing your transaction: ' . $e->getMessage()]);
        }
    }
}