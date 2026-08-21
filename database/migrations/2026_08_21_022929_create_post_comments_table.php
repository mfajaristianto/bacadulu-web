<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model // Sesuaikan dengan nama file model kamu
{
    use HasFactory;

    // INI WAJIB ADA karena nama tabel di database kamu adalah 'post_comments'
    protected $table = 'post_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}