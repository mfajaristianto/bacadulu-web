<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publishers';

    protected $fillable = [
        'name',
        'about',
        'logo_or_cover',
    ];

    protected function about(): Attribute
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