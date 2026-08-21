<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'post_id',
        'user_id',
        'body',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI POST
    |--------------------------------------------------------------------------
    */

    public function post()
    {
        return $this->belongsTo(
            Post::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPATIBILITY ACCESSOR
    |--------------------------------------------------------------------------
    |
    | Database menggunakan:
    |
    | $comment->body
    |
    | Tetapi Blade yang sudah Anda dan teman Anda buat menggunakan:
    |
    | $comment->content
    |
    | Accessor ini membuat keduanya tetap bekerja tanpa perlu mengubah
    | seluruh Blade.
    |
    |--------------------------------------------------------------------------
    */

    public function getContentAttribute()
    {
        return $this->body;
    }
}