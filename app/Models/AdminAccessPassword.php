<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAccessPassword extends Model
{
    protected $fillable = [
        'user_id',
        'recovery_request_id',
        'holder_name',
        'holder_email',
        'password_hash',
        'is_active',
        'last_used_at',
        'revoked_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recoveryRequest()
    {
        return $this->belongsTo(
            AdminRecoveryRequest::class,
            'recovery_request_id'
        );
    }
}