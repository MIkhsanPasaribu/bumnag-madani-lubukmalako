<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan fitur baru ke tabel pengumuman:
     * - View count
     * - Featured/Pinned
     * - SEO meta tags
     * - Soft delete
     */
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // View count - sama seperti berita
            $table->unsignedInteger('views')->default(0)->after('status');
            
            // Featured/Pinned - untuk menampilkan di atas
            $table->boolean('is_featured')->default(false)->after('views');
            $table->boolean('is_pinned')->default(false)->after('is_featured');
            
            // SEO Meta Tags
            $table->string('meta_title', 70)->nullable()->after('is_pinned');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
            $table->string('meta_keywords', 255)->nullable()->after('meta_description');
            
            // Soft Delete
            $table->softDeletes();
            
            // Index untuk performa
            $table->index(['status', 'tanggal_mulai', 'is_featured']);
            $table->index('is_pinned');
            $table->index('views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['status', 'tanggal_mulai', 'is_featured']);
            $table->dropIndex(['is_pinned']);
            $table->dropIndex(['views']);
            
            // Drop columns
            $table->dropColumn([
                'views',
                'is_featured',
                'is_pinned',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'deleted_at'
            ]);
        });
    }
};
