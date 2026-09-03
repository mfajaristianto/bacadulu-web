<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'content',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | CONTENT COMPATIBILITY
    |--------------------------------------------------------------------------
    |
    | Database lama menggunakan kolom "body".
    | UI / controller baru menggunakan nama "content".
    |
    | Dengan accessor + mutator ini:
    |
    | $comment->content
    |
    | otomatis membaca:
    |
    | comments.body
    |
    | Dan ketika controller menjalankan:
    |
    | Comment::create(['content' => '...'])
    |
    | nilainya otomatis disimpan ke kolom "body".
    |
    */

    public function getContentAttribute(): string
    {
        return $this->attributes['body'] ?? '';
    }

    public function setContentAttribute($value): void
    {
        $this->attributes['body'] = $value;
    }
}