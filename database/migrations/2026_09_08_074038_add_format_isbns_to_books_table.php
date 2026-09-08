<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ISBN BUKU CETAK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('books', 'print_isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('print_isbn')
                    ->nullable()
                    ->after('print_stock');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ISBN E-BOOK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('books', 'ebook_isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('ebook_isbn')
                    ->nullable()
                    ->after('ebook_price');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | PINDAHKAN ISBN DATA LAMA
        |--------------------------------------------------------------------------
        |
        | Jika buku lama hanya punya satu format, ISBN lama bisa diketahui
        | dengan aman sebagai ISBN format tersebut.
        |
        | Jika buku memiliki Buku Cetak + E-Book sekaligus, ISBN lama sengaja
        | tidak disalin otomatis karena ISBN kedua format dapat berbeda.
        |
        */

        DB::table('books')
            ->where('has_print', true)
            ->where('has_ebook', false)
            ->whereNull('print_isbn')
            ->whereNotNull('isbn')
            ->update([
                'print_isbn' => DB::raw('isbn'),
            ]);

        DB::table('books')
            ->where('has_print', false)
            ->where('has_ebook', true)
            ->whereNull('ebook_isbn')
            ->whereNotNull('isbn')
            ->update([
                'ebook_isbn' => DB::raw('isbn'),
            ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('books', 'print_isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('print_isbn');
            });
        }

        if (Schema::hasColumn('books', 'ebook_isbn')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('ebook_isbn');
            });
        }
    }
};