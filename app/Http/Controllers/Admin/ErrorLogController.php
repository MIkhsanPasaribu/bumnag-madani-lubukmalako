<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Error Logs di admin panel.
 * Hanya bisa diakses oleh super_admin.
 */
class ErrorLogController extends Controller
{
    /**
     * Daftar error logs dengan filter dan pagination
     */
    public function index(Request $request)
    {
        $query = ErrorLog::query()->latest();

        // Filter berdasarkan level
        if ($request->filled('level')) {
            $query->byLevel($request->level);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Pencarian
        if ($request->filled('cari')) {
            $query->search($request->cari);
        }

        // Filter status baca
        if ($request->filled('status') && $request->status === 'belum_dibaca') {
            $query->unread();
        }

        $errorLogs = $query->paginate(25)->appends($request->query());

        // Statistik ringkas
        $stats = [
            'total' => ErrorLog::count(),
            'belum_dibaca' => ErrorLog::unread()->count(),
            'hari_ini' => ErrorLog::whereDate('created_at', today())->count(),
            'minggu_ini' => ErrorLog::recent(7)->count(),
        ];

        return view('admin.error-logs.index', compact('errorLogs', 'stats'));
    }

    /**
     * Detail error log lengkap
     */
    public function show(ErrorLog $errorLog)
    {
        // Tandai sebagai sudah dibaca saat dilihat
        if (!$errorLog->is_read) {
            $errorLog->markAsRead();
        }

        return view('admin.error-logs.show', compact('errorLog'));
    }

    /**
     * Hapus satu error log
     */
    public function destroy(ErrorLog $errorLog)
    {
        $errorLog->delete();

        return redirect()
            ->route('admin.error-logs.index')
            ->with('success', 'Error log berhasil dihapus.');
    }

    /**
     * Hapus semua error logs
     */
    public function destroyAll()
    {
        $count = ErrorLog::count();
        ErrorLog::truncate();

        return redirect()
            ->route('admin.error-logs.index')
            ->with('success', "Semua error log ({$count} data) berhasil dihapus.");
    }

    /**
     * Tandai semua sebagai sudah dibaca
     */
    public function markAllRead()
    {
        $count = ErrorLog::markAllAsRead();

        return redirect()
            ->route('admin.error-logs.index')
            ->with('success', "{$count} error log ditandai sebagai sudah dibaca.");
    }
}
