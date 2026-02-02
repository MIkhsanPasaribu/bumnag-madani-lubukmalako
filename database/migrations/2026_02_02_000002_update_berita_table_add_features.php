<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan fitur baru ke tabel berita:
     * - Kategori berita
     * - SEO meta tags
     * - Featured/Pinned
     * - Scheduled publishing
     * - Soft delete
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Kategori
            $table->foreignId('kategori_id')->nullable()->after('penulis_id')
                  ->constrained('kategori_berita')->nullOnDelete();
            
            // Featured/Pinned - untuk menampilkan di atas
            $table->boolean('is_featured')->default(false)->after('views');
            $table->boolean('is_pinned')->default(false)->after('is_featured');
            
            // SEO Meta Tags
            $table->string('meta_title', 70)->nullable()->after('is_pinned');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
            $table->string('meta_keywords', 255)->nullable()->after('meta_description');
            
            // Scheduled Publishing - ubah tanggal_publikasi menjadi schedulable
            // tanggal_publikasi sudah ada, kita tambah field untuk track scheduling
            $table->boolean('is_scheduled')->default(false)->after('meta_keywords');
            
            // Soft Delete
            $table->softDeletes();
            
            // Index untuk performa
            $table->index(['status', 'tanggal_publikasi', 'is_featured']);
            $table->index('is_pinned');
            $table->index('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['status', 'tanggal_publikasi', 'is_featured']);
            $table->dropIndex(['is_pinned']);
            $table->dropIndex(['kategori_id']);
            
            // Drop foreign key and columns
            $table->dropForeign(['kategori_id']);
            $table->dropColumn([
                'kategori_id',
                'is_featured',
                'is_pinned',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'is_scheduled',
                'deleted_at'
            ]);
        });
    }
};
