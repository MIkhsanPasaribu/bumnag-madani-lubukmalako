<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model GaleriBumnag untuk galeri foto BUMNag Madani
 */
class GaleriBumnag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'galeri_bumnag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'urutan',
        'status',
        'uploaded_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    /**
     * Relasi ke user yang mengupload
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope untuk foto aktif
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
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute()
    {
        return asset('uploads/galeri-bumnag/' . $this->foto);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'aktif' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-gray-100 text-gray-800';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }
}
