<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataArticle extends Model
{
    protected $table = 'data_articles';

    protected $fillable = ['title', 'description', 'image'];
}