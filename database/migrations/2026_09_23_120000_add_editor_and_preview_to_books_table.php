<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'editor')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('editor', 1000)->nullable()->after('author');
            });
        }

        if (!Schema::hasColumn('books', 'show_editor')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('show_editor')->default(false)->after('editor');
            });
        }

        if (!Schema::hasColumn('books', 'preview_pdf')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('preview_pdf')->nullable()->after('cover');
            });
        }

        // Data yang sudah tayang di Bookstore tetapi masih Pending Publisher
        // merupakan kondisi workflow lama. Sinkronkan agar ikut tampil di katalog
        // BacaPublisher, tanpa menghidupkan kembali buku yang sengaja direject.
        DB::table('books')
            ->where('store_status', 'approved')
            ->where(function ($query) {
                $query
                    ->whereNull('publisher_status')
                    ->orWhere('publisher_status', '')
                    ->orWhere('publisher_status', 'pending');
            })
            ->update([
                'publisher_status' => 'approved',
                'publisher_review_note' => null,
                'publisher_approved_at' => DB::raw('COALESCE(publisher_approved_at, store_approved_at, updated_at, NOW())'),
            ]);
    }

    public function down(): void
    {
        foreach (['preview_pdf', 'show_editor', 'editor'] as $column) {
            if (Schema::hasColumn('books', $column)) {
                Schema::table('books', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
