<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $table = 'conferences';

    protected $fillable = ['title', 'event_date', 'description', 'poster'];
}