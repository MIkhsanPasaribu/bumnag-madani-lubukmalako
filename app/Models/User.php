<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User untuk admin BUMNag
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'security_question',
        'security_answer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'security_answer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki banyak berita
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'penulis_id');
    }

    /**
     * Relasi: User membuat banyak transaksi kas
     */
    public function transaksiKas(): HasMany
    {
        return $this->hasMany(TransaksiKas::class, 'created_by');
    }

    /**
     * Cek apakah user adalah super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Cek apakah user adalah admin biasa
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user sudah setup pertanyaan keamanan
     */
    public function hasSecurityQuestion(): bool
    {
        return !empty($this->security_question) && !empty($this->security_answer);
    }

    /**
     * Verifikasi jawaban keamanan
     */
    public function verifySecurityAnswer(string $answer): bool
    {
        return strtolower(trim($this->security_answer)) === strtolower(trim($answer));
    }

    /**
     * Daftar pertanyaan keamanan yang tersedia
     */
    public static function getSecurityQuestions(): array
    {
        return [
            'ibu' => 'Siapa nama ibu kandung Anda?',
            'sekolah' => 'Apa nama sekolah dasar Anda?',
            'hewan' => 'Apa nama hewan peliharaan pertama Anda?',
            'kota' => 'Di kota mana Anda dilahirkan?',
            'makanan' => 'Apa makanan favorit Anda?',
            'sahabat' => 'Siapa nama sahabat masa kecil Anda?',
        ];
    }
}
