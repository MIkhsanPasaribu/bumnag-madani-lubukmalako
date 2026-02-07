<?php

namespace Database\Seeders;

use App\Models\LaporanKeuangan;
use App\Models\UnitUsaha;
use App\Models\SubUnitUsaha;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder data contoh Laporan Keuangan
 */
class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin?->id;

        $unitJasa = UnitUsaha::where('kode', 'jasa')->first();
        $unitPerkebunan = UnitUsaha::where('kode', 'perkebunan')->first();

        if (!$unitJasa || !$unitPerkebunan) {
            $this->command->warn('Unit usaha belum tersedia. Jalankan UnitUsahaSeeder terlebih dahulu.');
            return;
        }

        $transportasi = SubUnitUsaha::where('kode', 'transportasi')->first();
        $pasar = SubUnitUsaha::where('kode', 'pasar')->first();
        $ketahananPangan = SubUnitUsaha::where('kode', 'ketahanan-pangan')->first();

        // Data contoh untuk 6 bulan (Januari - Juni 2026)
        $dataSample = [
            // Bulan 1: Januari
            ['bulan' => 1, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 8500000, 'pengeluaran' => 3200000, 'ket' => 'Pendapatan dari rute angkutan nagari'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 12000000, 'pengeluaran' => 4500000, 'ket' => 'Retribusi pasar dan sewa kios'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 6000000, 'pengeluaran' => 5000000, 'ket' => 'Distribusi beras dan kebutuhan pokok'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 15000000, 'pengeluaran' => 7500000, 'ket' => 'Penjualan hasil kebun karet dan sawit'],
            ]],
            // Bulan 2: Februari
            ['bulan' => 2, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 9200000, 'pengeluaran' => 3500000, 'ket' => 'Kenaikan volume penumpang'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 11500000, 'pengeluaran' => 4200000, 'ket' => 'Retribusi pasar bulan Februari'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 5500000, 'pengeluaran' => 4800000, 'ket' => 'Distribusi bulan Februari'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 14000000, 'pengeluaran' => 6800000, 'ket' => 'Penjualan karet dan aktivitas perkebunan'],
            ]],
            // Bulan 3: Maret
            ['bulan' => 3, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 8800000, 'pengeluaran' => 4000000, 'ket' => 'Biaya perawatan kendaraan'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 13000000, 'pengeluaran' => 5000000, 'ket' => 'Renovasi kios pasar'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 7000000, 'pengeluaran' => 5500000, 'ket' => 'Program distribusi pangan'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 16500000, 'pengeluaran' => 8000000, 'ket' => 'Panen raya sawit bulan Maret'],
            ]],
            // Bulan 4: April
            ['bulan' => 4, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 9500000, 'pengeluaran' => 3800000, 'ket' => 'Kedatangan musim wisata'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 12500000, 'pengeluaran' => 4700000, 'ket' => 'Perkembangan usaha pasar'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 6500000, 'pengeluaran' => 5200000, 'ket' => 'Distribusi dan stok cadangan'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 13500000, 'pengeluaran' => 7000000, 'ket' => 'Hasil perkebunan bulan April'],
            ]],
            // Bulan 5: Mei
            ['bulan' => 5, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 10000000, 'pengeluaran' => 4200000, 'ket' => 'Rute baru beroperasi'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 14000000, 'pengeluaran' => 5500000, 'ket' => 'Peningkatan pedagang pasar'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 7500000, 'pengeluaran' => 6000000, 'ket' => 'Program pangan bersubsidi'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 17000000, 'pengeluaran' => 8500000, 'ket' => 'Penjualan hasil sawit dan karet'],
            ]],
            // Bulan 6: Juni
            ['bulan' => 6, 'tahun' => 2026, 'data' => [
                ['unit' => $unitJasa, 'sub' => $transportasi, 'pendapatan' => 9800000, 'pengeluaran' => 3900000, 'ket' => 'Arus mudik lebaran'],
                ['unit' => $unitJasa, 'sub' => $pasar, 'pendapatan' => 15000000, 'pengeluaran' => 6000000, 'ket' => 'Peningkatan jelang lebaran'],
                ['unit' => $unitJasa, 'sub' => $ketahananPangan, 'pendapatan' => 8000000, 'pengeluaran' => 6500000, 'ket' => 'Distribusi kebutuhan lebaran'],
                ['unit' => $unitPerkebunan, 'sub' => null, 'pendapatan' => 14500000, 'pengeluaran' => 7200000, 'ket' => 'Hasil perkebunan bulan Juni'],
            ]],
        ];

        foreach ($dataSample as $periode) {
            foreach ($periode['data'] as $item) {
                LaporanKeuangan::updateOrCreate(
                    [
                        'unit_id' => $item['unit']->id,
                        'sub_unit_id' => $item['sub']?->id,
                        'bulan' => $periode['bulan'],
                        'tahun' => $periode['tahun'],
                    ],
                    [
                        'pendapatan' => $item['pendapatan'],
                        'pengeluaran' => $item['pengeluaran'],
                        'keterangan' => $item['ket'],
                        'created_by' => $adminId,
                    ]
                );
            }
        }

        $this->command->info('Laporan keuangan sample berhasil di-seed (6 bulan × 4 entry = 24 record).');
    }
}
