<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'judul',
        'e_issn',
        'p_issn',
        'deskripsi',
        'journal_url',
        'current_issue_url',
        'file_pdf',
        'gambar',
    ];

    /*
    |--------------------------------------------------------------------------
    | Description Sanitizer
    |--------------------------------------------------------------------------
    |
    | Deskripsi jurnal dibersihkan ketika disimpan dan ketika dibaca.
    | Dengan begitu data lama maupun data baru tetap aman jika suatu view
    | menampilkan deskripsi menggunakan sintaks Blade raw HTML ({!! !!}).
    |
    */

    protected function deskripsi(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => HtmlSanitizer::clean((string) $value),
            set: fn ($value) => HtmlSanitizer::clean((string) $value),
        );
    }
}
