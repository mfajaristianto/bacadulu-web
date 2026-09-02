<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('books', 'print_stock')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedInteger('print_stock')
                    ->default(0)
                    ->after('print_price');
            });
        }

        if (! Schema::hasTable('book_stock_movements')) {
            Schema::create('book_stock_movements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('book_id')
                    ->constrained('books')
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->string('type', 30);
                $table->integer('quantity_change');
                $table->unsignedInteger('stock_before');
                $table->unsignedInteger('stock_after');
                $table->string('note', 500)->nullable();
                $table->timestamps();

                $table->index(['book_id', 'created_at']);
                $table->index('type');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('book_stock_movements');

        if (Schema::hasColumn('books', 'print_stock')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('print_stock');
            });
        }
    }
};
