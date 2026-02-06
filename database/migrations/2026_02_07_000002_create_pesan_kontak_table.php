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
        Schema::create('pesan_kontak', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('organisasi')->nullable();
            $table->string('email');
            $table->string('subjek');
            $table->text('pesan');
            $table->enum('status', ['belum_dibaca', 'dibaca', 'dibalas'])->default('belum_dibaca');
            $table->text('balasan')->nullable();
            $table->timestamp('dibaca_at')->nullable();
            $table->timestamp('dibalas_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_kontak');
    }
};
