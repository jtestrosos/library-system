<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book_Issue extends Model
{
    protected $table = 'book_issues';
    protected $fillable = ['student_id', 'book_id', 'issue_date', 'return_date', 'returned'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->returned) {
            return 0;
        }
        $today = Carbon::now();
        $returnDate = Carbon::parse($this->return_date);
        return $today->diffInDays($returnDate, false); // Negative if overdue
    }

    public function getFineAttribute()
    {
        if ($this->returned || $this->getDaysRemainingAttribute() >= 0) {
            return 0;
        }
        $finePerDay = 1; // ₱1 per day
        return abs($this->getDaysRemainingAttribute()) * $finePerDay;
    }
}