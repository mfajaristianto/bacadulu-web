<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Legacy Migration
    |--------------------------------------------------------------------------
    |
    | Migration ini sebelumnya membuat kolom "content".
    |
    | Struktur komentar terbaru menggunakan kolom:
    |
    | body
    |
    | sehingga migration lama ini sengaja dipertahankan sebagai migration
    | kosong agar urutan migration historis Laravel tidak perlu dihapus atau
    | diganti nama.
    |
    | Database lama akan diperbaiki oleh migration repair yang dibuat
    | setelah migration ini.
    |
    */

    public function up(): void
    {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        //
    }
};