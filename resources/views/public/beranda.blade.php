@extends('layouts.public')

@section('title', 'Beranda')

@section('meta_description', 'Website resmi BUMNag Madani Lubuk Malako - Badan Usaha Milik Nagari yang transparan dan profesional')

@section('content')
{{-- Fullscreen Hero Section --}}
@if(isset($heroSlides) && $heroSlides->count() > 0)
<section class="relative w-full h-screen overflow-hidden" 
    x-data="{
        current: 0,
        total: {{ $heroSlides->count() }},
        playing: true,
        timer: null,
        
        init() {
            this.start();
        },
        
        start() {
            this.playing = true;
            this.timer = setInterval(() => this.next(), 6000);
        },
        
        stop() {
            this.playing = false;
            if (this.timer) { clearInterval(this.timer); this.timer = null; }
        },
        
        toggle() {
            this.playing ? this.stop() : this.start();
        },
        
        next() {
            this.current = (this.current + 1) % this.total;
        },
        
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        },
        
        go(i) {
            this.current = i;
            if (this.playing) { this.stop(); this.start(); }
        }
    }"
>
    {{-- Slides --}}
    @foreach($heroSlides as $index => $slide)
    <div x-show="current === {{ $index }}"
         x-transition:enter="transition ease-out duration-1000"
         x-transition:enter-start="opacity-0 scale-105"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-700"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute inset-0 w-full h-full">
        
        {{-- Fallback Background (warna resmi BUMNag) --}}
        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#1a3a1a] via-[#2d5a2d] to-[#86ae5f]"></div>
        
        {{-- Background Media --}}
        @if($slide->is_video)
            <video autoplay loop muted playsinline
                   class="absolute inset-0 w-full h-full object-cover"
                   x-ref="video{{ $index }}">
                <source src="{{ $slide->media_url }}" type="video/mp4">
            </video>
        @else
            @php
                $mediaExists = $slide->media_path && file_exists(public_path('uploads/hero/' . $slide->media_path));
            @endphp
            @if($mediaExists)
            <div class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat"
                 style="background-image: url('{{ $slide->media_url }}');">
            </div>
            @endif
        @endif
        
        {{-- Gradient Overlay (cream) --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#fffaed]/70 via-[#fffaed]/30 to-[#fffaed]/10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#fffaed]/50 via-transparent to-transparent"></div>
    </div>
    @endforeach

    {{-- Content Overlay --}}
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            @foreach($heroSlides as $index => $slide)
            <div x-show="current === {{ $index }}" x-cloak
                 x-transition:enter="transition ease-out duration-700 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex items-center justify-between gap-8 w-full">
                
                {{-- Text Content --}}
                <div class="max-w-2xl">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6 leading-tight drop-shadow-lg" style="-webkit-text-stroke: 2.5px rgba(0,0,0,0.7); paint-order: stroke fill;">
                        {{ $slide->judul }}
                    </h1>
                    
                    @if($slide->subjudul)
                    <p class="text-base sm:text-lg md:text-xl text-white/90 mb-6 md:mb-8 max-w-xl leading-relaxed drop-shadow-md" style="-webkit-text-stroke: 1px rgba(0,0,0,0.6); paint-order: stroke fill;">
                        {{ $slide->subjudul }}
                    </p>
                    @endif
                    
                    @if($slide->teks_tombol && $slide->url_tombol)
                    <a href="{{ $slide->url_tombol }}" 
                       class="inline-flex items-center px-6 py-3 md:px-8 md:py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm md:text-base">
                        {{ $slide->teks_tombol }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @endif
                </div>

                {{-- Logo (jika diaktifkan) --}}
                @if($slide->tampilkan_logo)
                <div class="hidden md:flex items-center justify-center flex-shrink-0">
                    <img src="{{ $logoUrl }}" 
                         alt="Logo BUMNag Madani" 
                         class="w-40 lg:w-56 xl:w-64 h-auto drop-shadow-2xl opacity-90">
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Navigation Arrows --}}
    @if($heroSlides->count() > 1)
    <div class="absolute inset-0 z-20 pointer-events-none">
        <div class="h-full flex items-center justify-between px-3 sm:px-6">
            <button @click="prev()" 
                    class="pointer-events-auto bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white p-2.5 sm:p-3 rounded-full transition-all duration-300 opacity-0 hover:opacity-100 focus:opacity-100 group-hover:opacity-100"
                    style="opacity: 0.5;"
                    aria-label="Slide sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()" 
                    class="pointer-events-auto bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white p-2.5 sm:p-3 rounded-full transition-all duration-300 opacity-0 hover:opacity-100 focus:opacity-100 group-hover:opacity-100"
                    style="opacity: 0.5;"
                    aria-label="Slide selanjutnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Bottom Controls --}}
    <div class="absolute bottom-0 left-0 right-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 md:pb-12 flex items-center justify-between">
            {{-- Indicators --}}
            @if($heroSlides->count() > 1)
            <div class="flex items-center gap-2">
                @foreach($heroSlides as $index => $slide)
                <button @click="go({{ $index }})"
                        :class="current === {{ $index }} ? 'w-8 bg-white' : 'w-2.5 bg-white/40 hover:bg-white/60'"
                        class="h-2.5 rounded-full transition-all duration-500"
                        aria-label="Ke slide {{ $index + 1 }}">
                </button>
                @endforeach
            </div>
            @else
            <div></div>
            @endif

            {{-- Autoplay Toggle --}}
            @if($heroSlides->count() > 1)
            <button @click="toggle()" 
                    class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-2 rounded-full transition-all"
                    aria-label="Toggle autoplay">
                <svg x-show="playing" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg x-show="!playing" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            @endif
        </div>
    </div>

    {{-- Scroll Down Indicator --}}
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 animate-bounce hidden md:block">
        <a href="#content-start" class="text-white/60 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>
    </div>
</section>
<div id="content-start"></div>
@else
{{-- Fallback Hero Section (tanpa slides) - desain statis default --}}
<section class="relative w-full min-h-screen flex items-center bg-cream overflow-hidden">
    {{-- Subtle pattern background --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%2386ae5f&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20 md:py-0">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            {{-- Konten Teks --}}
            <div class="text-center lg:text-left order-2 lg:order-1">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Selamat Datang di<br>
                    <span class="text-primary">BUMNag Madani</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Badan Usaha Milik Nagari yang berkomitmen untuk mengembangkan ekonomi nagari dan meningkatkan kesejahteraan masyarakat Lubuk Malako.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('profil') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tentang Kami
                    </a>
                    <a href="{{ route('transparansi') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Lihat Laporan
                    </a>
                </div>
            </div>

            {{-- Logo --}}
            <div class="flex justify-center lg:justify-end order-1 lg:order-2">
                <div class="relative">
                    {{-- Glow effect di belakang logo --}}
                    <div class="absolute inset-0 bg-primary/10 rounded-full blur-3xl transform scale-150"></div>
                    <img src="{{ $logoUrl }}" alt="Logo BUMNag Madani Lubuk Malako" 
                         class="relative w-56 sm:w-64 md:w-80 lg:w-96 h-auto drop-shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Down Indicator --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 animate-bounce hidden md:block">
        <a href="#content-start" class="text-gray-400 hover:text-primary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>
    </div>
</section>
<div id="content-start"></div>
@endif

{{-- 1. LAPORAN TAHUNAN SECTION --}}
@if($laporanTerbaru->count() > 0)
<section class="py-12 md:py-16 bg-white pattern-grain divider-wave-top">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">📋 Laporan Tahunan</h2>
                <p class="text-gray-600">Transparansi dan akuntabilitas pengelolaan BUMNag Madani</p>
            </div>
            <a href="{{ route('laporan-tahunan.index') }}" class="btn-ghost text-primary">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        {{-- Laporan Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laporanTerbaru as $laporan)
                <article class="bento-card group hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start gap-4">
                        {{-- Year Badge --}}
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center">
                                <span class="text-xl font-bold text-white">{{ $laporan->tahun }}</span>
                            </div>
                        </div>
                        
                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 group-hover:text-primary transition-colors line-clamp-2 mb-2">
                                {{ $laporan->judul }}
                            </h3>
                            
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
                                @if($laporan->file_size_formatted)
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ $laporan->file_size_formatted }}
                                </span>
                                @endif
                                
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    {{ number_format($laporan->download_count) }} diunduh
                                </span>
                            </div>
                            
                            <a href="{{ route('laporan-tahunan.download', $laporan->slug) }}" 
                               class="inline-flex items-center text-sm text-primary font-medium hover:text-primary-dark transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 2. STATISTIK SECTION --}}
<section class="py-12 md:py-16 bg-gray-50 pattern-dots divider-wave-top">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">📊 Statistik Keuangan {{ $tahunIni }}</h2>
            <p class="text-gray-600">Ringkasan kinerja keuangan BUMNag tahun ini</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Pendapatan --}}
            <div class="bento-card text-center group">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($statistikKeuangan['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
            </div>
            
            {{-- Total Pengeluaran --}}
            <div class="bento-card text-center group">
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($statistikKeuangan['total_pengeluaran'] ?? 0, 0, ',', '.') }}</p>
            </div>
            
            {{-- Laba/Rugi --}}
            <div class="bento-card text-center group">
                <div class="w-14 h-14 {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'bg-primary/10' : 'bg-red-100' }} rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-1">Laba/Rugi</p>
                <p class="text-2xl font-bold {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                    {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}Rp {{ number_format($statistikKeuangan['total_laba_rugi'] ?? 0, 0, ',', '.') }}
                </p>
            </div>
            
            {{-- Jumlah Laporan --}}
            <div class="bento-card text-center group">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 mb-1">Data Tercatat</p>
                <p class="text-2xl font-bold text-gray-900">{{ $statistikKeuangan['jumlah_bulan'] ?? 0 }} Bulan</p>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('statistik') }}" class="btn-outline">
                Lihat Statistik Lengkap
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- 3. BERITA SECTION — Horizontal Auto-Scroll Carousel --}}
<section class="py-12 md:py-16 bg-cream pattern-leaf divider-wave-top">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">📰 Berita & Informasi</h2>
                <p class="text-gray-600">Kabar terkini dari BUMNag Madani Lubuk Malako</p>
            </div>
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-1.5 text-primary font-semibold hover:underline transition-colors">
                Semua Berita
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        
        @if($beritaTerbaru->count() > 0)
        <div x-data="{
            current: 0,
            perPage: 4,
            total: {{ $beritaTerbaru->count() }},
            timer: null,
            
            get maxIndex() { return Math.max(0, this.total - this.perPage); },
            
            init() {
                this.updatePerPage();
                window.addEventListener('resize', () => this.updatePerPage());
                this.startAuto();
            },
            
            updatePerPage() {
                if (window.innerWidth < 640) this.perPage = 1;
                else if (window.innerWidth < 1024) this.perPage = 2;
                else this.perPage = 4;
                if (this.current > this.maxIndex) this.current = this.maxIndex;
            },
            
            next() {
                this.current = this.current >= this.maxIndex ? 0 : this.current + 1;
            },
            
            prev() {
                this.current = this.current <= 0 ? this.maxIndex : this.current - 1;
            },
            
            startAuto() {
                this.timer = setInterval(() => this.next(), 4000);
            },
            
            stopAuto() {
                if (this.timer) { clearInterval(this.timer); this.timer = null; }
            },
            
            resetAuto() {
                this.stopAuto();
                this.startAuto();
            }
        }" 
        @mouseenter="stopAuto()" 
        @mouseleave="startAuto()"
        class="relative">
            
            {{-- Carousel Container --}}
            <div class="overflow-hidden rounded-xl">
                <div class="flex transition-transform duration-500 ease-in-out"
                     :style="'transform: translateX(-' + (current * (100 / perPage)) + '%)'">
                    
                    @foreach($beritaTerbaru as $berita)
                    <div class="flex-shrink-0 px-2" :style="'width: ' + (100 / perPage) + '%'">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="block group">
                            <article class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 h-72 sm:h-80">
                                {{-- Background Image --}}
                                @if($berita->gambar)
                                    <img src="{{ $berita->gambar_url }}" 
                                         alt="{{ $berita->judul }}" 
                                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                
                                {{-- Category Badge --}}
                                @if($berita->kategori)
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm"
                                          style="color: {{ $berita->kategori->warna }};">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $berita->kategori->warna }};"></span>
                                        {{ $berita->kategori->nama }}
                                    </span>
                                </div>
                                @endif
                                
                                {{-- Content at Bottom --}}
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="font-bold text-white text-sm sm:text-base leading-snug line-clamp-2 mb-2 group-hover:text-primary-light transition-colors" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                                        {{ $berita->judul }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-xs text-white/80">
                                        <span>{{ ($berita->tanggal_kegiatan ?? $berita->tanggal_publikasi)?->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>Berita</span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            
            {{-- Navigation Arrows --}}
            <button @click="prev(); resetAuto()" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-3 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:text-primary hover:shadow-xl transition-all z-10 hidden sm:flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next(); resetAuto()" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-3 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:text-primary hover:shadow-xl transition-all z-10 hidden sm:flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            {{-- Dot Indicators --}}
            <div class="flex justify-center gap-2 mt-6">
                <template x-for="i in (maxIndex + 1)" :key="i">
                    <button @click="current = i - 1; resetAuto()"
                            :class="current === (i - 1) ? 'w-8 bg-primary' : 'w-2 bg-gray-300 hover:bg-gray-400'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
        @else
            <x-empty-state 
                title="Belum ada berita"
                description="Berita terbaru akan tampil di sini."
                icon="document"
            />
        @endif
    </div>
</section>

{{-- 4. GALERI SECTION - Auto Slider --}}
@if($galeriFoto->count() > 0)
<section class="py-12 md:py-16 bg-white pattern-wave divider-wave-top">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">📸 Galeri BUMNag</h2>
                <p class="text-gray-600">Dokumentasi kegiatan dan momen BUMNag Madani Lubuk Malako</p>
            </div>
            <a href="{{ route('galeri-bumnag.index') }}" class="btn-ghost text-primary">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        {{-- Auto Slider Component --}}
        <div class="relative overflow-hidden rounded-2xl shadow-2xl" 
             x-data="{
                currentSlide: 0,
                totalSlides: {{ $galeriFoto->count() }},
                isPlaying: true,
                intervalId: null,
                
                init() {
                    this.startAutoplay();
                },
                
                startAutoplay() {
                    this.isPlaying = true;
                    this.intervalId = setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },
                
                stopAutoplay() {
                    this.isPlaying = false;
                    if (this.intervalId) {
                        clearInterval(this.intervalId);
                        this.intervalId = null;
                    }
                },
                
                toggleAutoplay() {
                    if (this.isPlaying) {
                        this.stopAutoplay();
                    } else {
                        this.startAutoplay();
                    }
                },
                
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },
                
                prevSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                
                goToSlide(index) {
                    this.currentSlide = index;
                    if (this.isPlaying) {
                        this.stopAutoplay();
                        this.startAutoplay();
                    }
                }
             }">
            {{-- Main Slider --}}
            <div class="relative aspect-[21/9] bg-gray-900 overflow-hidden group">
                @foreach($galeriFoto as $index => $foto)
                    <div 
                        x-show="currentSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 transform translate-x-full"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-full"
                        class="absolute inset-0"
                    >
                        {{-- Background Image with Overlay --}}
                        <img 
                            src="{{ $foto->foto_url }}" 
                            alt="{{ $foto->judul }}"
                            class="w-full h-full object-cover"
                        >
                        
                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                        
                        {{-- Content --}}
                        <div class="absolute inset-0 flex items-end p-6 sm:p-8 md:p-12">
                            <div class="max-w-2xl">
                                <h3 class="text-xl sm:text-2xl md:text-4xl font-bold text-white mb-2 md:mb-3 animate-fade-in">
                                    {{ $foto->judul }}
                                </h3>
                                @if($foto->deskripsi)
                                    <p class="text-white/90 text-sm md:text-base mb-3 md:mb-4 line-clamp-2 animate-slide-up">
                                        {{ $foto->deskripsi }}
                                    </p>
                                @endif
                                <div class="flex items-center gap-4 text-white/70 text-xs md:text-sm animate-slide-up">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $foto->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Navigation Buttons --}}
                <button 
                    @click="prevSlide"
                    class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-2 sm:p-3 rounded-full transition-all opacity-0 group-hover:opacity-100 z-10"
                    aria-label="Previous slide"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <button 
                    @click="nextSlide"
                    class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-2 sm:p-3 rounded-full transition-all opacity-0 group-hover:opacity-100 z-10"
                    aria-label="Next slide"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Indicators --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach($galeriFoto as $index => $foto)
                        <button 
                            @click="goToSlide({{ $index }})"
                            :class="currentSlide === {{ $index }} ? 'w-8 bg-white' : 'w-2 bg-white/50'"
                            class="h-2 rounded-full transition-all duration-300 hover:bg-white/80"
                            aria-label="Go to slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>

                {{-- Auto-play Toggle --}}
                <div class="absolute top-3 sm:top-4 right-3 sm:right-4 z-10">
                    <button 
                        @click="toggleAutoplay"
                        class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white p-2 rounded-full transition"
                        title="Toggle Autoplay"
                        aria-label="Toggle autoplay"
                    >
                        <svg x-show="isPlaying" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg x-show="!isPlaying" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="py-12 md:py-16 bg-primary pattern-diagonal divider-wave-top">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Transparansi Pengelolaan Keuangan</h2>
        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
            Kami berkomitmen untuk mengelola keuangan BUMNag secara transparan dan akuntabel. 
            Lihat laporan keuangan kami yang dapat diakses oleh seluruh masyarakat.
        </p>
        <a href="{{ route('transparansi') }}" class="inline-flex items-center px-6 py-3 bg-white text-primary font-semibold rounded-lg hover:bg-gray-50 transition-colors shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Lihat Laporan Keuangan
        </a>
    </div>
</section>
@endsection
