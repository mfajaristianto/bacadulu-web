<?php

namespace App\Models;

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
}