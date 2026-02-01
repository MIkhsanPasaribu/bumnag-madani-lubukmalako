<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel kategori_transaksi
 * Menyimpan kategori untuk mengelompokkan transaksi kas
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('warna', 7)->default('#86ae5f');
            $table->string('ikon', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index untuk query optimization
            $table->index('jenis');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_transaksi');
    }
};
