<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel sub_unit_usaha
     * Sub unit di bawah Unit Jasa: Transportasi, Pasar, Ketahanan Pangan
     */
    public function up(): void
    {
        Schema::create('sub_unit_usaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit_usaha')->cascadeOnDelete();
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
        Schema::dropIfExists('sub_unit_usaha');
    }
};
