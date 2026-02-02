<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel untuk menyimpan multiple gambar per berita (gallery)
     */
    public function up(): void
    {
        Schema::create('gambar_berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('berita')->cascadeOnDelete();
            $table->string('file_name'); // Nama file di storage
            $table->string('original_name'); // Nama file asli
            $table->string('caption', 255)->nullable(); // Caption gambar
            $table->string('alt_text', 255)->nullable(); // Alt text untuk SEO
            $table->unsignedInteger('file_size')->default(0); // Ukuran file dalam bytes
            $table->string('mime_type', 50)->nullable();
            $table->integer('urutan')->default(0); // Urutan tampil di gallery
            $table->boolean('is_cover')->default(false); // Apakah sebagai gambar utama
            $table->timestamps();
            
            // Index
            $table->index(['berita_id', 'urutan']);
            $table->index('is_cover');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_berita');
    }
};
