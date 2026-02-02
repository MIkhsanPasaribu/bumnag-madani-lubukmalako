<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Model Pengumuman untuk menyimpan pengumuman BUMNag
 * 
 * Fitur:
 * - View tracking
 * - Featured/Pinned
 * - SEO Meta Tags
 * - Soft Delete (Archive)
 */
class Pengumuman extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $table = 'pengumuman';

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
        'prioritas',
        'lampiran',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        // Fitur baru
        'views',
        'is_featured',
        'is_pinned',
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
            'tanggal_mulai' => 'date',
            'tanggal_berakhir' => 'date',
            'views' => 'integer',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope: Pengumuman yang aktif (status aktif dan dalam periode)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
                     ->where('tanggal_mulai', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('tanggal_berakhir')
                           ->orWhere('tanggal_berakhir', '>=', now());
                     });
    }

    /**
     * Scope: Pengumuman tidak aktif
     */
    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'tidak_aktif');
    }

    /**
     * Scope: Hanya pengumuman featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Hanya pengumuman pinned
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope: Urutkan berdasarkan prioritas (pinned dulu, lalu tinggi)
     */
    public function scopeByPrioritas($query)
    {
        return $query->orderByDesc('is_pinned')
                     ->orderByRaw("FIELD(prioritas, 'tinggi', 'sedang', 'rendah')");
    }

    /**
     * Scope: Filter berdasarkan prioritas
     */
    public function scopePrioritas($query, string $prioritas)
    {
        return $query->where('prioritas', $prioritas);
    }

    /**
     * Scope: Pencarian
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('konten', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope: Urutkan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('is_pinned')
                     ->orderByDesc('tanggal_mulai');
    }

    // ==========================================
    // ACCESSORS & MUTATORS
    // ==========================================

    /**
     * Mendapatkan URL lampiran
     */
    public function getLampiranUrlAttribute(): ?string
    {
        if (!$this->lampiran) {
            return null;
        }
        return asset('uploads/pengumuman/' . $this->lampiran);
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
     * Mendapatkan badge class berdasarkan prioritas
     */
    public function getPrioritasBadgeClass(): string
    {
        return match ($this->prioritas) {
            'tinggi' => 'badge-amber',
            'sedang' => 'badge-warning',
            'rendah' => 'badge-success',
            default => 'badge-primary',
        };
    }

    /**
     * Mendapatkan label prioritas
     */
    public function getPrioritasLabel(): string
    {
        return match ($this->prioritas) {
            'tinggi' => 'Prioritas Tinggi',
            'sedang' => 'Prioritas Sedang',
            'rendah' => 'Prioritas Rendah',
            default => 'Tidak Diketahui',
        };
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Cek apakah pengumuman sedang aktif
     */
    public function isAktif(): bool
    {
        if ($this->status !== 'aktif') {
            return false;
        }

        $now = now()->startOfDay();
        $mulai = $this->tanggal_mulai;
        $berakhir = $this->tanggal_berakhir;

        if ($mulai > $now) {
            return false;
        }

        if ($berakhir && $berakhir < $now) {
            return false;
        }

        return true;
    }

    /**
     * Increment jumlah view
     */
    public function incrementViews(): void
    {
        $this->increment('views');
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
