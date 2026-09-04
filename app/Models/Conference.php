<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = [
        'name',
        'edition',
        'description',
        'poster',
        'conference_url',
        'proceeding_url',
    ];
}