<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Model Berita untuk menyimpan berita dan artikel BUMNag
 * 
 * Fitur:
 * - Kategori berita
 * - Multiple gambar (gallery)
 * - Featured/Pinned
 * - SEO Meta Tags
 * - Scheduled publishing
 * - Soft Delete (Archive)
 */
class Berita extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $table = 'berita';

    /**
     * Field yang digunakan sebagai source untuk slug
     */
    protected string $slugSourceField = 'judul';

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
        'lampiran',
        'lampiran_original_name',
        'lampiran_size',
        'link_url',
        'link_text',
        'penulis_id',
        'status',
        'tanggal_publikasi',
        'tanggal_kegiatan',
        'views',
        // Fitur baru
        'kategori_id',
        'is_featured',
        'is_pinned',
        'is_scheduled',
        'meta_title',
        'meta_description',
        'meta_keywords',
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
            'tanggal_kegiatan' => 'date',
            'views' => 'integer',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'is_scheduled' => 'boolean',
        ];
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Relasi: Berita ditulis oleh User
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    /**
     * Relasi: Berita memiliki satu kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    /**
     * Relasi: Berita memiliki banyak gambar (gallery)
     */
    public function gambarGallery(): HasMany
    {
        return $this->hasMany(GambarBerita::class)->ordered();
    }

    /**
     * Mendapatkan gambar cover dari gallery (jika ada)
     */
    public function coverFromGallery()
    {
        return $this->hasOne(GambarBerita::class)->cover();
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope: Hanya berita yang sudah dipublish
     * Mempertimbangkan scheduled publishing
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
     * Scope: Berita yang terjadwal (belum publish)
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'published')
                     ->where('is_scheduled', true)
                     ->where('tanggal_publikasi', '>', now());
    }

    /**
     * Scope: Hanya berita featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Hanya berita pinned
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope: Urutkan berdasarkan terbaru (pinned dulu)
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('is_pinned')
                     ->orderByDesc('tanggal_publikasi');
    }

    /**
     * Scope: Filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    /**
     * Scope: Pencarian
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('konten', 'like', "%{$keyword}%")
              ->orWhere('ringkasan', 'like', "%{$keyword}%");
        });
    }

    // ==========================================
    // ACCESSORS & MUTATORS
    // ==========================================

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
     * Mendapatkan URL gambar utama
     */
    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }
        return asset('uploads/berita/' . $this->gambar);
    }

    /**
     * Mendapatkan URL lampiran
     */
    public function getLampiranUrlAttribute(): ?string
    {
        if (!$this->lampiran) {
            return null;
        }
        return asset('uploads/berita/lampiran/' . $this->lampiran);
    }

    /**
     * Mendapatkan ukuran lampiran yang readable
     */
    public function getLampiranSizeFormattedAttribute(): string
    {
        $bytes = $this->lampiran_size ?? 0;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Cek apakah berita memiliki lampiran
     */
    public function hasLampiran(): bool
    {
        return !empty($this->lampiran);
    }

    /**
     * Cek apakah berita memiliki link eksternal
     */
    public function hasLink(): bool
    {
        return !empty($this->link_url);
    }

    /**
     * Mendapatkan text link dengan fallback ke URL
     */
    public function getLinkDisplayTextAttribute(): string
    {
        return $this->link_text ?: $this->link_url;
    }

    /**
     * Mendapatkan meta title dengan fallback
     */
    public function getMetaTitleDisplayAttribute(): string
    {
        return $this->meta_title ?: $this->judul;
    }

    /**
     * Mendapatkan meta description dengan fallback
     */
    public function getMetaDescriptionDisplayAttribute(): string
    {
        return $this->meta_description ?: Str::limit(strip_tags($this->konten), 160);
    }

    /**
     * Mendapatkan status label yang lebih deskriptif
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'draft') {
            return 'Draft';
        }

        if ($this->is_scheduled && $this->tanggal_publikasi > now()) {
            return 'Terjadwal';
        }

        return 'Published';
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Cek apakah berita sudah dipublish
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' 
            && $this->tanggal_publikasi 
            && $this->tanggal_publikasi <= now();
    }

    /**
     * Cek apakah berita dalam status terjadwal
     */
    public function isScheduled(): bool
    {
        return $this->status === 'published' 
            && $this->is_scheduled 
            && $this->tanggal_publikasi 
            && $this->tanggal_publikasi > now();
    }

    /**
     * Mendapatkan berita terkait berdasarkan kategori
     */
    public function getRelatedByKategori(int $limit = 4)
    {
        if (!$this->kategori_id) {
            return collect();
        }

        return static::published()
            ->where('id', '!=', $this->id)
            ->where('kategori_id', $this->kategori_id)
            ->orderBy('tanggal_publikasi', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Toggle status featured
     */
    public function toggleFeatured(): void
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }

    /**
     * Toggle status pinned
     */
    public function togglePinned(): void
    {
        $this->update(['is_pinned' => !$this->is_pinned]);
    }
}
