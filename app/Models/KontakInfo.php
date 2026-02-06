<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model KontakInfo untuk menyimpan informasi kontak BUMNag
 * Menggunakan singleton pattern (hanya 1 record)
 */
class KontakInfo extends Model
{
    use HasFactory;

    protected $table = 'kontak_info';

    protected $fillable = [
        'telepon',
        'email',
        'alamat',
        'google_maps_embed',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'twitter',
        'whatsapp',
    ];

    /**
     * Mendapatkan instance kontak info (singleton pattern)
     */
    public static function getInstance(): self
    {
        return self::firstOrCreate([], [
            'telepon' => '',
            'email' => '',
            'alamat' => '',
        ]);
    }
}
