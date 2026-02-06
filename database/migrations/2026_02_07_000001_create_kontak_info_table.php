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
        Schema::create('kontak_info', function (Blueprint $table) {
            $table->id();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('google_maps_embed')->nullable(); // Embed URL Google Maps
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('twitter')->nullable(); // X (Twitter)
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak_info');
    }
};
