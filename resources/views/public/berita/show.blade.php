@extends('layouts.public')

@section('title', $berita->meta_title ?: $berita->judul)

@section('meta_description', $berita->meta_description ?: $berita->ringkasan)

@section('meta_keywords', $berita->meta_keywords)

@push('meta')
    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $berita->meta_title ?: $berita->judul }}">
    <meta property="og:description" content="{{ $berita->meta_description ?: $berita->ringkasan }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($berita->gambar)
        <meta property="og:image" content="{{ $berita->gambar_url }}">
    @endif
    <meta property="article:published_time" content="{{ $berita->tanggal_publikasi?->toIso8601String() }}">
    @if($berita->kategori)
        <meta property="article:section" content="{{ $berita->kategori->nama }}">
    @endif
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $berita->meta_title ?: $berita->judul }}">
    <meta name="twitter:description" content="{{ $berita->meta_description ?: $berita->ringkasan }}">
    @if($berita->gambar)
        <meta name="twitter:image" content="{{ $berita->gambar_url }}">
    @endif
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="grid lg:grid-cols-4 gap-8">
        
        {{-- Main Content --}}
        <article class="lg:col-span-3">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="array_filter([
                ['label' => 'Berita', 'url' => route('berita.index')],
                $berita->kategori ? ['label' => $berita->kategori->nama, 'url' => route('berita.kategori', $berita->kategori->slug)] : null,
                ['label' => Str::limit($berita->judul, 50)]
            ])" class="mb-6" />
            
            {{-- Header --}}
            <header class="mb-8">
                {{-- Category Badge --}}
                @if($berita->kategori)
                    <a href="{{ route('berita.kategori', $berita->kategori->slug) }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg mb-4 hover:shadow-md transition-all"
                       style="background-color: {{ $berita->kategori->warna }}15; color: {{ $berita->kategori->warna }}; border: 1px solid {{ $berita->kategori->warna }}30;">
                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $berita->kategori->warna }};"></span>
                        {{ $berita->kategori->nama }}
                    </a>
                @endif
                
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $berita->judul }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $berita->tanggal_publikasi?->format('d F Y') }}
                    </span>
                    
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $berita->penulis?->name ?? 'Admin' }}
                    </span>
                    
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $berita->views }}x dilihat
                    </span>
                    
                    {{-- Featured/Pinned badges --}}
                    @if($berita->is_featured)
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Berita Utama
                        </span>
                    @endif
                </div>
            </header>
            
            {{-- Featured Image --}}
            @if($berita->gambar)
                <figure class="mb-8">
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-auto rounded-xl shadow-lg">
                </figure>
            @endif
            
            {{-- Content --}}
            <div class="prose-content text-gray-700 leading-relaxed mb-10">
                {!! $berita->konten !!}
            </div>
            
            {{-- Image Gallery --}}
            @if($berita->gambarGallery && $berita->gambarGallery->count() > 0)
                <div class="mb-10" x-data="{ lightbox: false, currentImage: 0 }">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Galeri Foto ({{ $berita->gambarGallery->count() }})
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($berita->gambarGallery as $index => $gambar)
                            <button @click="lightbox = true; currentImage = {{ $index }}" 
                                    class="relative group overflow-hidden rounded-lg aspect-square">
                                <img src="{{ $gambar->url }}" 
                                     alt="{{ $gambar->alt_text ?: $berita->judul }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    
                    {{-- Lightbox --}}
                    <div x-show="lightbox" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @keydown.escape.window="lightbox = false"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                         style="display: none;">
                        
                        {{-- Close Button --}}
                        <button @click="lightbox = false" class="absolute top-4 right-4 text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        {{-- Navigation --}}
                        <button @click="currentImage = (currentImage - 1 + {{ $berita->gambarGallery->count() }}) % {{ $berita->gambarGallery->count() }}" 
                                class="absolute left-4 text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        
                        <button @click="currentImage = (currentImage + 1) % {{ $berita->gambarGallery->count() }}" 
                                class="absolute right-4 text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        {{-- Image --}}
                        @foreach($berita->gambarGallery as $index => $gambar)
                            <div x-show="currentImage === {{ $index }}" class="text-center">
                                <img src="{{ $gambar->url }}" 
                                     alt="{{ $gambar->alt_text ?: $berita->judul }}" 
                                     class="max-h-[80vh] max-w-full object-contain mx-auto">
                                @if($gambar->caption)
                                    <p class="text-white mt-4 text-sm">{{ $gambar->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                        
                        {{-- Counter --}}
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm">
                            <span x-text="currentImage + 1"></span> / {{ $berita->gambarGallery->count() }}
                        </div>
                    </div>
                </div>
            @endif
            
            {{-- Share Buttons --}}
            <div class="border-t border-b border-gray-200 py-6 mb-10">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-gray-600 font-medium">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                       target="_blank" 
                       class="w-10 h-10 rounded-lg bg-sky-500 text-white flex items-center justify-center hover:bg-sky-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}" 
                       target="_blank" 
                       class="w-10 h-10 rounded-lg bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>
            
            {{-- Related News --}}
            @if($beritaTerkait->count() > 0)
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        @if($berita->kategori)
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium px-2.5 py-1 rounded-lg"
                                  style="background-color: {{ $berita->kategori->warna }}15; color: {{ $berita->kategori->warna }}; border: 1px solid {{ $berita->kategori->warna }}30;">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $berita->kategori->warna }};"></span>
                                {{ $berita->kategori->nama }}
                            </span>
                            Berita Lainnya
                        @else
                            Berita Lainnya
                        @endif
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($beritaTerkait as $item)
                            <article class="bento-card group p-4">
                                @if($item->gambar)
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-28 object-cover rounded-lg mb-3">
                                @else
                                    <div class="w-full h-28 bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($item->kategori)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full mb-2"
                                          style="background-color: {{ $item->kategori->warna }}20; color: {{ $item->kategori->warna }};">
                                        {{ $item->kategori->nama }}
                                    </span>
                                @endif
                                
                                <h3 class="font-semibold text-sm text-gray-900 group-hover:text-primary transition-colors line-clamp-2">
                                    <a href="{{ route('berita.show', $item->slug) }}">{{ $item->judul }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->tanggal_publikasi?->format('d M Y') }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
            
            {{-- Back Button --}}
            <div class="mt-10">
                <a href="{{ route('berita.index') }}" class="btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Berita
                </a>
            </div>
        </article>
        
        {{-- Sidebar --}}
        <aside class="lg:col-span-1 space-y-6">
            {{-- Kategori Berita --}}
            <div class="bento-card">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Kategori
                </h3>
                <div class="space-y-2">
                    @foreach($kategoris as $kat)
                        <a href="{{ route('berita.kategori', $kat->slug) }}" 
                           class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition {{ $berita->kategori && $berita->kategori->id == $kat->id ? 'bg-gray-50' : '' }}">
                            <span class="flex items-center gap-2">
                                @if($kat->icon)
                                    <span>{{ $kat->icon }}</span>
                                @endif
                                <span class="text-sm text-gray-700">{{ $kat->nama }}</span>
                            </span>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                  style="background-color: {{ $kat->warna }}20; color: {{ $kat->warna }};">
                                {{ $kat->berita_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
            
            {{-- Share Widget --}}
            <div class="bento-card">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Bagikan
                </h3>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="flex-1 py-2 rounded-lg bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                       target="_blank" 
                       class="flex-1 py-2 rounded-lg bg-sky-500 text-white flex items-center justify-center hover:bg-sky-600 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}" 
                       target="_blank" 
                       class="flex-1 py-2 rounded-lg bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
