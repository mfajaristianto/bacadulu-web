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
        'rejection_reason',
        'similarity_score',
        'similarity_source_post_id',
        'similarity_source_title',
        'similarity_source_author',
        'rejected_at',
        'views',
    ];


    protected function casts(): array
    {
        return [
            'similarity_score' => 'decimal:2',
            'rejected_at' => 'datetime',
        ];
    }


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
    | Similarity Source Post
    |--------------------------------------------------------------------------
    |
    | Artikel/naskah lain yang menjadi pembanding tertinggi pada saat artikel
    | ini ditolak karena similarity internal.
    |
    */
    public function similaritySourcePost()
    {
        return $this->belongsTo(
            Post::class,
            'similarity_source_post_id'
        );
    }




    /*
    |--------------------------------------------------------------------------
    | Originality Audit
    |--------------------------------------------------------------------------
    */

    public function originalityChecks()
    {
        return $this->hasMany(
            PostOriginalityCheck::class
        );
    }

    public function latestOriginalityCheck()
    {
        return $this->hasOne(
            PostOriginalityCheck::class
        )->latestOfMany();
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