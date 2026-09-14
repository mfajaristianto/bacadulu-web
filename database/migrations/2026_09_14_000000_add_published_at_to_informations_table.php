<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('informations', 'published_at')) {
            Schema::table('informations', function (Blueprint $table) {
                $table->date('published_at')
                    ->nullable()
                    ->after('image');
            });
        }

        DB::table('informations')
            ->whereNull('published_at')
            ->whereNotNull('created_at')
            ->update([
                'published_at' => DB::raw('DATE(created_at)'),
            ]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('informations', 'published_at')) {
            Schema::table('informations', function (Blueprint $table) {
                $table->dropColumn('published_at');
            });
        }
    }
};
