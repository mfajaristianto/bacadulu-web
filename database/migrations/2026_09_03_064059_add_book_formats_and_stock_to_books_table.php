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
        | BUKU CETAK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('books', 'has_print')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('has_print')
                    ->default(false)
                    ->after('price');
            });
        }

        if (!Schema::hasColumn('books', 'print_price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('print_price', 15, 2)
                    ->nullable()
                    ->after('has_print');
            });
        }

        if (!Schema::hasColumn('books', 'print_stock')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedInteger('print_stock')
                    ->default(0)
                    ->after('print_price');
            });
        }

        if (!Schema::hasColumn('books', 'print_discount_percent')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('print_discount_percent', 5, 2)
                    ->nullable()
                    ->after('print_stock');
            });
        }

        if (!Schema::hasColumn('books', 'print_discounted_price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('print_discounted_price', 15, 2)
                    ->nullable()
                    ->after('print_discount_percent');
            });
        }

        if (!Schema::hasColumn('books', 'print_discount_expires_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('print_discount_expires_at')
                    ->nullable()
                    ->after('print_discounted_price');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | E-BOOK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('books', 'has_ebook')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('has_ebook')
                    ->default(false)
                    ->after('print_discount_expires_at');
            });
        }

        if (!Schema::hasColumn('books', 'ebook_price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('ebook_price', 15, 2)
                    ->nullable()
                    ->after('has_ebook');
            });
        }

        if (!Schema::hasColumn('books', 'ebook_discount_percent')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('ebook_discount_percent', 5, 2)
                    ->nullable()
                    ->after('ebook_price');
            });
        }

        if (!Schema::hasColumn('books', 'ebook_discounted_price')) {
            Schema::table('books', function (Blueprint $table) {
                $table->decimal('ebook_discounted_price', 15, 2)
                    ->nullable()
                    ->after('ebook_discount_percent');
            });
        }

        if (!Schema::hasColumn('books', 'ebook_discount_expires_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('ebook_discount_expires_at')
                    ->nullable()
                    ->after('ebook_discounted_price');
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SENGAJA TIDAK DROP
        |--------------------------------------------------------------------------
        |
        | Migration ini dipakai untuk melengkapi struktur database lama.
        | Sebagian kolom sudah ada sebelum migration ini dibuat.
        |
        | Jadi kita tidak menghapus kolom pada rollback agar kolom lama
        | yang sudah digunakan tidak ikut terhapus.
        |
        */
    }
};