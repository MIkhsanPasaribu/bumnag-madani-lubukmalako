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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('subjudul')->nullable();
            $table->enum('tipe_media', ['gambar', 'video'])->default('gambar');
            $table->string('media_path', 255);
            $table->string('url_tombol', 255)->nullable();
            $table->string('teks_tombol', 100)->nullable();
            $table->integer('urutan')->default(0);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
