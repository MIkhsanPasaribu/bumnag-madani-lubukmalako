<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';

    protected $fillable = [
        'periode',
        'tahun',
        'bulan',
        'pendapatan',
        'pengeluaran',
        'laba_rugi',
        'aset',
        'kewajiban',
        'modal',
        'keterangan',
        'dokumen',
        'is_published',
    ];

    protected $casts = [
        'pendapatan' => 'decimal:2',
        'pengeluaran' => 'decimal:2',
        'laba_rugi' => 'decimal:2',
        'aset' => 'decimal:2',
        'kewajiban' => 'decimal:2',
        'modal' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
