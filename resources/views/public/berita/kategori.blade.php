@extends('layouts.public')

@section('title', 'Berita ' . $kategori->nama)

@section('meta_description', $kategori->deskripsi ?: 'Berita kategori ' . $kategori->nama . ' dari BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Breadcrumb --}}
    <x-breadcrumb :items="[
        ['label' => 'Berita', 'url' => route('berita.index')],
        ['label' => $kategori->nama]
    ]" />
    
    {{-- Category Header --}}
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-lg font-semibold mb-4 shadow-md"
             style="background-color: {{ $kategori->warna }}; color: white;">
            <span class="w-3 h-3 rounded-full bg-white/50"></span>
            {{ $kategori->nama }}
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Berita {{ $kategori->nama }}</h1>
        @if($kategori->deskripsi)
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ $kategori->deskripsi }}</p>
        @endif
    </div>
    
    {{-- Other Categories --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
        <div class="flex flex-wrap gap-2 justify-center">
            <a href="{{ route('berita.index') }}" 
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-200">
                Semua Berita
            </a>
            @foreach($kategoris as $kat)
                <a href="{{ route('berita.kategori', $kat->slug) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md"
                   style="{{ $kat->id == $kategori->id ? 'background-color: ' . $kat->warna . '; color: white; box-shadow: 0 4px 6px -1px ' . $kat->warna . '40;' : 'background-color: ' . $kat->warna . '15; color: ' . $kat->warna . '; border: 1px solid ' . $kat->warna . '30;' }}">
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $kat->id == $kategori->id ? 'white' : $kat->warna }};"></span>
                    {{ $kat->nama }}
                    <span class="text-xs opacity-75">({{ $kat->berita_count }})</span>
                </a>
            @endforeach
        </div>
    </div>
    
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
                    
                    {{-- Featured Badge --}}
                    @if($item->is_featured)
                        <div class="absolute top-3 left-3 z-10">
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Utama
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
            title="Belum ada berita"
            description="Belum ada berita di kategori {{ $kategori->nama }}."
            icon="search"
        />
    @endif
</div>
@endsection
