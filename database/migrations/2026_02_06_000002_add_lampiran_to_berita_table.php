<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan field lampiran ke tabel berita
     * Untuk upload file dokumen (PDF, DOC, DOCX) sebagai lampiran berita
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->string('lampiran')->nullable()->after('gambar');
            $table->string('lampiran_original_name')->nullable()->after('lampiran');
            $table->unsignedBigInteger('lampiran_size')->default(0)->after('lampiran_original_name');
            
            // Link eksternal untuk sumber/referensi
            $table->string('link_url')->nullable()->after('lampiran_size');
            $table->string('link_text')->nullable()->after('link_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn(['lampiran', 'lampiran_original_name', 'lampiran_size', 'link_url', 'link_text']);
        });
    }
};
