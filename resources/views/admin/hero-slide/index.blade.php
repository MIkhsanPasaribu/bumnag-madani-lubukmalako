@extends('layouts.admin')

@section('title', 'Kelola Hero Slide')
@section('page_title', 'Kelola Hero Slide')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Hero Slide</h1>
            <p class="text-gray-600 mt-1">Atur slide yang tampil di hero section halaman beranda</p>
        </div>
        <a href="{{ route('admin.hero-slide.create') }}" class="btn-primary flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Slide
        </a>
    </div>
@endsection

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bento-card-flat flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-blue-600">{{ $totalSlides ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Total Slide</p>
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
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-bold text-yellow-600">{{ $totalTidakAktif ?? 0 }}</p>
                <p class="text-xs text-gray-500 truncate">Tidak Aktif</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat mb-6">
        <form action="{{ route('admin.hero-slide.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul slide..." 
                       class="form-input flex-1">
                <select name="status" class="form-input w-full sm:w-40">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <button type="submit" class="btn-primary justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- Content --}}
    @if($heroSlides->count() > 0)
        {{-- Alpine scope untuk preview modal --}}
        <div x-data="{
                previewSlide: { media_url: '', judul: '', subjudul: '', is_video: false, status: '' },
                openPreview(media_url, judul, subjudul, is_video, status) {
                    this.previewSlide = { media_url, judul, subjudul, is_video, status };
                    $dispatch('open-modal-preview-hero-slide');
                }
             }">

        {{-- Table --}}
        <div class="bento-card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slide</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Media</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($heroSlides as $slide)
                            <tr class="hover:bg-gray-50 transition-colors {{ $slide->status === 'tidak_aktif' ? 'opacity-60 bg-gray-50' : '' }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Media Thumbnail --}}
                                        <div class="w-16 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 hidden sm:block">
                                            @if($slide->is_video)
                                                <video src="{{ $slide->media_url }}" class="w-full h-full object-cover" muted></video>
                                            @else
                                                <img src="{{ $slide->media_url }}" alt="{{ $slide->judul }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 line-clamp-1">{{ $slide->judul }}</p>
                                            @if($slide->subjudul)
                                                <p class="text-sm text-gray-500 line-clamp-1 mt-0.5">{{ Str::limit($slide->subjudul, 50) }}</p>
                                            @endif
                                            {{-- Mobile badges --}}
                                            <div class="flex flex-wrap gap-2 mt-2 sm:hidden">
                                                <span class="badge text-xs {{ $slide->status === 'aktif' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $slide->status_label }}
                                                </span>
                                                <span class="text-xs text-gray-500">Urutan: {{ $slide->urutan }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                        @if($slide->is_video)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Video
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Gambar
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center text-gray-600 hidden sm:table-cell">
                                    {{ $slide->urutan }}
                                </td>
                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                    <span class="badge {{ $slide->status === 'aktif' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $slide->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-1">
                                        {{-- Preview --}}
                                        <button type="button"
                                                @click="openPreview(
                                                    '{{ addslashes($slide->media_url) }}',
                                                    '{{ addslashes($slide->judul) }}',
                                                    '{{ addslashes($slide->subjudul ?? '') }}',
                                                    {{ $slide->is_video ? 'true' : 'false' }},
                                                    '{{ $slide->status_label }}'
                                                )"
                                                class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Preview">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        {{-- Toggle Status --}}
                                        <form action="{{ route('admin.hero-slide.toggle-status', $slide) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-2 rounded-lg transition-colors {{ $slide->status === 'aktif' ? 'text-yellow-500 bg-yellow-50 hover:bg-yellow-100' : 'text-green-500 bg-green-50 hover:bg-green-100' }}" 
                                                    title="{{ $slide->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if($slide->status === 'aktif')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.hero-slide.edit', $slide) }}" 
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Delete --}}
                                        <button type="button"
                                                onclick="confirmAction({
                                                    title: 'Hapus Hero Slide',
                                                    message: 'Yakin ingin menghapus slide ini? File media juga akan dihapus. Aksi ini tidak dapat dibatalkan!',
                                                    actionUrl: '{{ route('admin.hero-slide.destroy', $slide) }}',
                                                    method: 'DELETE',
                                                    type: 'danger'
                                                })"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
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
            {{ $heroSlides->links('components.pagination') }}
        </div>

        {{-- Preview Modal --}}
        <x-modal name="preview-hero-slide" title="Preview Slide" maxWidth="2xl">
            <div class="-mx-6 -mt-4">
                {{-- Media --}}
                <div class="bg-gray-900 rounded-t-lg overflow-hidden">
                    <template x-if="previewSlide.is_video">
                        <video :src="previewSlide.media_url"
                               class="w-full max-h-[55vh] object-contain mx-auto block"
                               controls muted autoplay loop></video>
                    </template>
                    <template x-if="!previewSlide.is_video">
                        <img :src="previewSlide.media_url" :alt="previewSlide.judul"
                             class="w-full max-h-[55vh] object-contain mx-auto block">
                    </template>
                </div>
                {{-- Info --}}
                <div class="px-6 py-4 space-y-1">
                    <h3 class="font-bold text-gray-900 text-lg" x-text="previewSlide.judul"></h3>
                    <p class="text-gray-600 text-sm" x-show="previewSlide.subjudul" x-text="previewSlide.subjudul"></p>
                    <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full mt-1"
                          :class="previewSlide.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
                          x-text="previewSlide.status"></span>
                </div>
            </div>
            <x-slot name="footer">
                <button @click="$dispatch('close-modal-preview-hero-slide')" class="btn-outline text-sm px-4 py-2">
                    Tutup
                </button>
            </x-slot>
        </x-modal>

        </div>{{-- end Alpine scope --}}
    @else
        <x-empty-state 
            title="Belum ada hero slide"
            description="Tambahkan slide gambar atau video untuk ditampilkan di hero section halaman beranda."
            icon="film"
            :actionRoute="route('admin.hero-slide.create')"
            actionText="Tambah Slide"
        />
    @endif

    {{-- Modal Konfirmasi --}}
    <x-confirm-modal />
@endsection
