<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'student_id',
        'book_id',
        'book_title',
        'full_name',
        'payment_method',
        'price',
        'purchase_date',
    ];

    protected $casts = [
        'price' => 'decimal:2', // Correct syntax: decimal with 2 places
        'purchase_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}