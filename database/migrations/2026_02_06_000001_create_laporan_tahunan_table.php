<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel untuk menyimpan laporan tahunan BUMNag
     * Menggantikan tabel pengumuman yang sebelumnya ada
     */
    public function up(): void
    {
        // Drop tabel pengumuman jika ada
        Schema::dropIfExists('pengumuman');
        
        // Buat tabel laporan_tahunan
        Schema::create('laporan_tahunan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('file_laporan')->nullable(); // File PDF laporan tahunan
            $table->string('file_original_name')->nullable(); // Nama file asli
            $table->unsignedBigInteger('file_size')->default(0); // Ukuran file dalam bytes
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedInteger('download_count')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_publikasi')->nullable();
            
            // SEO Meta Tags
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 160)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index untuk performa
            $table->index(['status', 'tahun']);
            $table->index('download_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tahunan');
        
        // Recreate pengumuman table if needed
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('konten');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->string('lampiran')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
