<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model GambarBerita untuk menyimpan gallery gambar berita
 */
class GambarBerita extends Model
{
    use HasFactory;

    protected $table = 'gambar_berita';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'berita_id',
        'file_name',
        'original_name',
        'caption',
        'alt_text',
        'file_size',
        'mime_type',
        'urutan',
        'is_cover',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'urutan' => 'integer',
            'is_cover' => 'boolean',
        ];
    }

    /**
     * Relasi: Gambar milik Berita
     */
    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    /**
     * Scope: Urutkan berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }

    /**
     * Scope: Gambar cover
     */
    public function scopeCover($query)
    {
        return $query->where('is_cover', true);
    }

    /**
     * Mendapatkan URL gambar
     */
    public function getUrlAttribute(): string
    {
        return asset('uploads/berita/gallery/' . $this->file_name);
    }

    /**
     * Mendapatkan URL thumbnail
     */
    public function getThumbnailUrlAttribute(): string
    {
        // Jika ada sistem thumbnail, gunakan. Jika tidak, gunakan gambar asli
        return $this->url;
    }

    /**
     * Mendapatkan ukuran file yang readable
     */
    public function getFileSizeReadableAttribute(): string
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' B';
    }
}
