<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('jurnals', 'e_issn')) {
            Schema::table('jurnals', function (Blueprint $table) {
                $table->string('e_issn', 50)->nullable()->after('judul');
            });
        }

        if (!Schema::hasColumn('jurnals', 'p_issn')) {
            Schema::table('jurnals', function (Blueprint $table) {
                $table->string('p_issn', 50)->nullable()->after('e_issn');
            });
        }

        if (!Schema::hasColumn('jurnals', 'journal_url')) {
            Schema::table('jurnals', function (Blueprint $table) {
                $table->text('journal_url')->nullable()->after('deskripsi');
            });
        }

        if (!Schema::hasColumn('jurnals', 'current_issue_url')) {
            Schema::table('jurnals', function (Blueprint $table) {
                $table->text('current_issue_url')->nullable()->after('journal_url');
            });
        }
    }

    public function down(): void
    {
        $columns = [];

        foreach ([
            'e_issn',
            'p_issn',
            'journal_url',
            'current_issue_url',
        ] as $column) {
            if (Schema::hasColumn('jurnals', $column)) {
                $columns[] = $column;
            }
        }

        if (!empty($columns)) {
            Schema::table('jurnals', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};