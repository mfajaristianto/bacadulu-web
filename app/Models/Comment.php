<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Balasan langsung. Relasi ini ikut memuat user + balasan berikutnya
     * supaya thread komentar bisa dirender rekursif tanpa mengubah tabel lain.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with(['user.authorVerification', 'parent.user', 'replies'])
            ->oldest();
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