<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'tasks' dengan relasi ke Users dan Priorities.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Foreign Key: user_id (Relasi ke tabel users, tugas dimiliki oleh user ini)
            // Jika user dihapus, semua tugasnya ikut terhapus (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Foreign Key: priority_id (Relasi ke tabel priorities)
            // Jika prioritas dihapus, kolom ini di-set menjadi NULL (set null)
            $table->foreignId('priority_id')->nullable()->constrained()->onDelete('set null'); 

            // Detail Tugas
            $table->string('title');
            $table->text('notes')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->boolean('is_completed')->default(false); // Status penyelesaian

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus tabel 'tasks'.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};