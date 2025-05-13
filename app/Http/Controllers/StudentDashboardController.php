<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\book;
use App\Models\auther;
use App\Models\publisher;
use App\Models\book_issue;
use App\Models\Purchase;
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
        $books = book::where('status', 'S')->get();
        $authers = auther::all();
        $publishers = publisher::all();
        $book_issue = book_issue::where('student_id', $student->id)
            ->with(['book' => fn ($query) => $query->select('id', 'name')])
            ->get();
        $purchases = Purchase::where('student_id', $student->id)->get();
    
        return view('student.dashboard', compact('student', 'books', 'authers', 'publishers', 'book_issue', 'purchases'));
    }

    public function transaction(Request $request, $bookId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $book = book::findOrFail($bookId);
        $student = Auth::guard('student')->user();

        if ($request->input('action') == 'borrow') {
            book_issue::create([
                'student_id' => $student->id,
                'book_id' => $bookId,
                'issue_date' => now(),
                'return_date' => now()->addDays(14),
                'issue_status' => 'Y',
            ]);
            $book->status = 'N';
            $book->save();
            return redirect()->route('student.dashboard')->with('success', 'Book borrowed successfully!');
        } elseif ($request->input('action') == 'buy') {
            Purchase::create([
                'student_id' => $student->id,
                'book_id' => $bookId,
                'book_title' => $book->name,
                'full_name' => $student->name,
                'payment_method' => 'E-Wallet',
                'price' => 29.99,
                'purchase_date' => now()->toDateString(),
            ]);
            $book->status = 'N';
            $book->save();
            return redirect()->route('student.dashboard')->with('success', 'Book purchased successfully!');
        }

        return redirect()->route('student.dashboard')->with('error', 'Invalid action.');
    }

    public function returnBook(Request $request, $issueId)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login');
        }

        $issue = book_issue::where('id', $issueId)
            ->where('student_id', Auth::guard('student')->user()->id)
            ->firstOrFail();

        $issue->issue_status = 'N';
        $issue->return_day = now();
        $issue->save();

        $book = book::find($issue->book_id);
        $book->status = 'S';
        $book->save();

        return redirect()->route('student.dashboard')->with('success', 'Book returned successfully!');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login')->with('success', 'Logged out successfully!');
    }
}