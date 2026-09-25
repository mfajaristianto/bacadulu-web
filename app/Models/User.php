<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function communities()
    {
        return $this->hasMany(Community::class);
    }

    public function memberCommunities()
    {
        return $this->belongsToMany(
            Community::class,
            'community_members'
        )
            ->withTimestamps()
            ->withPivot('joined_at');
    }

    /*
    |--------------------------------------------------------------------------
    | AUTHOR VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function authorVerification()
    {
        return $this->hasOne(
            AuthorVerification::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIED AUTHOR
    |--------------------------------------------------------------------------
    */

    public function isVerifiedAuthor(): bool
    {
        return $this->authorVerification?->status === 'approved';
    }

    /*
    |--------------------------------------------------------------------------
    | AUTHOR VERIFICATION STATUS
    |--------------------------------------------------------------------------
    */

    public function authorVerificationStatus(): string
    {
        return $this->authorVerification?->status ?? 'unverified';
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel($panel): bool
    {
        return $this->is_admin === true;
    }
}