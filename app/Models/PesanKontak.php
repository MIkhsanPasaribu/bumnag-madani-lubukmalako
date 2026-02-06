<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model PesanKontak untuk menyimpan pesan dari form hubungi kami
 */
class PesanKontak extends Model
{
    use HasFactory;

    protected $table = 'pesan_kontak';

    protected $fillable = [
        'nama',
        'organisasi',
        'email',
        'subjek',
        'pesan',
        'status',
        'balasan',
        'dibaca_at',
        'dibalas_at',
    ];

    protected function casts(): array
    {
        return [
            'dibaca_at' => 'datetime',
            'dibalas_at' => 'datetime',
        ];
    }

    /**
     * Scope: hanya pesan belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('status', 'belum_dibaca');
    }

    /**
     * Scope: hanya pesan sudah dibaca
     */
    public function scopeDibaca($query)
    {
        return $query->where('status', 'dibaca');
    }

    /**
     * Scope: hanya pesan sudah dibalas
     */
    public function scopeDibalas($query)
    {
        return $query->where('status', 'dibalas');
    }

    /**
     * Tandai pesan sebagai dibaca
     */
    public function tandaiDibaca(): void
    {
        if ($this->status === 'belum_dibaca') {
            $this->update([
                'status' => 'dibaca',
                'dibaca_at' => now(),
            ]);
        }
    }

    /**
     * Cek apakah pesan belum dibaca
     */
    public function isBelumDibaca(): bool
    {
        return $this->status === 'belum_dibaca';
    }

    /**
     * Get badge class berdasarkan status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'belum_dibaca' => 'bg-red-100 text-red-700',
            'dibaca' => 'bg-blue-100 text-blue-700',
            'dibalas' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get label status
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'belum_dibaca' => 'Belum Dibaca',
            'dibaca' => 'Dibaca',
            'dibalas' => 'Dibalas',
            default => $this->status,
        };
    }
}
