<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel untuk menyimpan transaksi kas harian BUMNag (Buku Kas Harian)
     * Format: NO URUT | NO Kw | TANGGAL | URAIAN | UANG MASUK | UANG KELUAR | SALDO | KETERANGAN
     */
    public function up(): void
    {
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no_urut');              // Nomor urut dalam bulan
            $table->string('no_kwitansi', 50)->nullable();   // Nomor kwitansi/bukti
            $table->date('tanggal');                         // Tanggal transaksi
            $table->text('uraian');                          // Deskripsi/uraian transaksi
            $table->decimal('uang_masuk', 15, 2)->default(0);    // Pemasukan
            $table->decimal('uang_keluar', 15, 2)->default(0);   // Pengeluaran
            $table->decimal('saldo', 15, 2)->default(0);         // Running balance
            $table->text('keterangan')->nullable();          // Catatan tambahan
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index('tanggal');
            $table->index(['tanggal', 'no_urut']);
            $table->unique(['tanggal', 'no_urut'], 'unique_transaksi_urut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};
