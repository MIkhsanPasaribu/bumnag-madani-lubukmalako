<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User untuk admin, unit, dan sub unit BUMNag
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'unit_id',
        'sub_unit_id',
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
     * Relasi: User membuat banyak laporan keuangan
     */
    public function laporanKeuangan(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class, 'created_by');
    }

    /**
     * Relasi: User terkait dengan unit usaha
     */
    public function unitUsaha(): BelongsTo
    {
        return $this->belongsTo(UnitUsaha::class, 'unit_id');
    }

    /**
     * Relasi: User terkait dengan sub unit usaha
     */
    public function subUnitUsaha(): BelongsTo
    {
        return $this->belongsTo(SubUnitUsaha::class, 'sub_unit_id');
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
     * Cek apakah user adalah admin atau super admin
     */
    public function isAdminLevel(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Cek apakah user adalah akun unit usaha
     */
    public function isUnit(): bool
    {
        return $this->role === 'unit';
    }

    /**
     * Cek apakah user adalah akun sub unit usaha
     */
    public function isSubUnit(): bool
    {
        return $this->role === 'sub_unit';
    }

    /**
     * Mendapatkan nama role yang readable
     */
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'unit' => 'Unit ' . ($this->unitUsaha?->nama ?? ''),
            'sub_unit' => 'Sub Unit ' . ($this->subUnitUsaha?->nama ?? ''),
            default => 'Unknown',
        };
    }

    /**
     * Dashboard route berdasarkan role
     */
    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            'super_admin', 'admin' => 'admin.dashboard',
            'unit' => 'unit.dashboard',
            'sub_unit' => 'subunit.dashboard',
            default => 'beranda',
        };
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
