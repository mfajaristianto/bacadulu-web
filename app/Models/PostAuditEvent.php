<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAuditEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id', 'actor_user_id', 'event', 'manuscript_hash', 'metadata', 'created_at'];

    protected function casts(): array
    {
        return ['metadata' => 'array', 'created_at' => 'datetime'];
    }

    public function post() { return $this->belongsTo(Post::class); }
    public function actor() { return $this->belongsTo(User::class, 'actor_user_id'); }
}
