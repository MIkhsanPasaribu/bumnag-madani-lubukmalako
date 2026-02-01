<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Model Berita untuk menyimpan berita dan artikel BUMNag
 */
class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'ringkasan',
        'gambar',
        'penulis_id',
        'status',
        'tanggal_publikasi',
        'views',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'datetime',
            'views' => 'integer',
        ];
    }

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
            // Pastikan slug unique
            $originalSlug = $berita->slug;
            $count = 1;
            while (static::where('slug', $berita->slug)->exists()) {
                $berita->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && !$berita->isDirty('slug')) {
                $berita->slug = Str::slug($berita->judul);
                // Pastikan slug unique (exclude current record)
                $originalSlug = $berita->slug;
                $count = 1;
                while (static::where('slug', $berita->slug)->where('id', '!=', $berita->id)->exists()) {
                    $berita->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Relasi: Berita ditulis oleh User
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    /**
     * Scope: Hanya berita yang sudah dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('tanggal_publikasi')
                     ->where('tanggal_publikasi', '<=', now());
    }

    /**
     * Scope: Hanya berita draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Urutkan berdasarkan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_publikasi', 'desc');
    }

    /**
     * Increment jumlah view
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Mendapatkan ringkasan otomatis jika tidak ada
     */
    public function getRingkasanAttribute($value): string
    {
        if ($value) {
            return $value;
        }
        // Auto-generate from konten (max 150 chars)
        return Str::limit(strip_tags($this->konten), 150);
    }

    /**
     * Mendapatkan URL gambar
     */
    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }
        return asset('uploads/berita/' . $this->gambar);
    }

    /**
     * Cek apakah berita sudah dipublish
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->tanggal_publikasi && $this->tanggal_publikasi <= now();
    }
}
