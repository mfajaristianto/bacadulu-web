<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Repair Existing Comments Table
    |--------------------------------------------------------------------------
    |
    | Migration ini khusus memperbaiki database lama yang mungkin sudah
    | memiliki tabel comments dari struktur development sebelumnya.
    |
    | Migration dibuat non-destructive:
    |
    | - Tidak menghapus komentar lama.
    | - Tidak menghapus kolom content lama.
    | - Menambahkan kolom yang hilang.
    | - Memindahkan nilai content lama ke body jika diperlukan.
    |
    */

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Table Does Not Exist
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();

                $table
                    ->foreignId('post_id')
                    ->constrained('posts')
                    ->cascadeOnDelete();

                $table
                    ->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->text('body');

                $table->timestamps();

                $table->index([
                    'post_id',
                    'created_at',
                ]);
            });

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Repair post_id
        |--------------------------------------------------------------------------
        |
        | Untuk database legacy kita membuatnya nullable supaya migration
        | tidak gagal apabila ternyata sudah terdapat record komentar lama
        | yang belum mempunyai hubungan post.
        |
        */

        if (!Schema::hasColumn('comments', 'post_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table
                    ->unsignedBigInteger('post_id')
                    ->nullable()
                    ->after('id');

                $table->index('post_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Repair user_id
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('comments', 'user_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table
                    ->unsignedBigInteger('user_id')
                    ->nullable()
                    ->after('post_id');

                $table->index('user_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Repair body
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('comments', 'body')) {
            Schema::table('comments', function (Blueprint $table) {
                $table
                    ->text('body')
                    ->nullable()
                    ->after('user_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Repair created_at
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('comments', 'created_at')) {
            Schema::table('comments', function (Blueprint $table) {
                $table
                    ->timestamp('created_at')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Repair updated_at
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('comments', 'updated_at')) {
            Schema::table('comments', function (Blueprint $table) {
                $table
                    ->timestamp('updated_at')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Copy Legacy content → body
        |--------------------------------------------------------------------------
        |
        | Beberapa versi database lama mungkin menggunakan "content".
        |
        | Kita tidak langsung menghapus content karena sekarang prioritasnya
        | menjaga data lama tetap aman.
        |
        */

        if (
            Schema::hasColumn('comments', 'content') &&
            Schema::hasColumn('comments', 'body')
        ) {
            DB::table('comments')
                ->whereNotNull('content')
                ->where(function ($query) {
                    $query
                        ->whereNull('body')
                        ->orWhere('body', '');
                })
                ->update([
                    'body' => DB::raw('content'),
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    |
    | Sengaja tidak melakukan rollback otomatis.
    |
    | Ini adalah migration perbaikan database lama. Menghapus kolom secara
    | otomatis ketika rollback justru berpotensi menghapus data komentar.
    |
    */

    public function down(): void
    {
        //
    }
};