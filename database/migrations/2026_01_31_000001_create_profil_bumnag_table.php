<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel untuk menyimpan profil BUMNag Madani Lubuk Malako
     */
    public function up(): void
    {
        Schema::create('profil_bumnag', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bumnag');
            $table->string('nama_nagari');
            $table->text('alamat');
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->json('struktur_organisasi')->nullable(); // Array of {jabatan, nama, foto}
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_bumnag');
    }
};
