<?php

namespace Database\Seeders;

use App\Models\TransaksiKas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk sample transaksi kas harian BUMNag
 */
class TransaksiKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $admin = User::first();
        }
        
        // Data transaksi sample untuk Januari 2026
        $transaksiJanuari = [
            ['tanggal' => '2026-01-02', 'no_kwitansi' => 'KW-001', 'uraian' => 'Saldo awal tahun 2026', 'masuk' => 50000000, 'keluar' => 0, 'keterangan' => 'Saldo dari tahun sebelumnya'],
            ['tanggal' => '2026-01-03', 'no_kwitansi' => 'KW-002', 'uraian' => 'Penjualan hasil panen sawit', 'masuk' => 15000000, 'keluar' => 0, 'keterangan' => 'Hasil panen minggu pertama'],
            ['tanggal' => '2026-01-05', 'no_kwitansi' => 'KW-003', 'uraian' => 'Pembelian pupuk NPK', 'masuk' => 0, 'keluar' => 3500000, 'keterangan' => 'Untuk kebun blok A'],
            ['tanggal' => '2026-01-07', 'no_kwitansi' => 'KW-004', 'uraian' => 'Pembayaran gaji karyawan', 'masuk' => 0, 'keluar' => 8000000, 'keterangan' => 'Gaji 8 karyawan'],
            ['tanggal' => '2026-01-10', 'no_kwitansi' => 'KW-005', 'uraian' => 'Penjualan hasil panen sawit', 'masuk' => 12000000, 'keluar' => 0, 'keterangan' => 'Hasil panen minggu kedua'],
            ['tanggal' => '2026-01-12', 'no_kwitansi' => 'KW-006', 'uraian' => 'Pembelian solar untuk traktor', 'masuk' => 0, 'keluar' => 1500000, 'keterangan' => '300 liter solar'],
            ['tanggal' => '2026-01-15', 'no_kwitansi' => 'KW-007', 'uraian' => 'Pembayaran listrik kantor', 'masuk' => 0, 'keluar' => 750000, 'keterangan' => 'Tagihan listrik Januari'],
            ['tanggal' => '2026-01-17', 'no_kwitansi' => 'KW-008', 'uraian' => 'Penjualan hasil panen sawit', 'masuk' => 18000000, 'keluar' => 0, 'keterangan' => 'Hasil panen minggu ketiga'],
            ['tanggal' => '2026-01-18', 'no_kwitansi' => 'KW-009', 'uraian' => 'Perbaikan alat semprot', 'masuk' => 0, 'keluar' => 500000, 'keterangan' => 'Service sprayer'],
            ['tanggal' => '2026-01-20', 'no_kwitansi' => 'KW-010', 'uraian' => 'Pendapatan sewa kendaraan', 'masuk' => 2000000, 'keluar' => 0, 'keterangan' => 'Sewa pickup 4 hari'],
            ['tanggal' => '2026-01-22', 'no_kwitansi' => 'KW-011', 'uraian' => 'Pembelian herbisida', 'masuk' => 0, 'keluar' => 2000000, 'keterangan' => 'Untuk pengendalian gulma'],
            ['tanggal' => '2026-01-24', 'no_kwitansi' => 'KW-012', 'uraian' => 'Penjualan hasil panen sawit', 'masuk' => 16000000, 'keluar' => 0, 'keterangan' => 'Hasil panen minggu keempat'],
            ['tanggal' => '2026-01-25', 'no_kwitansi' => 'KW-013', 'uraian' => 'Biaya transportasi hasil', 'masuk' => 0, 'keluar' => 1200000, 'keterangan' => 'Ongkos angkut ke PKS'],
            ['tanggal' => '2026-01-27', 'no_kwitansi' => 'KW-014', 'uraian' => 'Pembelian alat tulis kantor', 'masuk' => 0, 'keluar' => 350000, 'keterangan' => 'ATK bulanan'],
            ['tanggal' => '2026-01-28', 'no_kwitansi' => 'KW-015', 'uraian' => 'Pendapatan jasa penggilingan', 'masuk' => 1500000, 'keluar' => 0, 'keterangan' => 'Jasa unit usaha'],
            ['tanggal' => '2026-01-30', 'no_kwitansi' => 'KW-016', 'uraian' => 'Pembayaran BPJS karyawan', 'masuk' => 0, 'keluar' => 1000000, 'keterangan' => 'Iuran BPJS Januari'],
            ['tanggal' => '2026-01-31', 'no_kwitansi' => 'KW-017', 'uraian' => 'Biaya rapat koordinasi', 'masuk' => 0, 'keluar' => 500000, 'keterangan' => 'Konsumsi dan akomodasi'],
        ];
        
        $saldo = 0;
        $noUrutHarian = [];
        
        foreach ($transaksiJanuari as $data) {
            $tanggal = $data['tanggal'];
            
            // Track no urut per tanggal
            if (!isset($noUrutHarian[$tanggal])) {
                $noUrutHarian[$tanggal] = 1;
            } else {
                $noUrutHarian[$tanggal]++;
            }
            
            $saldo = $saldo + $data['masuk'] - $data['keluar'];
            
            TransaksiKas::create([
                'no_urut' => $noUrutHarian[$tanggal],
                'no_kwitansi' => $data['no_kwitansi'],
                'tanggal' => $data['tanggal'],
                'uraian' => $data['uraian'],
                'uang_masuk' => $data['masuk'],
                'uang_keluar' => $data['keluar'],
                'saldo' => $saldo,
                'keterangan' => $data['keterangan'],
                'created_by' => $admin->id,
            ]);
        }
    }
}
