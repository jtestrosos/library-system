<?php

namespace App\Http\Controllers;

use App\Models\Book_Issue;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function index()
    {
        $bookIssues = Book_Issue::paginate(5);
        return view('book_issue.index', compact('bookIssues'));
    }

    public function create()
    {
        return view('book_issue.create');
    }

    public function store(Request $request)
    {
        $request->validate(['student_id' => 'required|exists:students,id', 'book_id' => 'required|exists:books,id', 'issue_date' => 'required|date', 'return_date' => 'required|date', 'returned' => 'boolean']);
        Book_Issue::create($request->all());
        return redirect()->route('book_issued')->with('success', 'Book issue recorded successfully');
    }

    public function edit($id)
    {
        $bookIssue = Book_Issue::findOrFail($id);
        return view('book_issue.edit', compact('bookIssue'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['student_id' => 'required|exists:students,id', 'book_id' => 'required|exists:books,id', 'issue_date' => 'required|date', 'return_date' => 'required|date', 'returned' => 'boolean']);
        $bookIssue = Book_Issue::findOrFail($id);
        $bookIssue->update($request->all());
        return redirect()->route('book_issued')->with('success', 'Book issue updated successfully');
    }

    public function destroy($id)
    {
        $bookIssue = Book_Issue::findOrFail($id);
        $bookIssue->delete();
        return redirect()->route('book_issued')->with('success', 'Book issue deleted successfully');
    }
}