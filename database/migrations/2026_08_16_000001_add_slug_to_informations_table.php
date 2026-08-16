<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informations', function (Blueprint $table) {
            if (!Schema::hasColumn('informations', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
        });

        $rows = DB::table('informations')->whereNull('slug')->orWhere('slug', '')->get();

        foreach ($rows as $row) {
            $base = Str::slug($row->title ?? 'informasi');
            $slug = $base ?: 'informasi';
            $counter = 1;

            while (DB::table('informations')->where('slug', $slug)->where('id', '!=', $row->id)->exists()) {
                $slug = "{$base}-{$counter}";
                $counter++;
            }

            DB::table('informations')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('informations', function (Blueprint $table) {
            if (Schema::hasColumn('informations', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
        });
    }
};
