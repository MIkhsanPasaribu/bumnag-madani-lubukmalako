<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'kategori',
        'penulis',
        'is_published',
        'published_at',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    protected static function booted(): void
    {
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
