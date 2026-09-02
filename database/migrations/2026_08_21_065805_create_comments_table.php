<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Create Comments Table
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        if (Schema::hasTable('comments')) {
            return;
        }

        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Post
            |--------------------------------------------------------------------------
            */

            $table
                ->foreignId('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Comment Body
            |--------------------------------------------------------------------------
            |
            | Nama kolom utama kita adalah "body".
            |
            | Form boleh tetap menggunakan:
            |
            | content
            |
            | tetapi database menggunakan:
            |
            | body
            |
            */

            $table->text('body');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index([
                'post_id',
                'created_at',
            ]);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};