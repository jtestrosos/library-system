<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class publisher extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define the relationship with books
    public function books()
    {
        return $this->hasMany(book::class, 'publisher_id');
    }
}