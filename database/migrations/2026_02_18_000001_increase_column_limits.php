<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk memperbesar batas kolom yang terlalu kecil
 * 
 * Perubahan:
 * - hero_slides.teks_tombol: VARCHAR(100) → VARCHAR(255) 
 * - kategori_berita.nama: VARCHAR(100) → VARCHAR(200)
 * - kategori_berita.slug: VARCHAR(100) → VARCHAR(220)
 * - profil_bumnag.telepon: VARCHAR(20) → VARCHAR(50)
 * - kontak_info.alamat: VARCHAR(255) → TEXT
 * - kontak_info.google_maps_embed: VARCHAR(255) → TEXT
 * - berita.link_url: VARCHAR(255) → TEXT
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('teks_tombol', 255)->nullable()->change();
        });

        Schema::table('kategori_berita', function (Blueprint $table) {
            $table->string('nama', 200)->change();
            $table->string('slug', 220)->change();
        });

        Schema::table('profil_bumnag', function (Blueprint $table) {
            $table->string('telepon', 50)->nullable()->change();
        });

        Schema::table('kontak_info', function (Blueprint $table) {
            $table->text('alamat')->nullable()->change();
            $table->text('google_maps_embed')->nullable()->change();
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->text('link_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('teks_tombol', 100)->nullable()->change();
        });

        Schema::table('kategori_berita', function (Blueprint $table) {
            $table->string('nama', 100)->change();
            $table->string('slug', 100)->change();
        });

        Schema::table('profil_bumnag', function (Blueprint $table) {
            $table->string('telepon', 20)->nullable()->change();
        });

        Schema::table('kontak_info', function (Blueprint $table) {
            $table->string('alamat', 255)->nullable()->change();
            $table->string('google_maps_embed', 255)->nullable()->change();
        });

        Schema::table('berita', function (Blueprint $table) {
            $table->string('link_url', 255)->nullable()->change();
        });
    }
};
