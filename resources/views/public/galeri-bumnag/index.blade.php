@extends('layouts.public')

@section('title', 'Galeri BUMNag Madani Lubuk Malako')

@section('meta_description', 'Galeri foto kegiatan dan dokumentasi BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 pattern-diagonal">
    
    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">📸 Galeri BUMNag Madani</h1>
        <p class="text-lg text-gray-600">Dokumentasi kegiatan dan momen BUMNag Madani Lubuk Malako</p>
    </div>
    
    {{-- Filters --}}
    <div class="mb-8 flex flex-col sm:flex-row gap-4 justify-center items-center">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <input 
                type="text" 
                name="cari" 
                value="{{ request('cari') }}" 
                placeholder="🔍 Cari foto..."
                class="form-input w-full sm:w-64"
            >
            <select name="tahun" class="form-input w-full sm:w-40">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary w-full sm:w-auto">
                Filter
            </button>
            @if(request('cari') || request('tahun'))
                <a href="{{ route('galeri-bumnag.index') }}" class="btn-outline w-full sm:w-auto">
                    Reset
                </a>
            @endif
        </form>
    </div>
    
    {{-- Gallery Grid --}}
    @if($galeri->count() > 0)
        {{-- Alpine scope: kelola state lightbox (gambar aktif, navigasi) --}}
        <div x-data="{
                items: {{ Js::from($galeri->map(fn($item) => ['foto_url' => $item->foto_url, 'judul' => $item->judul, 'deskripsi' => $item->deskripsi ?? '', 'tanggal' => $item->created_at->format('d M Y')])->values()) }},
                currentIndex: 0,
                openLightbox(index) {
                    this.currentIndex = index;
                    $dispatch('open-modal-lightbox-galeri');
                },
                prev() { this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length; },
                next() { this.currentIndex = (this.currentIndex + 1) % this.items.length; },
                get current() { return this.items[this.currentIndex] || {}; }
             }">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($galeri as $item)
                    <div class="group bento-card overflow-hidden cursor-pointer hover:shadow-xl transition-shadow duration-300"
                         @click="openLightbox({{ $loop->index }})">
                        {{-- Image with Always-Visible Gradient Overlay --}}
                        <div class="relative aspect-[4/3] overflow-hidden rounded-t-lg bg-gray-100">
                            <img 
                                src="{{ $item->foto_url }}" 
                                alt="{{ $item->judul }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                loading="lazy"
                            >
                            
                            {{-- Permanent Gradient Overlay (always visible) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="font-bold text-white mb-1 line-clamp-2 drop-shadow-lg">{{ $item->judul }}</h3>
                                    @if($item->deskripsi)
                                        <p class="text-sm text-white/90 line-clamp-2 drop-shadow-md">{{ $item->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Zoom Icon (only on hover) --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/20">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Info Card Footer --}}
                        <div class="p-4 bg-white rounded-b-lg">
                            <h3 class="font-bold text-gray-900 mb-1 line-clamp-2 text-sm">{{ $item->judul }}</h3>
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $galeri->links() }}
            </div>

            {{-- Lightbox Modal (Alpine x-modal) --}}
            <x-modal name="lightbox-galeri" title="" maxWidth="2xl">
                {{-- Body slot: Gambar + Navigasi + Info --}}
                <div class="relative -mx-6 -mt-4">
                    {{-- Gambar Utama --}}
                    <div class="relative bg-black rounded-t-lg overflow-hidden">
                        <img :src="current.foto_url" :alt="current.judul"
                             class="w-full max-h-[60vh] object-contain mx-auto block">

                        {{-- Tombol Prev --}}
                        <button @click.stop="prev()"
                                class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-2 transition-colors"
                                aria-label="Foto sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        {{-- Tombol Next --}}
                        <button @click.stop="next()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/80 text-white rounded-full p-2 transition-colors"
                                aria-label="Foto berikutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Counter --}}
                        <span class="absolute bottom-3 right-3 bg-black/60 text-white text-xs px-2 py-1 rounded-full"
                              x-text="`${currentIndex + 1} / ${items.length}`"></span>
                    </div>

                    {{-- Info --}}
                    <div class="px-6 py-4">
                        <h3 class="font-bold text-gray-900 text-lg mb-1" x-text="current.judul"></h3>
                        <p class="text-gray-600 text-sm leading-relaxed" x-show="current.deskripsi" x-text="current.deskripsi"></p>
                        <p class="text-xs text-gray-400 mt-2" x-text="current.tanggal"></p>
                    </div>
                </div>

                {{-- Footer slot: Navigasi keyboard hint --}}
                <x-slot name="footer">
                    <div class="flex items-center gap-4 text-xs text-gray-400 mr-auto">
                        <span>← → Navigasi</span>
                        <span>ESC Tutup</span>
                    </div>
                    <button @click="$dispatch('close-modal-lightbox-galeri')" class="btn-outline text-sm px-4 py-2">
                        Tutup
                    </button>
                </x-slot>
            </x-modal>

            {{-- Keyboard navigation untuk lightbox --}}
            <div @keydown.arrow-left.window="prev()"
                 @keydown.arrow-right.window="next()">
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Foto Tidak Ditemukan</h3>
            <p class="text-gray-500">Coba ubah filter pencarian Anda</p>
        </div>
    @endif
</div>

@endsection
