<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('rating');
            $table->integer('pages')->nullable()->after('description');
            $table->string('category')->nullable()->after('pages');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['description', 'pages', 'category']);
        });
    }
};