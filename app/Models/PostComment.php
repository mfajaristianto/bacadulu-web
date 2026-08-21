<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Arahkan ke tabel yang benar di database
    protected $table = 'post_comments';

    // Gunakan 'content' sesuai kolom migrasi
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}