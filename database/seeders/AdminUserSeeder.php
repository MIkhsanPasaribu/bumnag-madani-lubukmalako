<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk membuat admin default BUMNag
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin utama BUMNag
        User::create([
            'name' => 'Admin BUMNag',
            'email' => 'admin@bumnagmadani.id',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
            'security_question' => 'ibu',
            'security_answer' => Hash::make('bumnag'), // Jawaban: bumnag
        ]);

        // Admin tambahan
        User::create([
            'name' => 'Operator BUMNag',
            'email' => 'operator@bumnagmadani.id',
            'password' => Hash::make('operator123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'security_question' => 'sekolah',
            'security_answer' => Hash::make('bumnag'), // Jawaban: bumnag
        ]);
    }
}
