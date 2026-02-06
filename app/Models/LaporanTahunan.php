<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model LaporanTahunan untuk menyimpan laporan tahunan BUMNag
 * 
 * Fitur:
 * - Upload file PDF
 * - Download tracking
 * - SEO Meta Tags
 * - Soft Delete (Archive)
 */
class LaporanTahunan extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $table = 'laporan_tahunan';

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
        'tahun',
        'judul',
        'slug',
        'deskripsi',
        'cover_image',
        'file_laporan',
        'file_original_name',
        'file_size',
        'status',
        'download_count',
        'uploaded_by',
        'tanggal_publikasi',
        'meta_title',
        'meta_description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'file_size' => 'integer',
            'download_count' => 'integer',
            'tanggal_publikasi' => 'datetime',
        ];
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Relasi: Laporan diupload oleh User
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    /**
     * Scope: Hanya laporan yang sudah dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: Hanya laporan draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Urutkan berdasarkan tahun terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('tahun');
    }

    /**
     * Scope: Filter berdasarkan tahun
     */
    public function scopeTahun($query, int $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    /**
     * Scope: Pencarian
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('deskripsi', 'like', "%{$keyword}%")
              ->orWhere('tahun', 'like', "%{$keyword}%");
        });
    }

    // ==========================================
    // ACCESSORS & MUTATORS
    // ==========================================

    /**
     * Mendapatkan URL cover image
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }
        return asset('uploads/laporan-tahunan/covers/' . $this->cover_image);
    }

    /**
     * Mendapatkan URL file laporan
     */
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_laporan) {
            return null;
        }
        return asset('uploads/laporan-tahunan/' . $this->file_laporan);
    }

    /**
     * Mendapatkan ukuran file yang readable
     */
    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        
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
        if ($this->meta_description) {
            return $this->meta_description;
        }
        
        return $this->deskripsi 
            ? \Illuminate\Support\Str::limit(strip_tags($this->deskripsi), 160)
            : "Laporan Tahunan BUMNag Madani Lubuk Malako Tahun {$this->tahun}";
    }

    /**
     * Mendapatkan status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'published' ? 'Published' : 'Draft';
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    /**
     * Cek apakah laporan sudah dipublish
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Increment jumlah download
     */
    public function incrementDownload(): void
    {
        $this->increment('download_count');
    }

    /**
     * Generate judul default berdasarkan tahun
     */
    public static function generateDefaultTitle(int $tahun): string
    {
        return "Laporan Tahunan BUMNag Madani {$tahun}";
    }

    /**
     * Get daftar tahun yang tersedia untuk dipilih
     */
    public static function getAvailableYears(): array
    {
        $currentYear = (int) date('Y');
        $startYear = 2020; // Tahun awal BUMNag berdiri
        
        $existingYears = static::pluck('tahun')->toArray();
        $years = [];
        
        for ($year = $currentYear; $year >= $startYear; $year--) {
            if (!in_array($year, $existingYears)) {
                $years[] = $year;
            }
        }
        
        return $years;
    }

    /**
     * Get semua tahun yang sudah ada laporan
     */
    public static function getYearsWithReports(): array
    {
        return static::published()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->toArray();
    }
}
