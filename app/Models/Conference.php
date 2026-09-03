<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $table = 'conferences';

    protected $fillable = [
        'title',
        'event_date',
        'event_time',
        'location',
        'description',
        'poster',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}