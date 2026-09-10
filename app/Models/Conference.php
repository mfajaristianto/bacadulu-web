<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION SANITIZER
    |--------------------------------------------------------------------------
    |
    | Deskripsi conference berasal dari rich text editor admin. HTML dibersihkan
    | saat disimpan dan dibaca agar script, event handler, javascript: URL,
    | iframe, object, embed, dan HTML berbahaya lainnya tidak tersimpan atau
    | ditampilkan kembali.
    |
    */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => HtmlSanitizer::clean((string) $value),
            set: fn ($value) => HtmlSanitizer::clean((string) $value),
        );
    }
}
