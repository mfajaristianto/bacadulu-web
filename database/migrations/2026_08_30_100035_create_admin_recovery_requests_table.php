<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_recovery_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();

            // Akun admin website yang ingin diakses
            $table->string('admin_email');

            // Identitas pemohon
            $table->string('requester_name');
            $table->string('requester_position')->nullable();
            $table->string('requester_email');
            $table->string('requester_phone', 30);

            // Alasan recovery
            $table->text('reason');
            $table->text('notes')->nullable();

            // Status permohonan
            $table->string('status', 20)->default('pending');

            // Approval
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            // Audit sederhana
            $table->string('request_ip', 45)->nullable();
            $table->text('request_user_agent')->nullable();

            // Nanti dipakai setelah ACC
            $table->timestamp('password_created_at')->nullable();

            $table->timestamps();

            $table->index('admin_email');
            $table->index('requester_email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_recovery_requests');
    }
};