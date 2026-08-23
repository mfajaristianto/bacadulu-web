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
        | BUKU CETAK
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('books', 'has_print')) {

            Schema::table('books', function (Blueprint $table) {

                $table->boolean('has_print')
                    ->default(false);

            });

        }


        if (!Schema::hasColumn('books', 'print_price')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal('print_price', 14, 2)
                    ->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'print_discount_percent')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal(
                    'print_discount_percent',
                    5,
                    2
                )->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'print_discounted_price')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal(
                    'print_discounted_price',
                    14,
                    2
                )->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'print_discount_expires_at')) {

            Schema::table('books', function (Blueprint $table) {

                $table->timestamp(
                    'print_discount_expires_at'
                )->nullable();

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
                    ->default(false);

            });

        }


        if (!Schema::hasColumn('books', 'ebook_price')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal('ebook_price', 14, 2)
                    ->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'ebook_discount_percent')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal(
                    'ebook_discount_percent',
                    5,
                    2
                )->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'ebook_discounted_price')) {

            Schema::table('books', function (Blueprint $table) {

                $table->decimal(
                    'ebook_discounted_price',
                    14,
                    2
                )->nullable();

            });

        }


        if (!Schema::hasColumn('books', 'ebook_discount_expires_at')) {

            Schema::table('books', function (Blueprint $table) {

                $table->timestamp(
                    'ebook_discount_expires_at'
                )->nullable();

            });

        }


        /*
        |--------------------------------------------------------------------------
        | KONVERSI DATA BUKU LAMA
        |--------------------------------------------------------------------------
        |
        | Buku lama dianggap sebagai Buku Cetak.
        |--------------------------------------------------------------------------
        */

        DB::table('books')
            ->whereNotNull('price')
            ->where(function ($query) {

                $query
                    ->whereNull('print_price')
                    ->orWhere('has_print', false);

            })
            ->update([

                'has_print' => true,

                'print_price' =>
                    DB::raw('price'),

                'print_discounted_price' =>
                    DB::raw('discounted_price'),

                'print_discount_expires_at' =>
                    DB::raw('discount_expires_at'),

            ]);


        /*
        |--------------------------------------------------------------------------
        | HITUNG PERSENTASE DISKON DATA LAMA
        |--------------------------------------------------------------------------
        */

        DB::table('books')
            ->whereNotNull('discounted_price')
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->whereNull('print_discount_percent')
            ->update([

                'print_discount_percent' =>
                    DB::raw(
                        'ROUND(((price - discounted_price) / price) * 100, 2)'
                    ),

            ]);
    }


    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {

            $columns = [

                'has_print',

                'print_price',

                'print_discount_percent',

                'print_discounted_price',

                'print_discount_expires_at',

                'has_ebook',

                'ebook_price',

                'ebook_discount_percent',

                'ebook_discounted_price',

                'ebook_discount_expires_at',

            ];


            foreach ($columns as $column) {

                if (
                    Schema::hasColumn(
                        'books',
                        $column
                    )
                ) {

                    $table->dropColumn(
                        $column
                    );

                }

            }

        });
    }
};