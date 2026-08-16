<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'user_id',
        'status',
        'members_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Community creator
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Community members
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'community_members')
                    ->withTimestamps()
                    ->withPivot('joined_at');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Get only approved communities
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get only pending communities
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get only rejected communities
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is a member
     */
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    /**
     * Check if user is the creator
     */
    public function isCreator($userId)
    {
        return $this->user_id === $userId;
    }
}
