@extends('layouts.public')

@section('title', $kategoriAktif ? 'Berita ' . $kategoriAktif->nama : 'Berita')

@section('meta_description', 'Berita dan informasi terbaru dari BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
            @if($kategoriAktif)
                Berita {{ $kategoriAktif->nama }}
            @else
                Berita
            @endif
        </h1>
        <p class="text-gray-600 text-lg">Kabar dan informasi terbaru dari BUMNag Madani</p>
    </div>
    
    {{-- Featured News --}}
    @if(!request('cari') && !$kategoriAktif && $beritaFeatured->count() > 0)
        <div class="mb-12">
            <div class="flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-900">Berita Utama</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($beritaFeatured as $featured)
                    <article class="bento-card group border-2 border-yellow-200 bg-gradient-to-br from-yellow-50 to-white">
                        @if($featured->gambar)
                            <img src="{{ $featured->gambar_url }}" alt="{{ $featured->judul }}" class="w-full h-40 object-cover rounded-lg mb-4">
                        @endif
                        
                        <div class="flex items-center gap-2 mb-2">
                            @if($featured->kategori)
                                <a href="{{ route('berita.kategori', $featured->kategori->slug) }}" 
                                   class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full"
                                   style="background-color: {{ $featured->kategori->warna }}15; color: {{ $featured->kategori->warna }}; border: 1px solid {{ $featured->kategori->warna }}30;">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $featured->kategori->warna }};"></span>
                                    {{ $featured->kategori->nama }}
                                </a>
                            @endif
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Utama
                            </span>
                        </div>
                        
                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-2">
                            <a href="{{ route('berita.show', $featured->slug) }}">{{ $featured->judul }}</a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $featured->ringkasan }}</p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $featured->tanggal_publikasi?->format('d M Y') }}</span>
                            <span>{{ $featured->views }}x dilihat</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
    
    {{-- Search & Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
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
    
    {{-- News Grid --}}
    @if($berita->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($berita as $item)
                <article class="bento-card group {{ $item->is_pinned ? 'ring-2 ring-primary ring-offset-2' : '' }}">
                    {{-- Pinned Badge --}}
                    @if($item->is_pinned)
                        <div class="absolute top-3 right-3 z-10">
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-primary text-white shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                Disematkan
                            </span>
                        </div>
                    @endif
                    
                    @if($item->gambar)
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    
                    {{-- Category Badge --}}
                    <div class="flex items-center gap-2 mb-2">
                        @if($item->kategori)
                            <a href="{{ route('berita.kategori', $item->kategori->slug) }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full hover:opacity-80 transition"
                               style="background-color: {{ $item->kategori->warna }}15; color: {{ $item->kategori->warna }}; border: 1px solid {{ $item->kategori->warna }}30;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $item->kategori->warna }};"></span>
                                {{ $item->kategori->nama }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $item->tanggal_publikasi?->format('d M Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $item->views }}x
                        </span>
                    </div>
                    
                    <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-2">
                        <a href="{{ route('berita.show', $item->slug) }}">{{ $item->judul }}</a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $item->ringkasan }}</p>
                    
                    <a href="{{ route('berita.show', $item->slug) }}" class="inline-flex items-center text-primary font-medium text-sm hover:underline">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </article>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="mt-10">
            {{ $berita->links('components.pagination') }}
        </div>
    @else
        <x-empty-state 
            :title="request('cari') ? 'Tidak ada hasil' : 'Belum ada berita'"
            :description="request('cari') ? 'Tidak ditemukan berita yang sesuai dengan kata kunci \"' . request('cari') . '\"' : 'Berita terbaru akan tampil di sini.'"
            icon="search"
        />
    @endif
</div>
@endsection
