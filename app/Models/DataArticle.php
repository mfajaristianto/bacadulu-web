<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class DataArticle extends Model
{
    protected $table = 'data_articles';

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => HtmlSanitizer::clean(
                $value !== null ? (string) $value : null
            ),
            set: fn ($value) => HtmlSanitizer::clean(
                $value !== null ? (string) $value : null
            ),
        );
    }
}