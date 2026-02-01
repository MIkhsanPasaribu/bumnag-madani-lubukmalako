<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model KategoriTransaksi untuk mengelompokkan transaksi kas
 */
class KategoriTransaksi extends Model
{
    use HasFactory;

    protected $table = 'kategori_transaksi';

    protected $fillable = [
        'nama',
        'jenis',
        'warna',
        'ikon',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Relasi: Kategori memiliki banyak transaksi
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiKas::class, 'kategori_id');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope: Filter kategori pemasukan
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis', 'masuk');
    }

    /**
     * Scope: Filter kategori pengeluaran
     */
    public function scopeKeluar($query)
    {
        return $query->where('jenis', 'keluar');
    }

    /**
     * Scope: Filter kategori aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // =========================================================================
    // STATIC METHODS
    // =========================================================================

    /**
     * Get kategori untuk dropdown berdasarkan jenis
     */
    public static function getDropdown(string $jenis = null): array
    {
        $query = self::aktif()->orderBy('nama');
        
        if ($jenis) {
            $query->where('jenis', $jenis);
        }
        
        return $query->pluck('nama', 'id')->toArray();
    }

    /**
     * Get statistik transaksi per kategori untuk periode tertentu
     */
    public static function getStatistikKategori(int $bulan = null, int $tahun = null): array
    {
        $query = self::with(['transaksi' => function ($q) use ($bulan, $tahun) {
            if ($bulan && $tahun) {
                $q->bulan($bulan, $tahun);
            } elseif ($tahun) {
                $q->tahun($tahun);
            }
        }])->aktif();

        $kategori = $query->get();
        
        $hasil = [];
        foreach ($kategori as $kat) {
            $totalMasuk = $kat->transaksi->sum('uang_masuk');
            $totalKeluar = $kat->transaksi->sum('uang_keluar');
            $total = $kat->jenis === 'masuk' ? $totalMasuk : $totalKeluar;
            
            if ($total > 0) {
                $hasil[] = [
                    'id' => $kat->id,
                    'nama' => $kat->nama,
                    'jenis' => $kat->jenis,
                    'warna' => $kat->warna,
                    'total' => $total,
                    'jumlah_transaksi' => $kat->transaksi->count(),
                ];
            }
        }
        
        return $hasil;
    }

    /**
     * Get breakdown pengeluaran per kategori
     */
    public static function getBreakdownPengeluaran(int $tahun): array
    {
        return self::keluar()
            ->aktif()
            ->withSum(['transaksi as total' => function ($q) use ($tahun) {
                $q->tahun($tahun);
            }], 'uang_keluar')
            ->having('total', '>', 0)
            ->orderByDesc('total')
            ->get()
            ->map(function ($kat) {
                return [
                    'nama' => $kat->nama,
                    'warna' => $kat->warna,
                    'total' => $kat->total ?? 0,
                ];
            })
            ->toArray();
    }

    /**
     * Get breakdown pemasukan per kategori
     */
    public static function getBreakdownPemasukan(int $tahun): array
    {
        return self::masuk()
            ->aktif()
            ->withSum(['transaksi as total' => function ($q) use ($tahun) {
                $q->tahun($tahun);
            }], 'uang_masuk')
            ->having('total', '>', 0)
            ->orderByDesc('total')
            ->get()
            ->map(function ($kat) {
                return [
                    'nama' => $kat->nama,
                    'warna' => $kat->warna,
                    'total' => $kat->total ?? 0,
                ];
            })
            ->toArray();
    }
}
