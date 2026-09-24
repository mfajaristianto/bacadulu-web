<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'author_2')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('author_2')->nullable()->after('author');
            });
        }

        if (!Schema::hasColumn('books', 'author_3')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('author_3')->nullable()->after('author_2');
            });
        }

        if (!Schema::hasColumn('books', 'show_authors')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('show_authors')->default(true)->after('author_3');
            });
        }

        if (!Schema::hasColumn('books', 'editor_2')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('editor_2')->nullable()->after('editor');
            });
        }

        if (!Schema::hasColumn('books', 'editor_3')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('editor_3')->nullable()->after('editor_2');
            });
        }

        if (!Schema::hasColumn('books', 'show_editors')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('show_editors')->default(false)->after('editor_3');
            });
        }

        // Semua data lama tetap menampilkan penulis seperti sebelumnya.
        DB::table('books')->update(['show_authors' => true]);

        // Editor lama mengikuti checkbox show_editor agar tidak mengubah tampilan lama.
        if (Schema::hasColumn('books', 'show_editor')) {
            DB::table('books')->update([
                'show_editors' => DB::raw('COALESCE(show_editor, 0)'),
            ]);
        }
    }

    public function down(): void
    {
        foreach ([
            'show_editors',
            'editor_3',
            'editor_2',
            'show_authors',
            'author_3',
            'author_2',
        ] as $column) {
            if (Schema::hasColumn('books', $column)) {
                Schema::table('books', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
