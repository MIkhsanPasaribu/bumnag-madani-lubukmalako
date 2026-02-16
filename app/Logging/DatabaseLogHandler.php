<?php

namespace App\Logging;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

/**
 * Custom Monolog Handler yang menyimpan log ke database.
 * 
 * Fitur keamanan:
 * - Sanitasi data sensitif (password, token, API key, dll)
 * - Rate limiting: max 100 entries per menit untuk mencegah DB flooding
 * - Truncate stack trace agar tidak membengkakkan database
 * - Wrapped dalam try-catch — jika DB gagal, tidak throw (fallback ke file log)
 */
class DatabaseLogHandler extends AbstractProcessingHandler
{
    /**
     * Counter untuk rate limiting (per-request basis)
     */
    private int $logCount = 0;
    private float $windowStart;
    private const MAX_LOGS_PER_MINUTE = 100;

    public function __construct(Level $level = Level::Warning, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->windowStart = microtime(true);
    }

    /**
     * Tulis log record ke database
     */
    protected function write(LogRecord $record): void
    {
        // Rate limiting: cegah DB flooding saat error loop
        if ($this->isRateLimited()) {
            return;
        }

        try {
            // Pastikan tabel sudah ada (skip saat migration belum jalan)
            if (!$this->isTableReady()) {
                return;
            }

            $exception = $record->context['exception'] ?? null;
            $request = $this->captureRequest();

            ErrorLog::create([
                'level'              => $record->level->name,
                'message'            => mb_substr($record->message, 0, 65535),
                'exception_class'    => $exception ? get_class($exception) : null,
                'file'               => $exception?->getFile(),
                'line'               => $exception?->getLine(),
                'stack_trace'        => ErrorLog::truncateStackTrace($exception?->getTraceAsString()),
                'url'                => $request['url'] ?? null,
                'method'             => $request['method'] ?? null,
                'ip_address'         => $request['ip'] ?? null,
                'user_agent'         => $request['user_agent'] ?? null,
                'user_id'            => $this->getCurrentUserId(),
                'request_data'       => $request['data'] ?? null,
                'additional_context' => $this->extractContext($record->context),
                'is_read'            => false,
            ]);
        } catch (\Throwable $e) {
            // Jangan throw — file log handler sudah menangani fallback
            // Ini mencegah circular dependency jika DB sedang down
        }
    }

    /**
     * Cek apakah rate limit sudah tercapai
     */
    private function isRateLimited(): bool
    {
        $now = microtime(true);

        // Reset counter setiap 60 detik
        if (($now - $this->windowStart) > 60) {
            $this->logCount = 0;
            $this->windowStart = $now;
        }

        $this->logCount++;

        return $this->logCount > self::MAX_LOGS_PER_MINUTE;
    }

    /**
     * Cek apakah tabel error_logs sudah ada di database
     */
    private function isTableReady(): bool
    {
        static $ready = null;

        if ($ready === null) {
            try {
                $ready = \Illuminate\Support\Facades\Schema::hasTable('error_logs');
            } catch (\Throwable $e) {
                $ready = false;
            }
        }

        return $ready;
    }

    /**
     * Ambil informasi request saat ini (jika ada)
     */
    private function captureRequest(): array
    {
        try {
            if (!app()->runningInConsole() && app()->bound('request')) {
                $request = request();

                return [
                    'url'        => mb_substr($request->fullUrl(), 0, 2048),
                    'method'     => $request->method(),
                    'ip'         => $request->ip(),
                    'user_agent' => mb_substr($request->userAgent() ?? '', 0, 500),
                    'data'       => ErrorLog::sanitizeRequestData(
                        $request->except(['_token', '_method'])
                    ),
                ];
            }
        } catch (\Throwable $e) {
            // Request mungkin belum ready
        }

        return [];
    }

    /**
     * Ambil user ID yang sedang login (jika ada)
     */
    private function getCurrentUserId(): ?int
    {
        try {
            return Auth::id();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Extract context tambahan dari log record (tanpa exception object)
     */
    private function extractContext(array $context): ?array
    {
        // Hapus exception object karena sudah diproses terpisah
        unset($context['exception']);

        if (empty($context)) {
            return null;
        }

        // Sanitasi dan serialize context
        $cleaned = [];
        foreach ($context as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $cleaned[$key] = $value;
            } elseif (is_array($value)) {
                $cleaned[$key] = ErrorLog::sanitizeRequestData($value);
            } else {
                // Object dan resource dikonversi ke string
                $cleaned[$key] = '[' . get_debug_type($value) . ']';
            }
        }

        return $cleaned;
    }
}
