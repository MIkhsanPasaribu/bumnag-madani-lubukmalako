<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel unit_usaha
     * Unit usaha BUMNag: Unit Jasa, Unit Perkebunan
     */
    public function up(): void
    {
        Schema::create('unit_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode', 50)->unique();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_usaha');
    }
};
