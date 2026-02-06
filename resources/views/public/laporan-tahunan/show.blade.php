@extends('layouts.public')

@section('title', $laporan->meta_title ?? $laporan->judul . ' - BUMNag Madani Lubuk Malako')
@section('meta_description', $laporan->meta_description ?? Str::limit($laporan->deskripsi, 160))

@section('content')
<div class="py-8 lg:py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('beranda') }}" class="hover:text-primary transition-colors">Beranda</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('laporan-tahunan.index') }}" class="hover:text-primary transition-colors">Laporan Tahunan</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900 font-medium truncate">{{ $laporan->tahun }}</span>
            </nav>
            
            {{-- Header Card --}}
            <div class="bento-card mb-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- Cover / Year Badge --}}
                    <div class="flex-shrink-0">
                        @if($laporan->cover_image)
                            <img src="{{ $laporan->cover_image_url }}" 
                                 alt="Cover {{ $laporan->judul }}" 
                                 class="w-40 lg:w-48 aspect-[2/3] object-cover rounded-xl shadow-md">
                        @else
                            <div class="w-40 lg:w-48 aspect-[2/3] rounded-xl bg-gradient-to-br from-primary to-primary-dark flex flex-col items-center justify-center">
                                <span class="text-xs uppercase tracking-wider text-white/80 mb-1">Laporan</span>
                                <span class="text-4xl font-bold text-white">{{ $laporan->tahun }}</span>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $laporan->judul }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                            @if($laporan->tanggal_publikasi)
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Dipublikasi {{ $laporan->tanggal_publikasi->translatedFormat('d F Y') }}
                            </span>
                            @endif
                            
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ number_format($laporan->download_count) }} kali diunduh
                            </span>
                        </div>
                        
                        @if($laporan->deskripsi)
                            <p class="text-gray-600 leading-relaxed">{{ $laporan->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Download Card --}}
            <div class="bento-card bg-gradient-to-br from-primary/5 to-primary/10 border border-primary/20 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-lg bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $laporan->file_original_name }}</p>
                            <p class="text-sm text-gray-500">PDF • {{ $laporan->file_size_formatted }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('laporan-tahunan.download', $laporan->slug) }}" 
                       class="btn-primary w-full sm:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Laporan
                    </a>
                </div>
            </div>
            
            {{-- PDF Preview --}}
            @if($laporan->file_url)
            <div class="bento-card">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Pratinjau Dokumen
                </h2>
                
                <div class="aspect-[4/5] lg:aspect-[16/10] w-full rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                    <iframe src="{{ $laporan->file_url }}#view=FitH" 
                            class="w-full h-full" 
                            frameborder="0">
                    </iframe>
                </div>
                
                <p class="text-sm text-gray-500 text-center mt-3">
                    Tidak bisa melihat preview? 
                    <a href="{{ $laporan->file_url }}" target="_blank" class="text-primary hover:underline">Buka di tab baru</a>
                </p>
            </div>
            @endif
            
            {{-- Navigation --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <a href="{{ route('laporan-tahunan.index') }}" class="btn-ghost w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Semua Laporan
                </a>
                
                <div class="flex items-center gap-2">
                    @if($prevLaporan)
                        <a href="{{ route('laporan-tahunan.show', $prevLaporan->slug) }}" 
                           class="btn-ghost justify-center"
                           title="Laporan {{ $prevLaporan->tahun }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            {{ $prevLaporan->tahun }}
                        </a>
                    @endif
                    
                    @if($nextLaporan)
                        <a href="{{ route('laporan-tahunan.show', $nextLaporan->slug) }}" 
                           class="btn-ghost justify-center"
                           title="Laporan {{ $nextLaporan->tahun }}">
                            {{ $nextLaporan->tahun }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
