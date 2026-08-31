<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminRecoveryRequest extends Model
{
    protected $fillable = [
        'public_id',
        'admin_email',
        'requester_name',
        'requester_position',
        'requester_email',
        'requester_phone',
        'reason',
        'notes',
        'status',
        'approved_by',
        'approved_at',
        'rejected_at',
        'request_ip',
        'request_user_agent',
        'password_created_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'password_created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (AdminRecoveryRequest $request) {
            if (!$request->public_id) {
                $request->public_id = (string) Str::uuid();
            }

            if (!$request->status) {
                $request->status = 'pending';
            }
        });
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}