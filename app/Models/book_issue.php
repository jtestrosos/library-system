<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        $today = now();
        $returnDate = \Carbon\Carbon::parse($this->return_date);
        return $today->diffInDays($returnDate, false);
    }

    public function getFineAttribute()
    {
        if ($this->returned || $this->getDaysRemainingAttribute() >= 0) {
            return 0;
        }
        $finePerDay = 1;
        return abs($this->getDaysRemainingAttribute()) * $finePerDay;
    }
}