<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category',
        'user_id',
        'author',
        'status',
    ];

    /**
     * Relasi ke user/penulis
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi komentar
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}