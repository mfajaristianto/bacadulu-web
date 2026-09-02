<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Communities
        |--------------------------------------------------------------------------
        |
        | Database lama sudah memiliki tabel communities.
        | Guard ini membuat migration aman dijalankan tanpa mencoba
        | membuat ulang tabel yang sudah ada.
        |
        */

        if (Schema::hasTable('communities')) {
            return;
        }

        Schema::create('communities', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('description')->nullable();

            $table->string('icon')->nullable();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('status')
                ->default('pending');

            $table->unsignedInteger('members_count')
                ->default(0);

            $table->timestamps();

            /*
             * Mempercepat query admin seperti:
             *
             * Community::where('status', 'pending')->count()
             */
            $table->index('status');

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};