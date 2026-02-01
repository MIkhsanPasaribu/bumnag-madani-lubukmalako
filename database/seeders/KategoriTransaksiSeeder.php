<?php

namespace Database\Seeders;

use App\Models\KategoriTransaksi;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk kategori transaksi default
 */
class KategoriTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            // Kategori Pemasukan
            [
                'nama' => 'Penjualan',
                'jenis' => 'masuk',
                'warna' => '#22c55e',
                'ikon' => 'shopping-cart',
                'deskripsi' => 'Pendapatan dari penjualan produk atau barang dagangan',
            ],
            [
                'nama' => 'Jasa',
                'jenis' => 'masuk',
                'warna' => '#3b82f6',
                'ikon' => 'briefcase',
                'deskripsi' => 'Pendapatan dari penyediaan jasa atau layanan',
            ],
            [
                'nama' => 'Hibah',
                'jenis' => 'masuk',
                'warna' => '#8b5cf6',
                'ikon' => 'gift',
                'deskripsi' => 'Pendapatan dari bantuan atau hibah pemerintah/pihak ketiga',
            ],
            [
                'nama' => 'Investasi',
                'jenis' => 'masuk',
                'warna' => '#f59e0b',
                'ikon' => 'trending-up',
                'deskripsi' => 'Pendapatan dari hasil investasi atau bunga bank',
            ],
            [
                'nama' => 'Modal Awal',
                'jenis' => 'masuk',
                'warna' => '#06b6d4',
                'ikon' => 'database',
                'deskripsi' => 'Modal awal atau setoran modal pemilik',
            ],
            [
                'nama' => 'Pendapatan Lainnya',
                'jenis' => 'masuk',
                'warna' => '#64748b',
                'ikon' => 'plus-circle',
                'deskripsi' => 'Pendapatan lain yang tidak termasuk kategori di atas',
            ],
            
            // Kategori Pengeluaran
            [
                'nama' => 'Operasional',
                'jenis' => 'keluar',
                'warna' => '#ef4444',
                'ikon' => 'settings',
                'deskripsi' => 'Biaya operasional harian (ATK, listrik, air, dll)',
            ],
            [
                'nama' => 'Gaji & Honor',
                'jenis' => 'keluar',
                'warna' => '#f97316',
                'ikon' => 'users',
                'deskripsi' => 'Pembayaran gaji, honor, atau upah pegawai',
            ],
            [
                'nama' => 'Bahan Baku',
                'jenis' => 'keluar',
                'warna' => '#a855f7',
                'ikon' => 'package',
                'deskripsi' => 'Pembelian bahan baku atau bahan produksi',
            ],
            [
                'nama' => 'Transportasi',
                'jenis' => 'keluar',
                'warna' => '#ec4899',
                'ikon' => 'truck',
                'deskripsi' => 'Biaya transportasi, BBM, dan perjalanan dinas',
            ],
            [
                'nama' => 'Perawatan',
                'jenis' => 'keluar',
                'warna' => '#14b8a6',
                'ikon' => 'tool',
                'deskripsi' => 'Biaya perawatan dan perbaikan aset',
            ],
            [
                'nama' => 'Investasi Aset',
                'jenis' => 'keluar',
                'warna' => '#6366f1',
                'ikon' => 'shopping-bag',
                'deskripsi' => 'Pembelian aset tetap atau investasi jangka panjang',
            ],
            [
                'nama' => 'Pengeluaran Lainnya',
                'jenis' => 'keluar',
                'warna' => '#78716c',
                'ikon' => 'minus-circle',
                'deskripsi' => 'Pengeluaran lain yang tidak termasuk kategori di atas',
            ],
        ];

        foreach ($kategori as $data) {
            KategoriTransaksi::firstOrCreate(
                ['nama' => $data['nama'], 'jenis' => $data['jenis']],
                $data
            );
        }
    }
}
