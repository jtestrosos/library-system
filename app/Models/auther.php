<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auther extends Model
{
    protected $table = 'authers'; // Ensure this matches your database table name
    protected $primaryKey = 'id'; // Adjust if different
    protected $fillable = ['name', 'email']; // Add fields as per your schema

    // Relationship with Book (if applicable)
    public function books()
    {
        return $this->hasMany(Book::class, 'auther_id'); // Adjust foreign key if different
    }
}