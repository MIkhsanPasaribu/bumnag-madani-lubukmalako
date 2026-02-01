<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Model TransaksiKas untuk Buku Kas Harian Plasma Lubuk Malako
 * 
 * Format tabel: NO URUT | NO Kw | TANGGAL | URAIAN | UANG MASUK | UANG KELUAR | SALDO | KETERANGAN
 */
class TransaksiKas extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'transaksi_kas';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no_urut',
        'no_kwitansi',
        'tanggal',
        'uraian',
        'uang_masuk',
        'uang_keluar',
        'saldo',
        'keterangan',
        'kategori_id',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'uang_masuk' => 'decimal:2',
            'uang_keluar' => 'decimal:2',
            'saldo' => 'decimal:2',
            'no_urut' => 'integer',
        ];
    }

    /**
     * Daftar nama bulan dalam Bahasa Indonesia
     */
    public static array $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    // =========================================================================
    // ACTIVITY LOG CONFIGURATION
    // =========================================================================

    /**
     * Konfigurasi untuk activity logging
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['no_urut', 'no_kwitansi', 'tanggal', 'uraian', 'uang_masuk', 'uang_keluar', 'saldo', 'keterangan', 'kategori_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Transaksi kas telah {$eventName}");
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Relasi: Transaksi dibuat oleh User
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi: Transaksi diupdate oleh User
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relasi: Transaksi memiliki satu kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope: Filter berdasarkan bulan dan tahun
     */
    public function scopeBulan($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)
                     ->whereYear('tanggal', $tahun);
    }

    /**
     * Scope: Filter berdasarkan tahun
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->whereYear('tanggal', $tahun);
    }

    /**
     * Scope: Urutkan berdasarkan tanggal dan no_urut
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('tanggal', 'asc')
                     ->orderBy('no_urut', 'asc');
    }

    /**
     * Scope: Urutkan terbalik (terbaru dulu)
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('tanggal', 'desc')
                     ->orderBy('no_urut', 'desc');
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Format tanggal ke format Indonesia
     */
    public function getTanggalFormattedAttribute(): string
    {
        return $this->tanggal->format('d/m/Y');
    }

    /**
     * Format tanggal lengkap
     */
    public function getTanggalLengkapAttribute(): string
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = self::$namaBulan[$this->tanggal->month];
        return $hari[$this->tanggal->dayOfWeek] . ', ' . $this->tanggal->day . ' ' . $bulan . ' ' . $this->tanggal->year;
    }

    /**
     * Format uang masuk ke Rupiah
     */
    public function getUangMasukFormattedAttribute(): string
    {
        if ($this->uang_masuk <= 0) return '-';
        return 'Rp ' . number_format($this->uang_masuk, 0, ',', '.');
    }

    /**
     * Format uang keluar ke Rupiah
     */
    public function getUangKeluarFormattedAttribute(): string
    {
        if ($this->uang_keluar <= 0) return '-';
        return 'Rp ' . number_format($this->uang_keluar, 0, ',', '.');
    }

    /**
     * Format saldo ke Rupiah
     */
    public function getSaldoFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->saldo, 0, ',', '.');
    }

    /**
     * Cek apakah transaksi pemasukan
     */
    public function isPemasukan(): bool
    {
        return $this->uang_masuk > 0;
    }

    /**
     * Cek apakah transaksi pengeluaran
     */
    public function isPengeluaran(): bool
    {
        return $this->uang_keluar > 0;
    }

    // =========================================================================
    // STATIC METHODS
    // =========================================================================

    /**
     * Mendapatkan nomor urut berikutnya untuk tanggal tertentu
     */
    public static function getNextNoUrut(\DateTime $tanggal): int
    {
        $lastNo = self::whereDate('tanggal', $tanggal->format('Y-m-d'))
            ->max('no_urut');
        
        return ($lastNo ?? 0) + 1;
    }

    /**
     * Mendapatkan saldo terakhir sebelum tanggal tertentu
     */
    public static function getSaldoSebelum(\DateTime $tanggal): float
    {
        $lastTransaction = self::where('tanggal', '<', $tanggal->format('Y-m-d'))
            ->orWhere(function ($query) use ($tanggal) {
                $query->whereDate('tanggal', $tanggal->format('Y-m-d'))
                      ->where('id', '<', DB::raw('(SELECT COALESCE(MIN(id), 0) FROM transaksi_kas WHERE tanggal = "' . $tanggal->format('Y-m-d') . '")'));
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('no_urut', 'desc')
            ->first();
        
        return $lastTransaction ? (float) $lastTransaction->saldo : 0;
    }

    /**
     * Mendapatkan saldo awal bulan (saldo akhir bulan sebelumnya)
     */
    public static function getSaldoAwalBulan(int $bulan, int $tahun): float
    {
        // Cari transaksi terakhir bulan sebelumnya
        $tanggalAwal = \Carbon\Carbon::create($tahun, $bulan, 1)->subDay();
        
        $lastTransaction = self::where('tanggal', '<=', $tanggalAwal->format('Y-m-d'))
            ->orderBy('tanggal', 'desc')
            ->orderBy('no_urut', 'desc')
            ->first();
        
        return $lastTransaction ? (float) $lastTransaction->saldo : 0;
    }

    /**
     * Mendapatkan saldo akhir bulan
     */
    public static function getSaldoAkhirBulan(int $bulan, int $tahun): float
    {
        $lastTransaction = self::bulan($bulan, $tahun)
            ->orderBy('tanggal', 'desc')
            ->orderBy('no_urut', 'desc')
            ->first();
        
        return $lastTransaction ? (float) $lastTransaction->saldo : self::getSaldoAwalBulan($bulan, $tahun);
    }

    /**
     * Mendapatkan rekap bulanan
     */
    public static function getRekapBulanan(int $bulan, int $tahun): array
    {
        $transaksi = self::bulan($bulan, $tahun)->get();
        
        $totalMasuk = $transaksi->sum('uang_masuk');
        $totalKeluar = $transaksi->sum('uang_keluar');
        $saldoAwal = self::getSaldoAwalBulan($bulan, $tahun);
        $saldoAkhir = self::getSaldoAkhirBulan($bulan, $tahun);
        
        return [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nama_bulan' => self::$namaBulan[$bulan] ?? 'Unknown',
            'periode' => (self::$namaBulan[$bulan] ?? 'Unknown') . ' ' . $tahun,
            'jumlah_transaksi' => $transaksi->count(),
            'saldo_awal' => $saldoAwal,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'selisih' => $totalMasuk - $totalKeluar,
            'saldo_akhir' => $saldoAkhir,
        ];
    }

    /**
     * Mendapatkan rekap tahunan (per bulan)
     */
    public static function getRekapTahunan(int $tahun): array
    {
        $rekap = [];
        
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataTransaksi = self::bulan($bulan, $tahun)->exists();
            
            if ($dataTransaksi) {
                $rekap[] = self::getRekapBulanan($bulan, $tahun);
            }
        }
        
        return $rekap;
    }

    /**
     * Mendapatkan tahun yang tersedia
     */
    public static function getTahunTersedia(): array
    {
        return self::selectRaw('DISTINCT YEAR(tanggal) as tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    /**
     * Mendapatkan bulan yang tersedia untuk tahun tertentu
     */
    public static function getBulanTersedia(int $tahun): array
    {
        return self::tahun($tahun)
            ->selectRaw('DISTINCT MONTH(tanggal) as bulan')
            ->orderBy('bulan', 'asc')
            ->pluck('bulan')
            ->toArray();
    }

    /**
     * Recalculate saldo untuk semua transaksi mulai dari tanggal tertentu
     */
    public static function recalculateSaldoFromDate(\DateTime $startDate): void
    {
        // Dapatkan saldo sebelum tanggal ini
        $saldoSebelum = self::where('tanggal', '<', $startDate->format('Y-m-d'))
            ->orderBy('tanggal', 'desc')
            ->orderBy('no_urut', 'desc')
            ->value('saldo') ?? 0;
        
        // Update semua transaksi dari tanggal tersebut
        $transaksi = self::where('tanggal', '>=', $startDate->format('Y-m-d'))
            ->orderBy('tanggal', 'asc')
            ->orderBy('no_urut', 'asc')
            ->get();
        
        $saldoBerjalan = (float) $saldoSebelum;
        
        foreach ($transaksi as $trx) {
            $saldoBerjalan = $saldoBerjalan + (float) $trx->uang_masuk - (float) $trx->uang_keluar;
            $trx->saldo = $saldoBerjalan;
            $trx->saveQuietly(); // Save tanpa trigger events
        }
    }

    /**
     * Recalculate semua saldo dari awal
     */
    public static function recalculateAllSaldo(): void
    {
        $firstTransaction = self::orderBy('tanggal', 'asc')
            ->orderBy('no_urut', 'asc')
            ->first();
        
        if ($firstTransaction) {
            self::recalculateSaldoFromDate($firstTransaction->tanggal);
        }
    }

    /**
     * Mendapatkan statistik keseluruhan
     */
    public static function getStatistikKeseluruhan(): array
    {
        $totalMasuk = self::sum('uang_masuk');
        $totalKeluar = self::sum('uang_keluar');
        $saldoAkhir = self::orderBy('tanggal', 'desc')
            ->orderBy('no_urut', 'desc')
            ->value('saldo') ?? 0;
        
        return [
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'selisih' => $totalMasuk - $totalKeluar,
            'saldo_akhir' => $saldoAkhir,
            'jumlah_transaksi' => self::count(),
        ];
    }
}
