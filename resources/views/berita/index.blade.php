@extends('layouts.app')

@section('title', 'Berita - BUMNag Madani Lubuk Malako')
@section('page-title', 'Berita')

@section('content')
<div class="space-y-8">
    <div class="bento-card-accent">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Berita & Informasi</h1>
                <p class="text-white/80">Berita terbaru seputar kegiatan dan perkembangan BUMNag Madani Lubuk Malako</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($berita as $item)
        <a href="{{ route('berita.show', $item) }}" class="bento-card group hover:shadow-lg transition-all">
            @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover rounded-xl mb-4">
            @else
            <div class="w-full h-48 bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 rounded-xl mb-4 flex items-center justify-center">
                <svg class="w-16 h-16 text-bumnag-olive/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            @endif
            
            <div class="flex items-center gap-2 mb-3">
                @if($item->kategori)
                <span class="text-xs font-medium bg-bumnag-olive/10 text-bumnag-olive px-2 py-1 rounded-full">
                    {{ $item->kategori }}
                </span>
                @endif
                <span class="text-xs text-gray-400">{{ $item->published_at?->format('d M Y') }}</span>
            </div>
            
            <h3 class="font-semibold text-bumnag-gray group-hover:text-bumnag-olive transition mb-2 line-clamp-2">
                {{ $item->judul }}
            </h3>
            
            <p class="text-sm text-gray-500 line-clamp-3 mb-4">
                {{ $item->ringkasan ?? Str::limit(strip_tags($item->konten), 150) }}
            </p>
            
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400">{{ $item->penulis ?? 'Admin' }}</span>
                <span class="text-gray-400 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $item->views }}
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="bento-card text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Berita</h3>
                <p class="text-gray-500">Berita akan ditampilkan di sini setelah dipublikasikan.</p>
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
