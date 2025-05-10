<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book_Issue extends Model // Renamed from BookIssue to Book_Issue
{
    protected $table = 'book_issues'; // Ensure this matches your database table name
    protected $primaryKey = 'id'; // Adjust if different
    protected $fillable = ['student_id', 'book_id', 'issue_date', 'return_date', 'returned']; // Add fields as per your schema

    // Relationship with Book
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // Relationship with Student (if applicable)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}