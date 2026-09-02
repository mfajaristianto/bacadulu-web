<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'author',
        'title',
        'slug',
        'content',
        'image',
        'category',
        'status',
        'views',
    ];


    /*
    |--------------------------------------------------------------------------
    | Content Sanitizer
    |--------------------------------------------------------------------------
    |
    | SET:
    |
    | Setiap content yang masuk ke database dibersihkan terlebih dahulu.
    |
    | Contoh:
    |
    | <script>alert(1)</script>
    |
    | tidak akan disimpan sebagai script yang dapat dieksekusi.
    |
    |
    | GET:
    |
    | Content lama yang sudah ada di database juga dibersihkan setiap kali
    | dibaca.
    |
    | Ini penting karena mungkin ada artikel lama yang dibuat sebelum
    | sanitizer diterapkan.
    |
    */

    protected function content(): Attribute
    {
        return Attribute::make(

            /*
            |--------------------------------------------------------------------------
            | Read
            |--------------------------------------------------------------------------
            */

            get: function ($value) {
                return HtmlSanitizer::clean(
                    (string) $value
                );
            },

            /*
            |--------------------------------------------------------------------------
            | Write
            |--------------------------------------------------------------------------
            */

            set: function ($value) {
                return HtmlSanitizer::clean(
                    (string) $value
                );
            },
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User
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
    | Comments
    |--------------------------------------------------------------------------
    */

    public function comments()
    {
        return $this->hasMany(
            Comment::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Likes
    |--------------------------------------------------------------------------
    */

    public function likes()
    {
        return $this->hasMany(
            PostLike::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Check User Like
    |--------------------------------------------------------------------------
    */

    public function isLikedBy(
        $userId
    ): bool {
        if (!$userId) {
            return false;
        }

        return $this
            ->likes()
            ->where(
                'user_id',
                $userId
            )
            ->exists();
    }
}