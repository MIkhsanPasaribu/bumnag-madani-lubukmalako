@extends('layouts.public')

@section('title', 'Berita')

@section('meta_description', 'Berita dan informasi terbaru dari BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Berita</h1>
        <p class="text-gray-600 text-lg">Kabar dan informasi terbaru dari BUMNag Madani</p>
    </div>
    
    {{-- Search --}}
    <div class="max-w-xl mx-auto mb-10">
        <form action="{{ route('berita.index') }}" method="GET" class="relative">
            <input type="text" 
                   name="cari" 
                   value="{{ request('cari') }}"
                   placeholder="Cari berita..." 
                   class="form-input pl-12 pr-4 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if(request('cari'))
                <a href="{{ route('berita.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
        </form>
        
        @if(request('cari'))
            <p class="text-sm text-gray-500 text-center mt-2">
                Menampilkan hasil pencarian untuk: <strong>"{{ request('cari') }}"</strong>
            </p>
        @endif
    </div>
    
    {{-- News Grid --}}
    @if($berita->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($berita as $item)
                <article class="bento-card group">
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
            :title="request('cari') ? 'Tidak ada hasil' : 'Belum ada berita'"
            :description="request('cari') ? 'Tidak ditemukan berita yang sesuai dengan kata kunci \"' . request('cari') . '\"' : 'Berita terbaru akan tampil di sini.'"
            icon="search"
        />
    @endif
</div>
@endsection
