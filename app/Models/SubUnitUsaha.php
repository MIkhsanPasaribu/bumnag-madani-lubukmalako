<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Sub Unit Usaha
 * 
 * Sub unit di bawah Unit Jasa: Transportasi, Pasar, Ketahanan Pangan
 */
class SubUnitUsaha extends Model
{
    use HasFactory;

    protected $table = 'sub_unit_usaha';

    protected $fillable = [
        'unit_id',
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
     * Unit usaha induk
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitUsaha::class, 'unit_id');
    }

    /**
     * Laporan keuangan untuk sub unit ini
     */
    public function laporanKeuangan(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class, 'sub_unit_id');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope: hanya sub unit aktif
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

    /**
     * Scope: filter berdasarkan unit
     */
    public function scopeUnit($query, int $unitId)
    {
        return $query->where('unit_id', $unitId);
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================

    /**
     * Nama lengkap: "Unit Jasa - Transportasi"
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->unit->nama . ' - ' . $this->nama;
    }

    /**
     * Dropdown sub unit berdasarkan unit_id
     */
    public static function getDropdownByUnit(int $unitId): array
    {
        return static::aktif()
            ->unit($unitId)
            ->ordered()
            ->pluck('nama', 'id')
            ->toArray();
    }
}
