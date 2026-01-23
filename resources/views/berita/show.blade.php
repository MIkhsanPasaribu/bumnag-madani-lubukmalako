@extends('layouts.app')

@section('title', $berita->judul . ' - BUMNag Madani Lubuk Malako')
@section('page-title', 'Detail Berita')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bento-card">
        @if($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-64 md:h-96 object-cover rounded-xl mb-6">
        @endif
        
        <div class="flex items-center gap-3 mb-4 flex-wrap">
            @if($berita->kategori)
            <span class="text-sm font-medium bg-bumnag-olive/10 text-bumnag-olive px-3 py-1 rounded-full">
                {{ $berita->kategori }}
            </span>
            @endif
            <span class="text-sm text-gray-500">{{ $berita->published_at?->format('d F Y') }}</span>
            <span class="text-sm text-gray-400 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ $berita->views }} views
            </span>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-bold text-bumnag-gray mb-4">{{ $berita->judul }}</h1>
        
        @if($berita->penulis)
        <p class="text-sm text-gray-500 mb-6">Ditulis oleh <span class="font-medium text-bumnag-olive">{{ $berita->penulis }}</span></p>
        @endif
        
        <div class="prose prose-lg max-w-none">
            {!! nl2br(e($berita->konten)) !!}
        </div>
    </div>
    
    <div class="flex items-center justify-between">
        <a href="{{ route('berita.index') }}" class="btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Berita
        </a>
    </div>
    
    @if($beritaLainnya->count() > 0)
    <div class="pt-8">
        <h3 class="text-xl font-semibold text-bumnag-gray mb-6">Berita Lainnya</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beritaLainnya as $item)
            <a href="{{ route('berita.show', $item) }}" class="bento-card group">
                @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-32 object-cover rounded-xl mb-3">
                @else
                <div class="w-full h-32 bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 rounded-xl mb-3 flex items-center justify-center">
                    <svg class="w-8 h-8 text-bumnag-olive/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                @endif
                <h4 class="font-medium text-bumnag-gray group-hover:text-bumnag-olive transition line-clamp-2">{{ $item->judul }}</h4>
                <p class="text-xs text-gray-400 mt-2">{{ $item->published_at?->format('d M Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
