<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan field tanggal_kegiatan pada tabel berita
 * 
 * Field ini digunakan untuk mencatat tanggal kegiatan/peristiwa yang diberitakan,
 * berbeda dengan tanggal_publikasi yang merupakan tanggal berita dipublikasikan.
 * 
 * Contoh penggunaan:
 * - Kegiatan rapat tanggal 1 Januari (tanggal_kegiatan)
 * - Berita ditulis dan dipublikasikan tanggal 5 Januari (tanggal_publikasi)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Tanggal kegiatan/peristiwa yang diberitakan
            $table->date('tanggal_kegiatan')->nullable()->after('tanggal_publikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn('tanggal_kegiatan');
        });
    }
};
