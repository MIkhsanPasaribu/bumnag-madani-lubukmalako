<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel laporan_keuangan
     * Menggantikan tabel transaksi_kas (buku kas harian) 
     * Mencatat pendapatan & pengeluaran per unit/sub-unit per bulan
     */
    public function up(): void
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_usaha')->cascadeOnDelete();
            $table->foreignId('sub_unit_id')->nullable()->constrained('sub_unit_usaha')->nullOnDelete();
            $table->unsignedTinyInteger('bulan'); // 1-12
            $table->unsignedSmallInteger('tahun');
            $table->decimal('pendapatan', 15, 2)->default(0);
            $table->decimal('pengeluaran', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Unique: satu record per unit/sub-unit per bulan/tahun
            // Untuk sub_unit_id NULL (unit tanpa sub-unit), validasi di level aplikasi
            $table->index(['unit_id', 'sub_unit_id', 'bulan', 'tahun'], 'idx_laporan_periode');
            $table->index(['bulan', 'tahun'], 'idx_laporan_bulan_tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};
