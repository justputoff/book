<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'cover_image',
        'page',
        'user_id',
        'pdf',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
