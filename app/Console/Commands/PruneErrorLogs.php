<?php

namespace App\Console\Commands;

use App\Models\ErrorLog;
use Illuminate\Console\Command;

/**
 * Command untuk membersihkan error logs lama dari database.
 * Jalankan manual: php artisan error-logs:prune
 * Otomatis via scheduler: terdaftar di routes/console.php
 */
class PruneErrorLogs extends Command
{
    protected $signature = 'error-logs:prune {--days=30 : Jumlah hari retensi}';

    protected $description = 'Hapus error logs yang lebih lama dari N hari (default: 30 hari)';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $count = ErrorLog::where('created_at', '<=', now()->subDays($days))->count();

        if ($count === 0) {
            $this->info("Tidak ada error log yang lebih dari {$days} hari.");
            return self::SUCCESS;
        }

        if ($this->confirm("Hapus {$count} error log yang lebih dari {$days} hari?", true)) {
            ErrorLog::where('created_at', '<=', now()->subDays($days))->delete();
            $this->info("Berhasil menghapus {$count} error log.");
        } else {
            $this->info('Dibatalkan.');
        }

        return self::SUCCESS;
    }
}
