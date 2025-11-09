<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'priorities' untuk kategori prioritas.
     */
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            
            // Kolom WAJIB: Nama prioritas (misalnya: High, Low)
            $table->string('name')->unique(); 
            
            // Kolom Opsional: Kode warna untuk tampilan di UI
            $table->string('color_code')->default('#cccccc'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel 'priorities'.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};