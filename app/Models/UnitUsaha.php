<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Unit Usaha BUMNag
 * 
 * Unit usaha utama: Unit Jasa, Unit Perkebunan
 */
class UnitUsaha extends Model
{
    use HasFactory;

    protected $table = 'unit_usaha';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Sub unit usaha di bawah unit ini
     */
    public function subUnits(): HasMany
    {
        return $this->hasMany(SubUnitUsaha::class, 'unit_id')->orderBy('urutan');
    }

    /**
     * Laporan keuangan untuk unit ini
     */
    public function laporanKeuangan(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class, 'unit_id');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope: hanya unit aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: urutan default
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah unit memiliki sub unit
     */
    public function hasSubUnits(): bool
    {
        return $this->subUnits()->count() > 0;
    }

    /**
     * Ambil daftar sub unit aktif
     */
    public function getActiveSubUnits()
    {
        return $this->subUnits()->where('is_active', true)->orderBy('urutan')->get();
    }

    /**
     * Dropdown unit usaha untuk select
     */
    public static function getDropdown(): array
    {
        return static::aktif()
            ->ordered()
            ->pluck('nama', 'id')
            ->toArray();
    }

    /**
     * Ambil semua unit dengan sub unit nya (eager loaded)
     */
    public static function getWithSubUnits()
    {
        return static::aktif()
            ->ordered()
            ->with(['subUnits' => fn($q) => $q->where('is_active', true)->orderBy('urutan')])
            ->get();
    }
}
