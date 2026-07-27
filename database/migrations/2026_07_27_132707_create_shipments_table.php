<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('resi_number')->unique(); // Contoh: BCD-2026-00123
            $table->foreignId('user_id');
            $table->string('book_title');
            
            // Status Produksi & Buku
            $table->enum('production_status', [
                'naskah_diterima', 
                'layout_cover', 
                'proses_haki', 
                'proses_cetak', 
                'selesai_cetak'
            ])->default('naskah_diterima');

            // Opsi Pengambilan
            $table->enum('delivery_type', ['pickup', 'delivery']);
            
            // Status Pengiriman (Jika pilih delivery)
            $table->string('delivery_status')->default('Menunggu Pengiriman');
            
            // Koordinat Driver untuk Live Tracking (Mirip GoSend)
            $table->decimal('driver_lat', 10, 8)->nullable();
            $table->decimal('driver_lng', 11, 8)->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};