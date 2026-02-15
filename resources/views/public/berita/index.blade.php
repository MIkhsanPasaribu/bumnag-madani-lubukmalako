@extends('layouts.public')

@section('title', $kategoriAktif ? 'Berita ' . $kategoriAktif->nama : 'Berita')

@section('meta_description', 'Berita dan informasi terbaru dari BUMNag Madani Lubuk Malako')

@section('content')
<div class="pattern-leaf">

    {{-- Hero Header --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="berita-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="1.5" fill="white"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#berita-pattern)"/>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 relative z-10">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3">
                    @if($kategoriAktif)
                        Berita {{ $kategoriAktif->nama }}
                    @else
                        📰 Berita & Informasi
                    @endif
                </h1>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">Kabar dan informasi terbaru dari BUMNag Madani Lubuk Malako</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        {{-- Featured News — Full-width Hero Card --}}
        @if(!request('cari') && !$kategoriAktif && $beritaFeatured->count() > 0)
            <div class="mb-12">
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <h2 class="text-xl font-bold text-gray-900">Berita Utama</h2>
                </div>
                
                {{-- First featured as hero, rest as cards --}}
                @php $firstFeatured = $beritaFeatured->first(); $restFeatured = $beritaFeatured->skip(1); @endphp
                
                <div class="grid lg:grid-cols-2 gap-6">
                    {{-- Main Featured --}}
                    <a href="{{ route('berita.show', $firstFeatured->slug) }}" class="block group">
                        <article class="relative rounded-2xl overflow-hidden h-72 lg:h-full min-h-[280px] shadow-lg">
                            @if($firstFeatured->gambar)
                                <img src="{{ $firstFeatured->gambar_url }}" alt="{{ $firstFeatured->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-primary/30 to-primary-dark/50"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                            
                            <div class="absolute top-4 left-4 flex items-center gap-2">
                                @if($firstFeatured->kategori)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm"
                                          style="color: {{ $firstFeatured->kategori->warna }};">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $firstFeatured->kategori->warna }};"></span>
                                        {{ $firstFeatured->kategori->nama }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-400 text-yellow-900">
                                    ⭐ Utama
                                </span>
                            </div>
                            
                            <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                                <h3 class="font-bold text-white text-xl md:text-2xl leading-snug line-clamp-2 mb-2 group-hover:text-primary-light transition-colors" style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                                    {{ $firstFeatured->judul }}
                                </h3>
                                <p class="text-white/80 text-sm line-clamp-2 mb-3 hidden md:block">{{ $firstFeatured->ringkasan }}</p>
                                <div class="flex items-center gap-3 text-xs text-white/70">
                                    <span>{{ ($firstFeatured->tanggal_kegiatan ?? $firstFeatured->tanggal_publikasi)?->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span>{{ $firstFeatured->views }}x dilihat</span>
                                </div>
                            </div>
                        </article>
                    </a>
                    
                    {{-- Side Featured --}}
                    @if($restFeatured->count() > 0)
                    <div class="grid gap-4">
                        @foreach($restFeatured as $featured)
                        <a href="{{ route('berita.show', $featured->slug) }}" class="block group">
                            <article class="relative rounded-xl overflow-hidden h-32 sm:h-36 shadow-md hover:shadow-lg transition-shadow">
                                @if($featured->gambar)
                                    <img src="{{ $featured->gambar_url }}" alt="{{ $featured->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/40"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
                                
                                <div class="absolute inset-0 p-4 flex flex-col justify-center">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        @if($featured->kategori)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-white/80 backdrop-blur-sm"
                                                  style="color: {{ $featured->kategori->warna }};">
                                                {{ $featured->kategori->nama }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-white text-sm sm:text-base leading-snug line-clamp-2 group-hover:text-primary-light transition-colors max-w-md" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                                        {{ $featured->judul }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-xs text-white/70 mt-1.5">
                                        <span>{{ ($featured->tanggal_kegiatan ?? $featured->tanggal_publikasi)?->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $featured->views }}x dilihat</span>
                                    </div>
                                </div>
                            </article>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        @endif
        
        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                {{-- Category Filter --}}
                <div class="w-full lg:w-auto">
                    <p class="text-sm font-medium text-gray-500 mb-3">Filter Kategori</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('berita.index') }}" 
                           class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ !$kategoriAktif && !request('kategori') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Semua
                        </a>
                        @foreach($kategoris as $kat)
                            <a href="{{ route('berita.index', ['kategori' => $kat->slug]) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md"
                               style="{{ ($kategoriAktif && $kategoriAktif->id == $kat->id) ? 'background-color: ' . $kat->warna . '; color: white; box-shadow: 0 4px 6px -1px ' . $kat->warna . '40;' : 'background-color: ' . $kat->warna . '15; color: ' . $kat->warna . '; border: 1px solid ' . $kat->warna . '30;' }}">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ ($kategoriAktif && $kategoriAktif->id == $kat->id) ? 'white' : $kat->warna }};"></span>
                                {{ $kat->nama }}
                                <span class="text-xs opacity-75 bg-white/20 px-1.5 py-0.5 rounded">({{ $kat->berita_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            
                {{-- Search --}}
                <div class="w-full lg:w-auto">
                    <p class="text-sm font-medium text-gray-500 mb-3 hidden lg:block">Pencarian</p>
                    <form action="{{ route('berita.index') }}" method="GET" class="relative">
                        @if($kategoriAktif)
                            <input type="hidden" name="kategori" value="{{ $kategoriAktif->slug }}">
                        @endif
                        <input type="text" 
                               name="cari" 
                               value="{{ request('cari') }}"
                               placeholder="Cari berita..." 
                               class="form-input pl-10 pr-10 w-full lg:w-72 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        @if(request('cari'))
                            <a href="{{ route('berita.index', $kategoriAktif ? ['kategori' => $kategoriAktif->slug] : []) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        {{-- Search Info --}}
        @if(request('cari'))
            <p class="text-sm text-gray-500 text-center mb-6">
                Menampilkan hasil pencarian untuk: <strong>"{{ request('cari') }}"</strong>
                @if($kategoriAktif)
                    di kategori <strong>{{ $kategoriAktif->nama }}</strong>
                @endif
            </p>
        @endif
        
        {{-- News Grid — Image Overlay Cards --}}
        @if($berita->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($berita as $item)
                    <a href="{{ route('berita.show', $item->slug) }}" class="block group">
                        <article class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 h-72 {{ $item->is_pinned ? 'ring-2 ring-primary ring-offset-2' : '' }}">
                            {{-- Background Image --}}
                            @if($item->gambar)
                                <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                            
                            {{-- Top Badges --}}
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    @if($item->kategori)
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm"
                                              style="color: {{ $item->kategori->warna }};">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $item->kategori->warna }};"></span>
                                            {{ $item->kategori->nama }}
                                        </span>
                                    @endif
                                </div>
                                @if($item->is_pinned)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-primary text-white shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                        </svg>
                                        Pinned
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Content at Bottom --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="font-bold text-white text-sm leading-snug line-clamp-2 mb-2 group-hover:text-primary-light transition-colors" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                                    {{ $item->judul }}
                                </h3>
                                <div class="flex items-center gap-2 text-xs text-white/75">
                                    <span>{{ ($item->tanggal_kegiatan ?? $item->tanggal_publikasi)?->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span>{{ $item->views }}x dilihat</span>
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
            
            {{-- Pagination --}}
            <div class="mt-10">
                {{ $berita->links('components.pagination') }}
            </div>
        @else
            <x-empty-state 
                :title="request('cari') ? 'Tidak ada hasil' : 'Belum ada berita'"
                :description="request('cari') ? 'Tidak ditemukan berita yang sesuai dengan kata kunci &quot;' . request('cari') . '&quot;' : 'Berita terbaru akan tampil di sini.'"
                icon="search"
            />
        @endif
    </div>
</div>
@endsection
