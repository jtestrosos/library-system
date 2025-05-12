<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['name', 'auther_id', 'publisher_id', 'category_id', 'status']; // Changed 'title' to 'name'

    public function auther()
    {
        return $this->belongsTo(Auther::class, 'auther_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function bookIssues()
    {
        return $this->hasMany(Book_Issue::class, 'book_id');
    }

    // Optional: Map 'name' to 'title' for compatibility with existing UI code
    public function getTitleAttribute()
    {
        return $this->attributes['name'];
    }
}