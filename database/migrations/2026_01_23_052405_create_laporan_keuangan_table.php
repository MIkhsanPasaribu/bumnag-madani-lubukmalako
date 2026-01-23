<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->year('tahun');
            $table->enum('bulan', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])->nullable();
            $table->decimal('pendapatan', 15, 2)->default(0);
            $table->decimal('pengeluaran', 15, 2)->default(0);
            $table->decimal('laba_rugi', 15, 2)->default(0);
            $table->decimal('aset', 15, 2)->default(0);
            $table->decimal('kewajiban', 15, 2)->default(0);
            $table->decimal('modal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};
