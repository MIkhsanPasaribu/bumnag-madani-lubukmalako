<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan error/exception logs dari aplikasi.
     * Digunakan untuk debugging di production tanpa akses server.
     */
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('level', 20)->index();                    // error, critical, emergency, warning
            $table->text('message');                                   // Pesan error utama
            $table->string('exception_class', 255)->nullable();       // Nama class exception
            $table->string('file', 500)->nullable();                  // File tempat error terjadi
            $table->unsignedInteger('line')->nullable();              // Baris error
            $table->longText('stack_trace')->nullable();              // Stack trace (disanitasi)
            $table->string('url', 2048)->nullable();                  // URL yang dikunjungi
            $table->string('method', 10)->nullable();                 // HTTP method (GET/POST/etc)
            $table->string('ip_address', 45)->nullable();             // IP pengunjung
            $table->string('user_agent', 500)->nullable();            // Browser info
            $table->foreignId('user_id')->nullable()                  // User yang sedang login
                  ->constrained('users')->nullOnDelete();
            $table->json('request_data')->nullable();                 // Sanitized request parameters
            $table->json('additional_context')->nullable();           // Konteks tambahan
            $table->boolean('is_read')->default(false)->index();      // Untuk badge counter
            $table->timestamps();

            // Index untuk query yang sering digunakan
            $table->index('created_at');
            $table->index('exception_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
