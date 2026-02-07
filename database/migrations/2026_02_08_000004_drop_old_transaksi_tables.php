<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghapus tabel transaksi_kas dan kategori_transaksi
     * yang sudah digantikan oleh sistem laporan keuangan baru
     */
    public function up(): void
    {
        // Hapus tabel transaksi_kas (yang memiliki FK ke kategori_transaksi)
        Schema::dropIfExists('transaksi_kas');

        // Hapus tabel kategori_transaksi
        Schema::dropIfExists('kategori_transaksi');
    }

    public function down(): void
    {
        // Recreate kategori_transaksi
        Schema::create('kategori_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('warna', 7)->default('#6b7280');
            $table->string('ikon', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Recreate transaksi_kas
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut');
            $table->string('no_kwitansi', 50)->nullable();
            $table->date('tanggal');
            $table->text('uraian');
            $table->decimal('uang_masuk', 15, 2)->default(0);
            $table->decimal('uang_keluar', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_transaksi')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
};
