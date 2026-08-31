<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trusted_devices', function (Blueprint $table) {
            $table->string('credential_type', 20)
                ->default('primary')
                ->after('user_id');

            $table->foreignId('access_password_id')
                ->nullable()
                ->after('credential_type')
                ->constrained('admin_access_passwords')
                ->nullOnDelete();

            $table->index(
                ['user_id', 'credential_type', 'access_password_id'],
                'trusted_devices_credential_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('trusted_devices', function (Blueprint $table) {
            $table->dropIndex('trusted_devices_credential_index');
            $table->dropForeign(['access_password_id']);

            $table->dropColumn([
                'credential_type',
                'access_password_id',
            ]);
        });
    }
};