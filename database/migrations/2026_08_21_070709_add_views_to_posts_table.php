<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | TAMBAH KOLOM VIEWS JIKA BELUM ADA
        |--------------------------------------------------------------------------
        |
        | Database Anda sudah memiliki kolom "views".
        | Jadi migration hanya menambah kolom jika memang belum ada.
        |
        */

        if (!Schema::hasColumn('posts', 'views')) {

            Schema::table('posts', function (Blueprint $table) {

                $table
                    ->unsignedBigInteger('views')
                    ->default(0);

            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS KOLOM VIEWS JIKA ADA
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('posts', 'views')) {

            Schema::table('posts', function (Blueprint $table) {

                $table->dropColumn('views');

            });
        }
    }
};