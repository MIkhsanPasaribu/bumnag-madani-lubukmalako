<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Menambahkan role unit/sub_unit ke tabel users
 * dan relasi ke unit_usaha/sub_unit_usaha
 */
return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum role: tambah 'unit' dan 'sub_unit'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin','admin','unit','sub_unit') DEFAULT 'admin'");

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('role')
                  ->constrained('unit_usaha')->nullOnDelete();
            $table->foreignId('sub_unit_id')->nullable()->after('unit_id')
                  ->constrained('sub_unit_usaha')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['sub_unit_id']);
            $table->dropColumn(['unit_id', 'sub_unit_id']);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','super_admin') DEFAULT 'admin'");
    }
};
