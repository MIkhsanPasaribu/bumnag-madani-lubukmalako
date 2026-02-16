<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Level;

/**
 * Custom Laravel Log Channel Creator untuk database logging.
 * 
 * Digunakan di config/logging.php sebagai custom driver:
 * 'database' => [
 *     'driver' => 'custom',
 *     'via'    => App\Logging\DatabaseLogger::class,
 *     'level'  => 'warning',
 * ]
 */
class DatabaseLogger
{
    /**
     * Create a custom Monolog instance.
     */
    public function __invoke(array $config): Logger
    {
        $level = Level::fromName($config['level'] ?? 'warning');

        return new Logger('database', [
            new DatabaseLogHandler($level),
        ]);
    }
}
