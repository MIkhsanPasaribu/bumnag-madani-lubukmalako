<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan kategori_id ke tabel transaksi_kas
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_kas', function (Blueprint $table) {
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->after('keterangan')
                  ->constrained('kategori_transaksi')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_kas', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
