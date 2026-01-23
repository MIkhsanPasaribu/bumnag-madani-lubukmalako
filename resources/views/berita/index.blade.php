@extends('layouts.app')

@section('title', 'Berita - BUMNag Madani Lubuk Malako')
@section('page-title', 'Berita')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="bento-card-accent">
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div class="text-center sm:text-left">
                <h1 class="text-xl sm:text-2xl font-bold">Berita & Informasi</h1>
                <p class="text-white/80 text-sm sm:text-base">Berita terbaru seputar kegiatan dan perkembangan BUMNag</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        @forelse($berita as $item)
        <a href="{{ route('berita.show', $item) }}" class="news-card">
            @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="news-card-image">
            @else
            <div class="news-card-image bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 flex items-center justify-center">
                <svg class="w-12 h-12 text-bumnag-olive/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            @endif
            
            <div class="news-card-content">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    @if($item->kategori)
                    <span class="text-[10px] lg:text-xs font-semibold bg-bumnag-olive/10 text-bumnag-olive px-2 py-0.5 rounded">
                        {{ $item->kategori }}
                    </span>
                    @endif
                    <span class="text-[10px] lg:text-xs text-gray-400">{{ $item->published_at?->format('d M Y') }}</span>
                </div>
                
                <h3 class="font-semibold text-sm lg:text-base text-bumnag-gray group-hover:text-bumnag-olive transition mb-2 line-clamp-2">
                    {{ $item->judul }}
                </h3>
                
                <p class="text-xs lg:text-sm text-gray-500 line-clamp-2 mb-3">
                    {{ $item->ringkasan ?? Str::limit(strip_tags($item->konten), 100) }}
                </p>
                
                <div class="flex items-center justify-between text-xs text-gray-400">
                    <span class="truncate">{{ $item->penulis ?? 'Admin' }}</span>
                    <span class="flex items-center gap-1 shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $item->views }}
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="bento-card text-center py-12">
                <svg class="w-12 h-12 lg:w-16 lg:h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-base lg:text-lg font-semibold text-gray-700 mb-2">Belum Ada Berita</h3>
                <p class="text-sm text-gray-500">Berita akan ditampilkan setelah dipublikasikan.</p>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($berita->hasPages())
    <div class="flex justify-center">
        {{ $berita->links() }}
    </div>
    @endif
</div>
@endsection
