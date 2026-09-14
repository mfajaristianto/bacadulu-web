<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'source')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('source', 50)
                    ->default('manual')
                    ->after('publish_year');
            });
        }

        if (!Schema::hasColumn('books', 'external_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('external_id', 191)
                    ->nullable()
                    ->after('source');
            });
        }

        if (!Schema::hasColumn('books', 'external_cover_url')) {
            Schema::table('books', function (Blueprint $table) {
                $table->text('external_cover_url')
                    ->nullable()
                    ->after('external_id');
            });
        }

        if (!Schema::hasColumn('books', 'publisher_status')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('publisher_status', 30)
                    ->default('approved')
                    ->after('external_cover_url');
            });
        }

        if (!Schema::hasColumn('books', 'publisher_review_note')) {
            Schema::table('books', function (Blueprint $table) {
                $table->text('publisher_review_note')
                    ->nullable()
                    ->after('publisher_status');
            });
        }

        if (!Schema::hasColumn('books', 'publisher_approved_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('publisher_approved_at')
                    ->nullable()
                    ->after('publisher_review_note');
            });
        }

        if (!Schema::hasColumn('books', 'store_status')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('store_status', 30)
                    ->default('approved')
                    ->after('publisher_approved_at');
            });
        }

        if (!Schema::hasColumn('books', 'store_review_note')) {
            Schema::table('books', function (Blueprint $table) {
                $table->text('store_review_note')
                    ->nullable()
                    ->after('store_status');
            });
        }

        if (!Schema::hasColumn('books', 'store_approved_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('store_approved_at')
                    ->nullable()
                    ->after('store_review_note');
            });
        }

        if (!Schema::hasColumn('books', 'last_synced_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('last_synced_at')
                    ->nullable()
                    ->after('store_approved_at');
            });
        }

        if (!Schema::hasColumn('books', 'source_updated_at')) {
            Schema::table('books', function (Blueprint $table) {
                $table->timestamp('source_updated_at')
                    ->nullable()
                    ->after('last_synced_at');
            });
        }

        if (!Schema::hasColumn('books', 'api_payload')) {
            Schema::table('books', function (Blueprint $table) {
                $table->json('api_payload')
                    ->nullable()
                    ->after('source_updated_at');
            });
        }

        if (!Schema::hasColumn('books', 'pending_api_payload')) {
            Schema::table('books', function (Blueprint $table) {
                $table->json('pending_api_payload')
                    ->nullable()
                    ->after('api_payload');
            });
        }

        if (!Schema::hasColumn('books', 'has_pending_sync')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('has_pending_sync')
                    ->default(false)
                    ->after('pending_api_payload');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Data lama tetap tayang
        |--------------------------------------------------------------------------
        |
        | Sebelum workflow approval dibuat, seluruh buku yang ada dianggap sudah
        | disetujui. Dengan begitu migration ini tidak membuat Publisher atau
        | Bookstore yang sekarang tiba-tiba kosong setelah deploy.
        |
        */
        DB::table('books')
            ->whereNull('publisher_approved_at')
            ->update([
                'publisher_status' => 'approved',
                'publisher_approved_at' => DB::raw('COALESCE(created_at, NOW())'),
            ]);

        DB::table('books')
            ->whereNull('store_approved_at')
            ->update([
                'store_status' => 'approved',
                'store_approved_at' => DB::raw('COALESCE(created_at, NOW())'),
            ]);
    }

    public function down(): void
    {
        $columns = [
            'source',
            'external_id',
            'external_cover_url',
            'publisher_status',
            'publisher_review_note',
            'publisher_approved_at',
            'store_status',
            'store_review_note',
            'store_approved_at',
            'last_synced_at',
            'source_updated_at',
            'api_payload',
            'pending_api_payload',
            'has_pending_sync',
        ];

        foreach (array_reverse($columns) as $column) {
            if (Schema::hasColumn('books', $column)) {
                Schema::table('books', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
