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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($galeri as $item)
                <div class="group bento-card overflow-hidden cursor-pointer hover:shadow-xl transition-shadow duration-300" onclick="openLightbox({{ $loop->index }})">
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

{{-- Lightbox Modal --}}
<div 
    id="lightbox" 
    class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center p-4"
    onclick="if(event.target.id === 'lightbox') closeLightbox()"
>
    {{-- Close Button --}}
    <button 
        onclick="event.stopPropagation(); closeLightbox()"
        class="absolute top-4 right-4 text-white/80 hover:text-white transition z-20 bg-black/50 rounded-full p-2 backdrop-blur-sm"
        aria-label="Close"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    
    {{-- Previous Button --}}
    <button 
        onclick="event.stopPropagation(); prevImage()"
        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white transition z-20 bg-black/50 rounded-full p-2 backdrop-blur-sm"
        aria-label="Previous"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    
    {{-- Next Button --}}
    <button 
        onclick="event.stopPropagation(); nextImage()"
        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white transition z-20 bg-black/50 rounded-full p-2 backdrop-blur-sm"
        aria-label="Next"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
    
    {{-- Content Container --}}
    <div class="max-w-6xl w-full mx-auto" onclick="event.stopPropagation()">
        {{-- Image --}}
        <div class="relative">
            <img 
                id="lightbox-image" 
                src="" 
                alt=""
                class="w-full h-auto max-h-[75vh] object-contain rounded-lg shadow-2xl mx-auto"
            >
            
            {{-- Loading Spinner --}}
            <div id="lightbox-loading" class="absolute inset-0 flex items-center justify-center hidden">
                <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
        
        {{-- Info --}}
        <div class="mt-6 text-center px-4">
            <h3 id="lightbox-title" class="text-2xl font-bold text-white mb-3 drop-shadow-lg"></h3>
            <p id="lightbox-description" class="text-base text-gray-200 max-w-3xl mx-auto leading-relaxed"></p>
            <p id="lightbox-date" class="text-sm text-gray-400 mt-3"></p>
            <div id="lightbox-counter" class="text-xs text-gray-500 mt-2"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Get gallery data from Laravel  
    const galeriData = {!! json_encode($galeri->map(function($item) {
        return [
            'foto_url' => $item->foto_url,
            'judul' => $item->judul,
            'deskripsi' => $item->deskripsi ?? '',
            'tanggal' => $item->created_at->format('d M Y')
        ];
    })->values()) !!};
    
    let currentIndex = 0;

    function openLightbox(index) {
        if (!galeriData || galeriData.length === 0) {
            console.error('No gallery data available');
            return;
        }
        
        currentIndex = index;
        updateLightbox();
        
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + galeriData.length) % galeriData.length;
        updateLightbox();
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % galeriData.length;
        updateLightbox();
    }

    function updateLightbox() {
        if (!galeriData[currentIndex]) {
            console.error('Invalid index:', currentIndex);
            return;
        }
        
        const item = galeriData[currentIndex];
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxLoading = document.getElementById('lightbox-loading');
        
        // Show loading spinner
        lightboxLoading.classList.remove('hidden');
        
        // Update image with loading handler
        lightboxImage.onload = function() {
            lightboxLoading.classList.add('hidden');
        };
        
        lightboxImage.onerror = function() {
            lightboxLoading.classList.add('hidden');
            console.error('Failed to load image:', item.foto_url);
        };
        
        lightboxImage.src = item.foto_url;
        lightboxImage.alt = item.judul;
        
        // Update text content
        document.getElementById('lightbox-title').textContent = item.judul || 'Tanpa Judul';
        document.getElementById('lightbox-description').textContent = item.deskripsi || '';
        document.getElementById('lightbox-date').textContent = item.tanggal || '';
        document.getElementById('lightbox-counter').textContent = `${currentIndex + 1} / ${galeriData.length}`;
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevImage();
            }
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextImage();
            }
            if (e.key === 'Escape') {
                e.preventDefault();
                closeLightbox();
            }
        }
    });
    
    // Prevent background scrolling when lightbox is open
    window.addEventListener('keydown', (e) => {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox.classList.contains('hidden') && (e.key === 'ArrowUp' || e.key === 'ArrowDown' || e.key === ' ')) {
            e.preventDefault();
        }
    });
</script>
@endpush
@endsection
