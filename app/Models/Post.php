<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
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
    | USER
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
    | COMMENTS
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
    | LIKES
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
    | CEK LIKE USER
    |--------------------------------------------------------------------------
    */

    public function isLikedBy($userId): bool
    {
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