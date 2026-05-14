<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

abstract class Controller
{
    /**
     * Log an exception to a per-controller daily log file.
     *
     * Files land in storage/logs/controllers/{name}-YYYY-MM-DD.log so each
     * controller's errors are isolated and easy to grep in Log Viewer.
     */
    protected function logError(string $method, \Throwable $e, array $context = []): void
    {
        $controllerName = class_basename(static::class);
        $logName        = strtolower(str_replace('Controller', '', $controllerName));

        // Caller frame = the catch block that called logError()
        $caller     = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? [];
        $catchLine  = $caller['line'] ?? 'unknown';
        $catchFile  = basename($caller['file'] ?? '');

        $logger = Log::build([
            'driver' => 'daily',
            'path'   => storage_path('logs/controllers/' . $logName . '.log'),
            'days'   => 14,
        ]);

        $logger->error("[{$controllerName}::{$method}] " . $e->getMessage(), array_merge([
            'caught_at'      => "{$catchFile}:{$catchLine}",
            'exception'      => get_class($e),
            'thrown_at_file' => $e->getFile(),
            'thrown_at_line' => $e->getLine(),
            'trace'          => $e->getTraceAsString(),
        ], $context));
    }
}
