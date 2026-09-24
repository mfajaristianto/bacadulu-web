<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('comments') || Schema::hasColumn('comments', 'parent_id')) {
            return;
        }

        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('user_id')
                ->constrained('comments')
                ->cascadeOnDelete();

            $table->index(['post_id', 'parent_id', 'created_at']);
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('comments') || !Schema::hasColumn('comments', 'parent_id')) {
            return;
        }

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['post_id', 'parent_id', 'created_at']);
            $table->dropConstrainedForeignId('parent_id');
        });
    }
};
