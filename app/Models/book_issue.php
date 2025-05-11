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
}