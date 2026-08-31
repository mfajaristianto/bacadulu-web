<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustedDevice extends Model
{
    protected $fillable = [
        'user_id',
        'credential_type',
        'access_password_id',
        'token_hash',
        'user_agent',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accessPassword()
    {
        return $this->belongsTo(
            AdminAccessPassword::class,
            'access_password_id'
        );
    }
}