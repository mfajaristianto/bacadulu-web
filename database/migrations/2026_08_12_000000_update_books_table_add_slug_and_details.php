<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('books', 'description')) {
                $table->longText('description')->nullable()->after('cover');
            }
            if (!Schema::hasColumn('books', 'pages')) {
                $table->integer('pages')->nullable()->after('description');
            }
            if (!Schema::hasColumn('books', 'category')) {
                $table->string('category')->nullable()->after('pages');
            }
            if (!Schema::hasColumn('books', 'size')) {
                $table->string('size')->nullable()->after('category');
            }
            if (!Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn')->nullable()->after('size');
            }
            if (!Schema::hasColumn('books', 'publish_year')) {
                $table->integer('publish_year')->nullable()->after('isbn');
            }
            if (!Schema::hasColumn('books', 'discounted_price')) {
                $table->decimal('discounted_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('books', 'discount_expires_at')) {
                $table->timestamp('discount_expires_at')->nullable()->after('discounted_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('books', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('books', 'pages')) {
                $table->dropColumn('pages');
            }
            if (Schema::hasColumn('books', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('books', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('books', 'isbn')) {
                $table->dropColumn('isbn');
            }
            if (Schema::hasColumn('books', 'publish_year')) {
                $table->dropColumn('publish_year');
            }
            if (Schema::hasColumn('books', 'discounted_price')) {
                $table->dropColumn('discounted_price');
            }
            if (Schema::hasColumn('books', 'discount_expires_at')) {
                $table->dropColumn('discount_expires_at');
            }
        });
    }
};
