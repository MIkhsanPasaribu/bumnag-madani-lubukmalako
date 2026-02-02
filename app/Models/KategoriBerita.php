<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model KategoriBerita untuk mengelompokkan berita
 */
class KategoriBerita extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'kategori_berita';

    /**
     * Field yang digunakan sebagai source untuk slug
     */
    protected string $slugSourceField = 'nama';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'warna',
        'icon',
        'is_active',
        'urutan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    /**
     * Relasi: Kategori memiliki banyak Berita
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }

    /**
     * Scope: Hanya kategori yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Urutkan berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    /**
     * Mendapatkan jumlah berita yang dipublish
     */
    public function getPublishedCountAttribute(): int
    {
        return $this->berita()->published()->count();
    }

    /**
     * Mendapatkan style warna untuk badge
     */
    public function getBadgeStyleAttribute(): string
    {
        return "background-color: {$this->warna}20; color: {$this->warna};";
    }
}
