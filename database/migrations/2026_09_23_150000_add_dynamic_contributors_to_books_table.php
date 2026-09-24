<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'author_names')) {
                $table->json('author_names')->nullable()->after('show_authors');
            }
            if (!Schema::hasColumn('books', 'author_display_mode')) {
                $table->string('author_display_mode', 20)->default('inline')->after('author_names');
            }
            if (!Schema::hasColumn('books', 'primary_author')) {
                $table->string('primary_author')->nullable()->after('author_display_mode');
            }
            if (!Schema::hasColumn('books', 'editor_names')) {
                $table->json('editor_names')->nullable()->after('show_editors');
            }
            if (!Schema::hasColumn('books', 'editor_display_mode')) {
                $table->string('editor_display_mode', 20)->default('inline')->after('editor_names');
            }
            if (!Schema::hasColumn('books', 'primary_editor')) {
                $table->string('primary_editor')->nullable()->after('editor_display_mode');
            }
        });

        // Backfill data lama. Format BacaPublisher umumnya berupa nama dipisah koma.
        DB::table('books')->orderBy('id')->chunkById(100, function ($books) {
            foreach ($books as $book) {
                $authors = $this->namesFromLegacy([
                    $book->author ?? null,
                    $book->author_2 ?? null,
                    $book->author_3 ?? null,
                ]);

                $editors = $this->namesFromLegacy([
                    $book->editor ?? null,
                    $book->editor_2 ?? null,
                    $book->editor_3 ?? null,
                ]);

                DB::table('books')->where('id', $book->id)->update([
                    'author_names' => json_encode($authors, JSON_UNESCAPED_UNICODE),
                    'author_display_mode' => 'inline',
                    'primary_author' => null,
                    'editor_names' => json_encode($editors, JSON_UNESCAPED_UNICODE),
                    'editor_display_mode' => 'inline',
                    'primary_editor' => null,
                ]);
            }
        });
    }

    private function namesFromLegacy(array $values): array
    {
        $names = [];

        foreach ($values as $value) {
            if (!is_string($value) || trim($value) === '') {
                continue;
            }

            foreach (preg_split('/\\s*(?:,|;|\\r?\\n)\\s*/u', trim($value)) ?: [] as $name) {
                $name = trim($name);
                if ($name !== '' && !in_array($name, $names, true)) {
                    $names[] = $name;
                }
            }
        }

        return $names;
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            foreach ([
                'primary_editor',
                'editor_display_mode',
                'editor_names',
                'primary_author',
                'author_display_mode',
                'author_names',
            ] as $column) {
                if (Schema::hasColumn('books', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
