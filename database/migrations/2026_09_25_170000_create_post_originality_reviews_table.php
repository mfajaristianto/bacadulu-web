<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_originality_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->string('manuscript_hash', 64);
            $table->decimal('coverage', 5, 2)->default(0);
            $table->decimal('review_limit', 5, 2)->default(20);
            $table->string('scan_status', 20)->default('safe');
            $table->boolean('exact_copy')->default(false);
            $table->unsignedInteger('source_count')->default(0);
            $table->json('top_sources')->nullable();
            $table->string('decision', 40)->nullable();
            $table->text('decision_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->unique(['post_id', 'manuscript_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_originality_reviews');
    }
};
