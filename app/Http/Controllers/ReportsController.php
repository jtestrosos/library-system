<?php

namespace App\Http\Controllers;

use App\Models\Book_Issue;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function date_wise()
    {
        return view('reports.date_wise');
    }

    public function generate_date_wise_report(Request $request)
    {
        // Add logic to generate date-wise report
        return redirect()->route('reports')->with('success', 'Date-wise report generated');
    }

    public function month_wise()
    {
        return view('reports.month_wise');
    }

    public function generate_month_wise_report(Request $request)
    {
        // Add logic to generate month-wise report
        return redirect()->route('reports')->with('success', 'Month-wise report generated');
    }

    public function not_returned()
    {
        $notReturned = Book_Issue::where('returned', false)->where('return_date', '<', now())->paginate(5);
        return view('reports.not_returned', compact('notReturned'));
    }
}