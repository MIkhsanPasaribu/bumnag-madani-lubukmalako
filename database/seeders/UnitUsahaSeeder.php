<?php

namespace Database\Seeders;

use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk Unit Usaha dan Sub Unit Usaha
 */
class UnitUsahaSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // Unit Jasa (memiliki 3 sub unit)
        // =====================================================================
        $unitJasa = UnitUsaha::updateOrCreate(
            ['kode' => 'jasa'],
            [
                'nama' => 'Unit Jasa',
                'deskripsi' => 'Unit usaha yang bergerak di bidang jasa meliputi transportasi, pengelolaan pasar, dan ketahanan pangan.',
                'is_active' => true,
                'urutan' => 1,
            ]
        );

        // Sub Unit: Transportasi
        SubUnitUsaha::updateOrCreate(
            ['kode' => 'transportasi'],
            [
                'unit_id' => $unitJasa->id,
                'nama' => 'Transportasi',
                'deskripsi' => 'Layanan transportasi nagari.',
                'is_active' => true,
                'urutan' => 1,
            ]
        );

        // Sub Unit: Pasar
        SubUnitUsaha::updateOrCreate(
            ['kode' => 'pasar'],
            [
                'unit_id' => $unitJasa->id,
                'nama' => 'Pasar',
                'deskripsi' => 'Pengelolaan pasar nagari.',
                'is_active' => true,
                'urutan' => 2,
            ]
        );

        // Sub Unit: Ketahanan Pangan
        SubUnitUsaha::updateOrCreate(
            ['kode' => 'ketahanan-pangan'],
            [
                'unit_id' => $unitJasa->id,
                'nama' => 'Ketahanan Pangan',
                'deskripsi' => 'Program ketahanan pangan nagari.',
                'is_active' => true,
                'urutan' => 3,
            ]
        );

        // =====================================================================
        // Unit Perkebunan (tanpa sub unit)
        // =====================================================================
        UnitUsaha::updateOrCreate(
            ['kode' => 'perkebunan'],
            [
                'nama' => 'Unit Perkebunan',
                'deskripsi' => 'Unit usaha yang bergerak di bidang perkebunan nagari.',
                'is_active' => true,
                'urutan' => 2,
            ]
        );
    }
}
