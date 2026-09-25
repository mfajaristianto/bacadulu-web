<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_verifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status', 20)
                ->default('pending')
                ->index();

            $table->string('institution')->nullable();

            $table->string('orcid_url')->nullable();

            $table->string('google_scholar_url')->nullable();

            $table->string('publication_url')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PRIVATE EVIDENCE FILE
            |--------------------------------------------------------------------------
            |
            | File disimpan di storage/app/private.
            | Tidak diletakkan di public/storage.
            |
            */

            $table->string('evidence_path')->nullable();

            $table->string('evidence_original_name')->nullable();

            $table->text('admin_note')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Satu status verifikasi aktif per akun
            |--------------------------------------------------------------------------
            */

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_verifications');
    }
};