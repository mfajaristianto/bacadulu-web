<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CEGAH ERROR TABLE SUDAH ADA
        |--------------------------------------------------------------------------
        |
        | Database Anda ternyata sudah mempunyai tabel comments,
        | sedangkan migration ini belum tercatat sebagai "Ran".
        |
        | Jadi apabila tabel sudah ada, migration dilewati tanpa
        | menghapus data comments yang sudah tersimpan.
        |
        */

        if (!Schema::hasTable('comments')) {

            Schema::create('comments', function (Blueprint $table) {

                $table->id();

                $table->timestamps();

            });

        }
    }


    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};