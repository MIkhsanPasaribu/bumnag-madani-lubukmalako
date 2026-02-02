@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page_title', 'Kelola Pengumuman')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Pengumuman</h1>
            <p class="text-gray-600 mt-1">Kelola semua pengumuman BUMNag Madani</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengumuman
        </a>
    </div>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-900">{{ $pengumuman->total() }}</p>
                <p class="text-xs text-gray-500 truncate">Total</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-green-600">{{ $totalAktif ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Aktif</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-amber-600">{{ $totalPrioritasTinggi ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Prioritas Tinggi</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-600">{{ $totalTidakAktif ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Tidak Aktif</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat mb-6">
        <form action="{{ route('admin.pengumuman.index') }}" method="GET">
            <div class="flex flex-col gap-3">
                {{-- Search Input --}}
                <input type="text" name="cari" value="{{ request('cari') }}" 
                       placeholder="Cari judul pengumuman..." 
                       class="form-input w-full">
                {{-- Filter Controls --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" class="form-input sm:flex-1">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <select name="prioritas" class="form-input sm:flex-1">
                        <option value="">Semua Prioritas</option>
                        <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
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
    @if($pengumuman->count() > 0)
        {{-- Table --}}
        <div class="bento-card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengumuman</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Prioritas</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Periode</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pengumuman as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="max-w-xs sm:max-w-md">
                                        <p class="font-semibold text-gray-900 line-clamp-1">{{ $item->judul }}</p>
                                        <p class="text-sm text-gray-500 line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($item->konten), 50) }}</p>
                                        {{-- Mobile: Show badges inline --}}
                                        <div class="flex flex-wrap gap-2 mt-2 sm:hidden">
                                            <x-prioritas-badge :prioritas="$item->prioritas" size="sm" />
                                            <x-status-badge :status="$item->status" type="pengumuman" />
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    <x-prioritas-badge :prioritas="$item->prioritas" />
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    <x-status-badge :status="$item->status" type="pengumuman" />
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <div class="text-sm">
                                        <p class="text-gray-900">{{ $item->tanggal_mulai->format('d M Y') }}</p>
                                        @if($item->tanggal_berakhir)
                                            <p class="text-gray-400 text-xs">s/d {{ $item->tanggal_berakhir->format('d M Y') }}</p>
                                        @else
                                            <p class="text-gray-400 text-xs">Tanpa batas</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-1">
                                        <a href="{{ route('pengumuman.show', $item->slug) }}" target="_blank" 
                                           class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Lihat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.pengumuman.edit', $item) }}" 
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
        </div>
        
        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pengumuman->links('components.pagination') }}
        </div>
    @else
        <x-empty-state 
            title="Belum ada pengumuman"
            description="Mulai tambahkan pengumuman untuk ditampilkan di website."
            icon="document"
            :actionRoute="route('admin.pengumuman.create')"
            actionText="Tambah Pengumuman"
        />
    @endif
@endsection
