<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name']; // Adjust based on your schema

    // Relationship with Book (if applicable)
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}