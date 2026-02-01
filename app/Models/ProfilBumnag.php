<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model ProfilBumnag untuk menyimpan profil organisasi BUMNag
 */
class ProfilBumnag extends Model
{
    use HasFactory;

    protected $table = 'profil_bumnag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_bumnag',
        'nama_nagari',
        'alamat',
        'telepon',
        'email',
        'website',
        'sejarah',
        'visi',
        'misi',
        'struktur_organisasi',
        'logo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'struktur_organisasi' => 'array',
        ];
    }

    /**
     * Mendapatkan instance profil BUMNag (singleton pattern)
     * Karena hanya ada satu profil untuk BUMNag
     */
    public static function getProfil(): ?self
    {
        return self::first();
    }

    /**
     * Mendapatkan daftar struktur organisasi yang terformat
     */
    public function getStrukturOrganisasiFormatted(): array
    {
        return $this->struktur_organisasi ?? [];
    }

    /**
     * Mendapatkan misi sebagai array (split by newline atau bullet)
     */
    public function getMisiArray(): array
    {
        if (!$this->misi) {
            return [];
        }

        // Split by newline dan filter empty
        $lines = preg_split('/\r\n|\r|\n/', $this->misi);
        return array_filter(array_map('trim', $lines));
    }
}
