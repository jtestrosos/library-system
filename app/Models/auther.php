<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auther extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Specify the correct table name
    protected $table = 'authers';

    // Define the relationship with books
    public function books()
    {
        return $this->hasMany(book::class, 'auther_id');
    }
}