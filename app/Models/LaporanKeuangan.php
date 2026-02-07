<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Model Laporan Keuangan
 * 
 * Mencatat pendapatan & pengeluaran per unit/sub-unit per bulan/tahun
 * Menggantikan model TransaksiKas (Buku Kas Harian)
 */
class LaporanKeuangan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'laporan_keuangan';

    protected $fillable = [
        'unit_id',
        'sub_unit_id',
        'bulan',
        'tahun',
        'pendapatan',
        'pengeluaran',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'bulan' => 'integer',
            'tahun' => 'integer',
            'pendapatan' => 'decimal:2',
            'pengeluaran' => 'decimal:2',
        ];
    }

    /**
     * Nama bulan dalam Bahasa Indonesia
     */
    public static array $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    // =========================================================================
    // ACTIVITY LOG
    // =========================================================================

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['unit_id', 'sub_unit_id', 'bulan', 'tahun', 'pendapatan', 'pengeluaran', 'keterangan'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Laporan keuangan {$eventName}");
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitUsaha::class, 'unit_id');
    }

    public function subUnit(): BelongsTo
    {
        return $this->belongsTo(SubUnitUsaha::class, 'sub_unit_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Laba/Rugi = Pendapatan - Pengeluaran
     */
    public function getLabaRugiAttribute(): float
    {
        return (float) $this->pendapatan - (float) $this->pengeluaran;
    }

    /**
     * Format pendapatan: "Rp 1.500.000"
     */
    public function getPendapatanFormattedAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->pendapatan, 0, ',', '.');
    }

    /**
     * Format pengeluaran: "Rp 1.200.000"
     */
    public function getPengeluaranFormattedAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->pengeluaran, 0, ',', '.');
    }

    /**
     * Format laba/rugi dengan tanda positif/negatif
     */
    public function getLabaRugiFormattedAttribute(): string
    {
        $value = $this->laba_rugi;
        $prefix = $value >= 0 ? '' : '-';
        return $prefix . 'Rp ' . number_format(abs($value), 0, ',', '.');
    }

    /**
     * Periode: "Januari 2026"
     */
    public function getPeriodeAttribute(): string
    {
        return (self::$namaBulan[$this->bulan] ?? '') . ' ' . $this->tahun;
    }

    /**
     * Nama unit lengkap (termasuk sub unit jika ada)
     */
    public function getNamaUnitLengkapAttribute(): string
    {
        $nama = $this->unit->nama ?? '-';
        if ($this->sub_unit_id && $this->subUnit) {
            $nama .= ' - ' . $this->subUnit->nama;
        }
        return $nama;
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Filter berdasarkan bulan dan tahun
     */
    public function scopeBulan($query, int $bulan, int $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    /**
     * Filter berdasarkan tahun
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    /**
     * Filter berdasarkan unit
     */
    public function scopeUnit($query, int $unitId)
    {
        return $query->where('unit_id', $unitId);
    }

    /**
     * Filter berdasarkan sub unit
     */
    public function scopeSubUnit($query, int $subUnitId)
    {
        return $query->where('sub_unit_id', $subUnitId);
    }

    /**
     * Urutan default: tahun desc, bulan desc, unit, sub_unit
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('tahun', 'desc')
                     ->orderBy('bulan', 'desc')
                     ->orderBy('unit_id')
                     ->orderBy('sub_unit_id');
    }

    // =========================================================================
    // STATIC METHODS
    // =========================================================================

    /**
     * Ambil daftar tahun yang tersedia
     */
    public static function getTahunTersedia(): array
    {
        return static::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    /**
     * Ambil daftar bulan yang tersedia untuk tahun tertentu
     */
    public static function getBulanTersedia(int $tahun): array
    {
        return static::where('tahun', $tahun)
            ->select('bulan')
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan')
            ->toArray();
    }

    /**
     * Rekap bulanan: total pendapatan & pengeluaran per bulan dalam setahun
     * Digunakan untuk chart dan tabel rekap tahunan
     */
    public static function getRekapTahunan(int $tahun, ?int $unitId = null): array
    {
        $query = static::where('tahun', $tahun);

        if ($unitId) {
            $query->where('unit_id', $unitId);
        }

        $data = $query->selectRaw('bulan, SUM(pendapatan) as total_pendapatan, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return $data->map(function ($row) use ($tahun) {
            return [
                'bulan' => $row->bulan,
                'tahun' => $tahun,
                'nama_bulan' => self::$namaBulan[$row->bulan] ?? '-',
                'total_pendapatan' => (float) $row->total_pendapatan,
                'total_pengeluaran' => (float) $row->total_pengeluaran,
                'laba_rugi' => (float) $row->total_pendapatan - (float) $row->total_pengeluaran,
            ];
        })->toArray();
    }

    /**
     * Rekap per unit untuk bulan & tahun tertentu
     * Menampilkan breakdown per unit dan sub-unit
     */
    public static function getRekapPerUnit(int $bulan, int $tahun): array
    {
        $units = UnitUsaha::aktif()->ordered()->with(['subUnits' => fn($q) => $q->aktif()->ordered()])->get();
        $result = [];

        foreach ($units as $unit) {
            $unitData = [
                'unit_id' => $unit->id,
                'nama_unit' => $unit->nama,
                'kode_unit' => $unit->kode,
                'sub_units' => [],
                'total_pendapatan' => 0,
                'total_pengeluaran' => 0,
                'total_laba_rugi' => 0,
            ];

            if ($unit->hasSubUnits()) {
                foreach ($unit->subUnits as $subUnit) {
                    $laporan = static::where('unit_id', $unit->id)
                        ->where('sub_unit_id', $subUnit->id)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->first();

                    $pendapatan = $laporan ? (float) $laporan->pendapatan : 0;
                    $pengeluaran = $laporan ? (float) $laporan->pengeluaran : 0;

                    $unitData['sub_units'][] = [
                        'sub_unit_id' => $subUnit->id,
                        'nama_sub_unit' => $subUnit->nama,
                        'kode_sub_unit' => $subUnit->kode,
                        'pendapatan' => $pendapatan,
                        'pengeluaran' => $pengeluaran,
                        'laba_rugi' => $pendapatan - $pengeluaran,
                        'keterangan' => $laporan?->keterangan,
                    ];

                    $unitData['total_pendapatan'] += $pendapatan;
                    $unitData['total_pengeluaran'] += $pengeluaran;
                }
            } else {
                // Unit tanpa sub unit (misal: Unit Perkebunan)
                $laporan = static::where('unit_id', $unit->id)
                    ->whereNull('sub_unit_id')
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                $unitData['total_pendapatan'] = $laporan ? (float) $laporan->pendapatan : 0;
                $unitData['total_pengeluaran'] = $laporan ? (float) $laporan->pengeluaran : 0;
                $unitData['keterangan'] = $laporan?->keterangan;
            }

            $unitData['total_laba_rugi'] = $unitData['total_pendapatan'] - $unitData['total_pengeluaran'];
            $result[] = $unitData;
        }

        return $result;
    }

    /**
     * Rekap total (gabungan semua unit) untuk bulan & tahun tertentu
     */
    public static function getRekapBulanan(int $bulan, int $tahun): array
    {
        $data = static::where('bulan', $bulan)->where('tahun', $tahun)->get();

        return [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'periode' => self::$namaBulan[$bulan] . ' ' . $tahun,
            'total_pendapatan' => (float) $data->sum('pendapatan'),
            'total_pengeluaran' => (float) $data->sum('pengeluaran'),
            'laba_rugi' => (float) $data->sum('pendapatan') - (float) $data->sum('pengeluaran'),
            'jumlah_laporan' => $data->count(),
        ];
    }

    /**
     * Rekap per unit untuk setahun (untuk PDF/Excel per unit)
     */
    public static function getRekapTahunanPerUnit(int $tahun, int $unitId): array
    {
        $data = static::where('tahun', $tahun)
            ->where('unit_id', $unitId)
            ->selectRaw('bulan, SUM(pendapatan) as total_pendapatan, SUM(pengeluaran) as total_pengeluaran')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return $data->map(function ($row) use ($tahun) {
            return [
                'bulan' => $row->bulan,
                'tahun' => $tahun,
                'nama_bulan' => self::$namaBulan[$row->bulan] ?? '-',
                'total_pendapatan' => (float) $row->total_pendapatan,
                'total_pengeluaran' => (float) $row->total_pengeluaran,
                'laba_rugi' => (float) $row->total_pendapatan - (float) $row->total_pengeluaran,
            ];
        })->toArray();
    }

    /**
     * Statistik tahunan - total keseluruhan
     */
    public static function getStatistikTahunan(int $tahun): array
    {
        $data = static::where('tahun', $tahun)->get();

        $totalPendapatan = (float) $data->sum('pendapatan');
        $totalPengeluaran = (float) $data->sum('pengeluaran');

        return [
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'total_laba_rugi' => $totalPendapatan - $totalPengeluaran,
            'jumlah_laporan' => $data->count(),
            'jumlah_bulan' => $data->unique('bulan')->count(),
        ];
    }
}
