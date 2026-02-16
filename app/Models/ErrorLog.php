<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model ErrorLog untuk menyimpan error/exception logs di database.
 * Memudahkan super_admin untuk debugging di production tanpa akses server.
 */
class ErrorLog extends Model
{
    use MassPrunable;

    protected $table = 'error_logs';

    protected $fillable = [
        'level',
        'message',
        'exception_class',
        'file',
        'line',
        'stack_trace',
        'url',
        'method',
        'ip_address',
        'user_agent',
        'user_id',
        'request_data',
        'additional_context',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'request_data' => 'array',
            'additional_context' => 'array',
            'is_read' => 'boolean',
            'line' => 'integer',
        ];
    }

    // =========================================================================
    // RELATIONSHIPS
    // =========================================================================

    /**
     * Relasi: Error log terkait dengan user yang sedang login saat error terjadi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /**
     * Scope: Hanya error yang belum dibaca
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Filter berdasarkan level
     */
    public function scopeByLevel(Builder $query, string $level): Builder
    {
        return $query->where('level', $level);
    }

    /**
     * Scope: Error terbaru (default 7 hari)
     */
    public function scopeRecent(Builder $query, int $days = 7): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Pencarian berdasarkan message, exception class, atau URL
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('message', 'like', "%{$keyword}%")
              ->orWhere('exception_class', 'like', "%{$keyword}%")
              ->orWhere('url', 'like', "%{$keyword}%")
              ->orWhere('file', 'like', "%{$keyword}%");
        });
    }

    // =========================================================================
    // METHODS
    // =========================================================================

    /**
     * Tandai error log sebagai sudah dibaca
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }

    /**
     * Tandai semua error logs sebagai sudah dibaca
     */
    public static function markAllAsRead(): int
    {
        return static::unread()->update(['is_read' => true]);
    }

    /**
     * Sanitasi request data — hapus field sensitif sebelum disimpan
     */
    public static function sanitizeRequestData(array $data): array
    {
        $sensitiveKeys = [
            'password',
            'password_confirmation',
            'current_password',
            'new_password',
            'token',
            'api_key',
            'api_secret',
            'secret',
            'credit_card',
            'card_number',
            'cvv',
            'security_answer',
            'remember_token',
            '_token',
        ];

        $sanitized = [];
        foreach ($data as $key => $value) {
            if (in_array(strtolower($key), $sensitiveKeys)) {
                $sanitized[$key] = '***DISEMBUNYIKAN***';
            } elseif (is_array($value)) {
                $sanitized[$key] = static::sanitizeRequestData($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Potong stack trace agar tidak terlalu panjang (max 10.000 karakter)
     */
    public static function truncateStackTrace(?string $trace, int $maxLength = 10000): ?string
    {
        if ($trace === null) {
            return null;
        }

        if (mb_strlen($trace) <= $maxLength) {
            return $trace;
        }

        return mb_substr($trace, 0, $maxLength) . "\n\n... [Stack trace terpotong, total " . mb_strlen($trace) . " karakter]";
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    /**
     * Warna badge berdasarkan level error
     */
    public function getLevelColorAttribute(): string
    {
        return match ($this->level) {
            'emergency' => 'bg-purple-100 text-purple-800',
            'alert'     => 'bg-pink-100 text-pink-800',
            'critical'  => 'bg-red-100 text-red-800',
            'error'     => 'bg-orange-100 text-orange-800',
            'warning'   => 'bg-yellow-100 text-yellow-800',
            'notice'    => 'bg-blue-100 text-blue-800',
            'info'      => 'bg-cyan-100 text-cyan-800',
            'debug'     => 'bg-gray-100 text-gray-800',
            default     => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Nama file singkat (tanpa base path)
     */
    public function getShortFileAttribute(): ?string
    {
        if (!$this->file) {
            return null;
        }

        // Hapus base path agar lebih ringkas
        return str_replace(base_path() . DIRECTORY_SEPARATOR, '', $this->file);
    }

    // =========================================================================
    // PRUNABLE
    // =========================================================================

    /**
     * Tentukan query untuk mass pruning — hapus log lebih dari 30 hari
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(30));
    }
}
