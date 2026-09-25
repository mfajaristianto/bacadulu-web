<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('rejection_reason')
                ->nullable()
                ->after('status');

            $table->decimal('similarity_score', 5, 2)
                ->nullable()
                ->after('rejection_reason');

            $table->foreignId('similarity_source_post_id')
                ->nullable()
                ->after('similarity_score')
                ->constrained('posts')
                ->nullOnDelete();

            $table->string('similarity_source_title')
                ->nullable()
                ->after('similarity_source_post_id');

            $table->string('similarity_source_author')
                ->nullable()
                ->after('similarity_source_title');

            $table->timestamp('rejected_at')
                ->nullable()
                ->after('similarity_source_author');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign([
                'similarity_source_post_id',
            ]);

            $table->dropColumn([
                'rejection_reason',
                'similarity_score',
                'similarity_source_post_id',
                'similarity_source_title',
                'similarity_source_author',
                'rejected_at',
            ]);
        });
    }
};
