@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page_title', 'Kelola Berita')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Berita</h1>
            <p class="text-gray-600 mt-1">Kelola semua berita BUMNag Madani</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kategori-berita.index') }}" class="btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kategori
            </a>
            <a href="{{ route('admin.berita.create') }}" class="btn-primary flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Berita
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
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
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-yellow-600">{{ $totalDraft ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Draft</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-blue-600">{{ $totalScheduled ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Terjadwal</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-purple-600">{{ number_format($totalViews ?? 0) }}</p>
                <p class="text-xs text-gray-500 truncate">Total Views</p>
            </div>
        </div>
        
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-gray-600">{{ $totalArchived ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Arsip</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat mb-6">
        <form action="{{ route('admin.berita.index') }}" method="GET">
            <div class="flex flex-col gap-3">
                {{-- Search Input --}}
                <input type="text" name="cari" value="{{ request('cari') }}" 
                       placeholder="Cari judul berita..." 
                       class="form-input w-full">
                {{-- Filter Controls --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                    </select>
                    <select name="kategori" class="form-input">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->icon }} {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    <select name="archived" class="form-input">
                        <option value="">Aktif</option>
                        <option value="1" {{ request('archived') == '1' ? 'selected' : '' }}>Arsip</option>
                    </select>
                    <button type="submit" class="btn-primary justify-center">
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
    @if($berita->count() > 0)
        {{-- Table --}}
        <div class="bento-card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Berita</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Views</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($berita as $item)
                            <tr class="hover:bg-gray-50 transition-colors {{ $item->trashed() ? 'opacity-60 bg-gray-50' : '' }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->gambar)
                                            <img src="{{ $item->gambar_url }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0 hidden sm:block">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 items-center justify-center flex-shrink-0 hidden sm:flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-gray-900 line-clamp-1">{{ $item->judul }}</p>
                                                {{-- Featured/Pinned badges --}}
                                                @if($item->is_featured)
                                                    <span class="text-yellow-500" title="Berita Utama">⭐</span>
                                                @endif
                                                @if($item->is_pinned)
                                                    <span class="text-primary" title="Disematkan">📌</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500 line-clamp-1 mt-0.5">{{ Str::limit($item->ringkasan ?? strip_tags($item->konten), 40) }}</p>
                                            {{-- Mobile: Show badges inline --}}
                                            <div class="flex flex-wrap gap-2 mt-2 sm:hidden">
                                                @if($item->kategori)
                                                    <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full"
                                                          style="background-color: {{ $item->kategori->warna }}20; color: {{ $item->kategori->warna }};">
                                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $item->kategori->warna }};"></span>
                                                        {{ $item->kategori->nama }}
                                                    </span>
                                                @endif
                                                <span class="badge text-xs {{ $item->status === 'published' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $item->status === 'published' ? 'Published' : 'Draft' }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ number_format($item->views) }} views</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    @if($item->kategori)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full"
                                              style="background-color: {{ $item->kategori->warna }}15; color: {{ $item->kategori->warna }}; border: 1px solid {{ $item->kategori->warna }}30;">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $item->kategori->warna }};"></span>
                                            {{ $item->kategori->nama }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    @if($item->is_scheduled && $item->tanggal_publikasi && $item->tanggal_publikasi->isFuture())
                                        <span class="badge badge-info">
                                            🕐 Terjadwal
                                        </span>
                                    @else
                                        <span class="badge {{ $item->status === 'published' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $item->status === 'published' ? 'Published' : 'Draft' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-gray-600 hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($item->views) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 hidden lg:table-cell">
                                    <div class="text-sm">
                                        <p class="text-gray-900">{{ $item->created_at->format('d M Y') }}</p>
                                        <p class="text-gray-400 text-xs">{{ $item->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-1">
                                        @if($item->trashed())
                                            {{-- Restore & Force Delete for archived items --}}
                                            <form action="{{ route('admin.berita.restore', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Pulihkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.berita.force-delete', $item->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus berita ini secara permanen? Aksi ini tidak dapat dibatalkan!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Permanen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Toggle Featured --}}
                                            <form action="{{ route('admin.berita.toggle-featured', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2 rounded-lg transition-colors {{ $item->is_featured ? 'text-yellow-500 bg-yellow-50 hover:bg-yellow-100' : 'text-gray-400 hover:text-yellow-500 hover:bg-yellow-50' }}" 
                                                        title="{{ $item->is_featured ? 'Hapus dari Berita Utama' : 'Jadikan Berita Utama' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            {{-- Toggle Pinned --}}
                                            <form action="{{ route('admin.berita.toggle-pinned', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2 rounded-lg transition-colors {{ $item->is_pinned ? 'text-primary bg-primary/10 hover:bg-primary/20' : 'text-gray-400 hover:text-primary hover:bg-primary/10' }}" 
                                                        title="{{ $item->is_pinned ? 'Lepas Sematan' : 'Sematkan' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('berita.show', $item->slug) }}" target="_blank" 
                                               class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Lihat">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.berita.edit', $item) }}" 
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Yakin ingin mengarsipkan berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Arsipkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                    </svg>
                                                </button>
                                            </form>
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
            {{ $berita->links('components.pagination') }}
        </div>
    @else
        <x-empty-state 
            title="Belum ada berita"
            description="Mulai tambahkan berita untuk ditampilkan di website."
            icon="document"
            :actionRoute="route('admin.berita.create')"
            actionText="Tambah Berita"
        />
    @endif
@endsection
