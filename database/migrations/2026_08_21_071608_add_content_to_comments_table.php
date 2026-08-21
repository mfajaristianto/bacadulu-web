<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom content ke tabel comments.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('comments', 'content')) {

            Schema::table('comments', function (Blueprint $table) {

                $table
                    ->text('content')
                    ->nullable()
                    ->after('user_id');

            });
        }
    }


    /**
     * Rollback.
     */
    public function down(): void
    {
        if (Schema::hasColumn('comments', 'content')) {

            Schema::table('comments', function (Blueprint $table) {

                $table->dropColumn('content');

            });
        }
    }
};