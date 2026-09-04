<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('conferences', 'name')) {
            Schema::table('conferences', function (Blueprint $table) {
                $table->string('name')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('conferences', 'edition')) {
            Schema::table('conferences', function (Blueprint $table) {
                $table->string('edition', 50)->nullable()->after('name');
            });
        }

        if (!Schema::hasColumn('conferences', 'conference_url')) {
            Schema::table('conferences', function (Blueprint $table) {
                $table->text('conference_url')->nullable()->after('description');
            });
        }

        if (!Schema::hasColumn('conferences', 'proceeding_url')) {
            Schema::table('conferences', function (Blueprint $table) {
                $table->text('proceeding_url')->nullable()->after('conference_url');
            });
        }
    }

    public function down(): void
    {
        $columns = [];

        foreach ([
            'name',
            'edition',
            'conference_url',
            'proceeding_url',
        ] as $column) {
            if (Schema::hasColumn('conferences', $column)) {
                $columns[] = $column;
            }
        }

        if (!empty($columns)) {
            Schema::table('conferences', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};