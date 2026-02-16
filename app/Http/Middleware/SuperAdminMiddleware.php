<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: Hanya super_admin yang bisa akses
 * Digunakan untuk fitur sensitif seperti Error Logs
 */
class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Hanya Super Admin.'], 403);
            }
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Hanya Super Admin yang diizinkan.');
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Hanya Super Admin.'], 403);
            }
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Hanya Super Admin yang diizinkan.');
        }

        return $next($request);
    }
}
