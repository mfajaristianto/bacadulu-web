<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_access_passwords', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('recovery_request_id')
                ->unique()
                ->constrained('admin_recovery_requests')
                ->cascadeOnDelete();

            $table->string('holder_name');
            $table->string('holder_email');

            $table->string('password_hash');

            $table->boolean('is_active')->default(true);

            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->index('holder_email');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_access_passwords');
    }
};