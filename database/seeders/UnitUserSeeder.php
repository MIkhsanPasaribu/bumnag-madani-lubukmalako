<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk membuat akun login Unit Usaha dan Sub Unit Usaha
 */
class UnitUserSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // Akun Unit Jasa
        // =====================================================================
        $unitJasa = UnitUsaha::where('kode', 'jasa')->first();

        if ($unitJasa) {
            User::updateOrCreate(
                ['email' => 'jasa@bumnagmadani.id'],
                [
                    'name' => 'Unit Jasa',
                    'password' => bcrypt('unitjasa123'),
                    'role' => 'unit',
                    'unit_id' => $unitJasa->id,
                    'sub_unit_id' => null,
                ]
            );

            // Akun Sub Unit: Transportasi
            $subTransportasi = SubUnitUsaha::where('kode', 'transportasi')->first();
            if ($subTransportasi) {
                User::updateOrCreate(
                    ['email' => 'transportasi@bumnagmadani.id'],
                    [
                        'name' => 'Sub Unit Transportasi',
                        'password' => bcrypt('transportasi123'),
                        'role' => 'sub_unit',
                        'unit_id' => $unitJasa->id,
                        'sub_unit_id' => $subTransportasi->id,
                    ]
                );
            }

            // Akun Sub Unit: Pasar
            $subPasar = SubUnitUsaha::where('kode', 'pasar')->first();
            if ($subPasar) {
                User::updateOrCreate(
                    ['email' => 'pasar@bumnagmadani.id'],
                    [
                        'name' => 'Sub Unit Pasar',
                        'password' => bcrypt('pasar123'),
                        'role' => 'sub_unit',
                        'unit_id' => $unitJasa->id,
                        'sub_unit_id' => $subPasar->id,
                    ]
                );
            }

            // Akun Sub Unit: Ketahanan Pangan
            $subKetahananPangan = SubUnitUsaha::where('kode', 'ketahanan-pangan')->first();
            if ($subKetahananPangan) {
                User::updateOrCreate(
                    ['email' => 'ketahananpangan@bumnagmadani.id'],
                    [
                        'name' => 'Sub Unit Ketahanan Pangan',
                        'password' => bcrypt('ketahananpangan123'),
                        'role' => 'sub_unit',
                        'unit_id' => $unitJasa->id,
                        'sub_unit_id' => $subKetahananPangan->id,
                    ]
                );
            }
        }

        // =====================================================================
        // Akun Unit Perkebunan (tanpa sub unit)
        // =====================================================================
        $unitPerkebunan = UnitUsaha::where('kode', 'perkebunan')->first();

        if ($unitPerkebunan) {
            User::updateOrCreate(
                ['email' => 'perkebunan@bumnagmadani.id'],
                [
                    'name' => 'Unit Perkebunan',
                    'password' => bcrypt('perkebunan123'),
                    'role' => 'unit',
                    'unit_id' => $unitPerkebunan->id,
                    'sub_unit_id' => null,
                ]
            );
        }
    }
}
