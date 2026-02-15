<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model HeroSlide untuk hero section beranda
 * 
 * Mendukung gambar dan video sebagai background hero slider
 */
class HeroSlide extends Model
{
    use HasFactory;

    protected $table = 'hero_slides';

    protected $fillable = [
        'judul',
        'subjudul',
        'tipe_media',
        'media_path',
        'url_tombol',
        'teks_tombol',
        'tampilkan_logo',
        'urutan',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'tampilkan_logo' => 'boolean',
        ];
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Relasi ke user yang membuat slide
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope untuk slide aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk sorting berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('subjudul', 'like', "%{$search}%");
        });
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Get media URL (gambar atau video)
     */
    public function getMediaUrlAttribute(): string
    {
        return asset('uploads/hero/' . $this->media_path);
    }

    /**
     * Cek apakah slide ini video
     */
    public function getIsVideoAttribute(): bool
    {
        return $this->tipe_media === 'video';
    }

    /**
     * Cek apakah slide ini gambar
     */
    public function getIsGambarAttribute(): bool
    {
        return $this->tipe_media === 'gambar';
    }

    /**
     * Get status badge class (untuk admin)
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return $this->status === 'aktif'
            ? 'bg-green-100 text-green-800'
            : 'bg-gray-100 text-gray-800';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Get tipe media label
     */
    public function getTipeMediaLabelAttribute(): string
    {
        return $this->tipe_media === 'video' ? 'Video' : 'Gambar';
    }
}
