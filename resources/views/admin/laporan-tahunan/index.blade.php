@extends('layouts.admin')

@section('title', 'Kelola Laporan Tahunan')
@section('page_title', 'Kelola Laporan Tahunan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Laporan Tahunan</h1>
            <p class="text-gray-600 mt-1">Kelola laporan tahunan BUMNag Madani</p>
        </div>
        <a href="{{ route('admin.laporan-tahunan.create') }}" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Laporan
        </a>
    </div>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-900">{{ $totalLaporan ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Total Laporan</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-green-600">{{ $totalPublished ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Published</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-amber-600">{{ $totalDraft ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Draft</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-purple-600">{{ number_format($totalDownloads ?? 0) }}</p>
                <p class="text-xs text-gray-500 truncate">Total Download</p>
            </div>
        </div>
        <a href="{{ route('admin.laporan-tahunan.index', ['archived' => '1']) }}" class="bento-card-flat flex items-center gap-3 hover:bg-gray-100 transition-colors">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-600">{{ $totalArchived ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Arsip</p>
            </div>
        </a>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat mb-6">
        <form action="{{ route('admin.laporan-tahunan.index') }}" method="GET">
            <div class="flex flex-col gap-3">
                {{-- Search Input --}}
                <input type="text" name="cari" value="{{ request('cari') }}" 
                       placeholder="Cari judul atau tahun laporan..." 
                       class="form-input w-full">
                {{-- Filter Controls --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" class="form-input sm:flex-1">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <select name="archived" class="form-input sm:flex-1">
                        <option value="">Aktif</option>
                        <option value="1" {{ request('archived') == '1' ? 'selected' : '' }}>Arsip</option>
                    </select>
                    <button type="submit" class="btn-primary justify-center sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Content --}}
    @if($laporanTahunan->count() > 0)
        {{-- Table --}}
        <div class="bento-card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Laporan</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Download</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($laporanTahunan as $laporan)
                            <tr class="hover:bg-gray-50 transition-colors {{ $laporan->trashed() ? 'bg-red-50' : '' }}">
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center justify-center w-16 h-10 bg-primary/10 text-primary font-bold rounded-lg">
                                        {{ $laporan->tahun }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="max-w-xs sm:max-w-md">
                                        <p class="font-semibold text-gray-900 line-clamp-1">{{ $laporan->judul }}</p>
                                        @if($laporan->deskripsi)
                                            <p class="text-sm text-gray-500 line-clamp-1 mt-0.5">{{ Str::limit($laporan->deskripsi, 50) }}</p>
                                        @endif
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ $laporan->file_size_formatted }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    <x-status-badge :status="$laporan->status" type="berita" />
                                </td>
                                <td class="px-4 py-4 text-center hidden md:table-cell">
                                    <span class="text-gray-600">{{ number_format($laporan->download_count) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-1">
                                        @if($laporan->trashed())
                                            {{-- Restore Button --}}
                                            <form action="{{ route('admin.laporan-tahunan.restore', $laporan->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Pulihkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Force Delete Button --}}
                                            <button type="button"
                                                    onclick="confirmAction({
                                                        title: 'Hapus Laporan Permanen',
                                                        message: 'Yakin ingin menghapus permanen laporan ini? File laporan dan cover juga akan dihapus. Aksi ini tidak dapat dibatalkan!',
                                                        actionUrl: '{{ route('admin.laporan-tahunan.force-delete', $laporan->id) }}',
                                                        method: 'DELETE',
                                                        type: 'danger',
                                                        confirmText: 'Hapus Permanen'
                                                    })"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Permanen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @else
                                            {{-- Download Button --}}
                                            <a href="{{ $laporan->file_url }}" target="_blank"
                                               class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Download">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.laporan-tahunan.edit', $laporan) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            {{-- Arsipkan Button --}}
                                            <button type="button"
                                                    onclick="confirmAction({
                                                        title: 'Arsipkan Laporan',
                                                        message: 'Yakin ingin mengarsipkan laporan ini? Laporan dapat dipulihkan dari arsip.',
                                                        actionUrl: '{{ route('admin.laporan-tahunan.destroy', $laporan) }}',
                                                        method: 'DELETE',
                                                        type: 'archive',
                                                        confirmText: 'Arsipkan'
                                                    })"
                                                    class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Arsipkan">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            </button>
                                            {{-- Hapus Permanen Button --}}
                                            <button type="button"
                                                    onclick="confirmAction({
                                                        title: 'Hapus Laporan Permanen',
                                                        message: 'Yakin ingin menghapus laporan ini secara permanen? File laporan dan cover juga akan dihapus. Aksi ini tidak dapat dibatalkan!',
                                                        actionUrl: '{{ route('admin.laporan-tahunan.force-delete', $laporan->id) }}',
                                                        method: 'DELETE',
                                                        type: 'danger',
                                                        confirmText: 'Hapus Permanen'
                                                    })"
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Permanen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination --}}
        <div class="mt-6">
            {{ $laporanTahunan->links('components.pagination') }}
        </div>
    @else
        <x-empty-state 
            title="Belum ada laporan tahunan"
            description="Mulai tambahkan laporan tahunan untuk ditampilkan di website."
            icon="document"
            :actionRoute="route('admin.laporan-tahunan.create')"
            actionText="Tambah Laporan"
        />
    @endif

    {{-- Modal Konfirmasi --}}
    <x-confirm-modal />
@endsection
