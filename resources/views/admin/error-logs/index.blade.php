@extends('layouts.admin')

@section('title', 'Error Logs')
@section('page_title', 'Error Logs')

@section('header')
    @include('components.page-header', [
        'title' => 'Error Logs',
        'subtitle' => 'Monitor dan debug error aplikasi di production',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Error Logs'],
        ]
    ])
@endsection

@section('content')
    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                    <p class="text-xs text-gray-500">Total Error</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($stats['belum_dibaca']) }}</p>
                    <p class="text-xs text-gray-500">Belum Dibaca</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['hari_ini']) }}</p>
                    <p class="text-xs text-gray-500">Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['minggu_ini']) }}</p>
                    <p class="text-xs text-gray-500">7 Hari Terakhir</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Actions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-100">
            <form action="{{ route('admin.error-logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                {{-- Pencarian --}}
                <div>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari error..."
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                </div>

                {{-- Filter Level --}}
                <div>
                    <select name="level" class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        <option value="">Semua Level</option>
                        @foreach(['emergency', 'alert', 'critical', 'error', 'warning'] as $level)
                            <option value="{{ $level }}" {{ request('level') === $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dari Tanggal --}}
                <div>
                    <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" 
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary" placeholder="Dari tanggal">
                </div>

                {{-- Sampai Tanggal --}}
                <div>
                    <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary" placeholder="Sampai tanggal">
                </div>

                {{-- Tombol --}}
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.error-logs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Bulk Actions --}}
        <div class="p-4 flex flex-wrap items-center justify-between gap-3 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">{{ $errorLogs->total() }} error ditemukan</span>
                @if(request()->hasAny(['cari', 'level', 'dari_tanggal', 'sampai_tanggal']))
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Difilter</span>
                @endif
            </div>
            <div class="flex gap-2">
                @if($stats['belum_dibaca'] > 0)
                    <form action="{{ route('admin.error-logs.mark-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1" 
                            onclick="return confirm('Tandai semua error sebagai sudah dibaca?')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
                @if($stats['total'] > 0)
                    <form action="{{ route('admin.error-logs.destroy-all') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1"
                            onclick="return confirm('PERHATIAN: Semua error log akan dihapus secara permanen. Lanjutkan?')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Semua
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Tabel Error Logs --}}
        @if($errorLogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Level</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pesan Error</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">URL</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($errorLogs as $log)
                            <tr class="hover:bg-gray-50 transition {{ !$log->is_read ? 'bg-red-50/30' : '' }}">
                                {{-- Status --}}
                                <td class="px-4 py-3">
                                    @if(!$log->is_read)
                                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full inline-block" title="Belum dibaca"></span>
                                    @else
                                        <span class="w-2.5 h-2.5 bg-gray-300 rounded-full inline-block" title="Sudah dibaca"></span>
                                    @endif
                                </td>

                                {{-- Level Badge --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $log->level_color }}">
                                        {{ strtoupper($log->level) }}
                                    </span>
                                </td>

                                {{-- Pesan Error --}}
                                <td class="px-4 py-3 max-w-xs">
                                    <a href="{{ route('admin.error-logs.show', $log) }}" class="block hover:text-primary transition">
                                        <p class="text-sm font-medium text-gray-900 truncate {{ !$log->is_read ? 'font-bold' : '' }}">
                                            {{ Str::limit($log->message, 80) }}
                                        </p>
                                        @if($log->exception_class)
                                            <p class="text-xs text-gray-500 mt-0.5 font-mono truncate">
                                                {{ class_basename($log->exception_class) }}
                                            </p>
                                        @endif
                                    </a>
                                </td>

                                {{-- URL --}}
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    @if($log->url)
                                        <span class="text-xs text-gray-500 font-mono truncate block max-w-[200px]" title="{{ $log->url }}">
                                            {{ $log->method }} {{ parse_url($log->url, PHP_URL_PATH) ?? $log->url }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>

                                {{-- Waktu --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-500" title="{{ $log->created_at->format('d/m/Y H:i:s') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.error-logs.show', $log) }}" 
                                           class="p-1.5 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition" 
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.error-logs.destroy', $log) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition"
                                                title="Hapus" onclick="return confirm('Hapus error log ini?')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-4 border-t border-gray-100">
                {{ $errorLogs->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                @include('components.empty-state', [
                    'icon' => 'document',
                    'title' => 'Tidak Ada Error',
                    'description' => 'Belum ada error yang tercatat. Sistem berjalan dengan baik!',
                ])
            </div>
        @endif
    </div>

    {{-- Info Card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-700">
                <p class="font-semibold mb-1">Tentang Error Logs</p>
                <ul class="list-disc ml-4 space-y-0.5 text-blue-600">
                    <li>Error logs otomatis tersimpan ke database saat terjadi error level <strong>warning</strong> ke atas</li>
                    <li>Data sensitif (password, token) otomatis disembunyikan untuk keamanan</li>
                    <li>Log otomatis dihapus setelah <strong>30 hari</strong> untuk menjaga performa database</li>
                    <li>File log tetap tersimpan di server sebagai backup (<code>storage/logs/</code>)</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
