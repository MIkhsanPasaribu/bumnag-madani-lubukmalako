<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role.admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role.unit' => \App\Http\Middleware\UnitMiddleware::class,
            'role.subunit' => \App\Http\Middleware\SubUnitMiddleware::class,
            'role.superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Render custom error pages untuk production
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e, $request) {
            $status = $e->getStatusCode();
            $customPages = [403, 404, 419, 429, 500, 503];

            if (in_array($status, $customPages) && !$request->expectsJson()) {
                return response()->view("errors.{$status}", [
                    'exception' => $e,
                    'message' => $e->getMessage(),
                ], $status);
            }
        });

        // Render 500 untuk exception yang tidak tertangkap di production
        $exceptions->render(function (\Throwable $e, $request) {
            if (!app()->hasDebugModeEnabled() && !$request->expectsJson()) {
                return response()->view('errors.500', [
                    'exception' => $e,
                    'message' => 'Terjadi kesalahan pada server.',
                ], 500);
            }
        });
    })->create();
