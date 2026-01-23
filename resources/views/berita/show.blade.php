@extends('layouts.public')

@section('title', $berita->judul . ' - BUMNag Madani Lubuk Malako')

@section('breadcrumb')
<nav class="breadcrumb">
    <a href="{{ route('beranda') }}">Beranda</a>
    <span class="breadcrumb-separator">/</span>
    <a href="{{ route('berita.index') }}">Berita</a>
    <span class="breadcrumb-separator">/</span>
    <span class="current">{{ Str::limit($berita->judul, 30) }}</span>
</nav>
@endsection

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="bento-card">
        @if($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-48 sm:h-64 lg:h-80 object-cover rounded-xl mb-5 lg:mb-6">
        @endif
        
        <div class="flex flex-wrap items-center gap-2 lg:gap-3 mb-4">
            @if($berita->kategori)
            <span class="text-xs lg:text-sm font-medium bg-bumnag-olive/10 text-bumnag-olive px-2.5 py-1 rounded-full">
                {{ $berita->kategori }}
            </span>
            @endif
            <span class="text-xs lg:text-sm text-gray-500">{{ $berita->published_at?->format('d F Y') }}</span>
            <span class="text-xs lg:text-sm text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ $berita->views }} views
            </span>
        </div>
        
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-bumnag-gray mb-4">{{ $berita->judul }}</h1>
        
        @if($berita->penulis)
        <p class="text-xs lg:text-sm text-gray-500 mb-5 lg:mb-6">Ditulis oleh <span class="font-medium text-bumnag-olive">{{ $berita->penulis }}</span></p>
        @endif
        
        <div class="prose prose-sm lg:prose-base max-w-none text-gray-600 leading-relaxed">
            {!! nl2br(e($berita->konten)) !!}
        </div>
    </div>
    
    <div class="flex items-center">
        <a href="{{ route('berita.index') }}" class="btn-outline text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>
    
    @if($beritaLainnya->count() > 0)
    <div class="pt-4 lg:pt-6">
        <h3 class="text-lg lg:text-xl font-semibold text-bumnag-gray mb-4 lg:mb-6">Berita Lainnya</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach($beritaLainnya as $item)
            <a href="{{ route('berita.show', $item) }}" class="news-card">
                @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-28 lg:h-32 object-cover">
                @else
                <div class="w-full h-28 lg:h-32 bg-gradient-to-br from-bumnag-olive/20 to-bumnag-olive/5 flex items-center justify-center">
                    <svg class="w-8 h-8 text-bumnag-olive/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                @endif
                <div class="p-3 lg:p-4">
                    <h4 class="font-medium text-sm text-bumnag-gray group-hover:text-bumnag-olive transition line-clamp-2">{{ $item->judul }}</h4>
                    <p class="text-xs text-gray-400 mt-2">{{ $item->published_at?->format('d M Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
