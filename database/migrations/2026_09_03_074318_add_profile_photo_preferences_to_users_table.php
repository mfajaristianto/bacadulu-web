<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'profile_photo')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo')
                    ->nullable()
                    ->after('avatar');
            });
        }

        if (!Schema::hasColumn('users', 'avatar_source')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar_source', 20)
                    ->default('google')
                    ->after('profile_photo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'avatar_source')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar_source');
            });
        }

        if (Schema::hasColumn('users', 'profile_photo')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('profile_photo');
            });
        }
    }
};