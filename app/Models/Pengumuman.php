<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model Pengumuman untuk menyimpan pengumuman BUMNag
 */
class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

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
        ];
    }

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengumuman) {
            if (empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
            }
            // Pastikan slug unique
            $originalSlug = $pengumuman->slug;
            $count = 1;
            while (static::where('slug', $pengumuman->slug)->exists()) {
                $pengumuman->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($pengumuman) {
            if ($pengumuman->isDirty('judul') && !$pengumuman->isDirty('slug')) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
                $originalSlug = $pengumuman->slug;
                $count = 1;
                while (static::where('slug', $pengumuman->slug)->where('id', '!=', $pengumuman->id)->exists()) {
                    $pengumuman->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

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
     * Scope: Urutkan berdasarkan prioritas (tinggi dulu)
     */
    public function scopeByPrioritas($query)
    {
        return $query->orderByRaw("FIELD(prioritas, 'tinggi', 'sedang', 'rendah')");
    }

    /**
     * Scope: Filter berdasarkan prioritas
     */
    public function scopePrioritas($query, string $prioritas)
    {
        return $query->where('prioritas', $prioritas);
    }

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
}
