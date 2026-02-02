@extends('layouts.public')

@section('title', 'Beranda')

@section('meta_description', 'Website resmi BUMNag Madani Lubuk Malako - Badan Usaha Milik Nagari yang transparan dan profesional')

@section('content')
{{-- Hero Section --}}
<section class="bg-gradient-to-br from-cream to-white py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Text Content --}}
            <div class="text-center lg:text-left">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Selamat Datang di<br>
                    <span class="text-primary">BUMNag Madani</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0">
                    Badan Usaha Milik Nagari yang berkomitmen untuk mengembangkan ekonomi nagari dan meningkatkan kesejahteraan masyarakat Lubuk Malako.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('profil') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tentang Kami
                    </a>
                    <a href="{{ route('transparansi') }}" class="btn-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Lihat Laporan
                    </a>
                </div>
            </div>
            
            {{-- Hero Image/Logo --}}
            <div class="flex justify-center lg:justify-end">
                <div class="relative">
                    <div class="absolute inset-0 bg-primary/20 rounded-full blur-3xl transform scale-150"></div>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag Madani" class="relative w-64 md:w-80 lg:w-96 h-auto drop-shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 1. PENGUMUMAN SECTION - Carousel Slide --}}
@if($pengumumanAktif->count() > 0)
<section class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">📢 Pengumuman</h2>
                <p class="text-gray-600">Pengumuman penting dari BUMNag Madani</p>
            </div>
            <a href="{{ route('pengumuman.index') }}" class="btn-ghost text-primary">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        {{-- Pengumuman Carousel --}}
        <div class="relative overflow-hidden rounded-2xl shadow-2xl" 
             x-data="{
                currentSlide: 0,
                totalSlides: {{ $pengumumanAktif->count() }},
                isPlaying: true,
                intervalId: null,
                
                init() {
                    this.startAutoplay();
                },
                
                startAutoplay() {
                    this.isPlaying = true;
                    this.intervalId = setInterval(() => {
                        this.nextSlide();
                    }, 6000);
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
            <div class="relative aspect-[21/9] md:aspect-[21/7] overflow-hidden group">
                @foreach($pengumumanAktif as $index => $pengumuman)
                    <div 
                        x-show="currentSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 transform translate-x-full"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-full"
                        class="absolute inset-0 @if($pengumuman->prioritas === 'tinggi') bg-gradient-to-br from-red-600 via-red-700 to-red-800 @elseif($pengumuman->prioritas === 'sedang') bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600 @else bg-gradient-to-br from-emerald-500 via-emerald-600 to-green-700 @endif"
                    >
                        {{-- Background Pattern --}}
                        <div class="absolute inset-0 opacity-10">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <defs>
                                    <pattern id="grid-{{ $index }}" width="10" height="10" patternUnits="userSpaceOnUse">
                                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                                    </pattern>
                                </defs>
                                <rect width="100" height="100" fill="url(#grid-{{ $index }})" />
                            </svg>
                        </div>
                        
                        {{-- Content --}}
                        <div class="absolute inset-0 flex items-center p-6 sm:p-8 md:p-12">
                            <div class="max-w-3xl">
                                {{-- Priority Badge --}}
                                <div class="mb-4">
                                    @if($pengumuman->prioritas === 'tinggi')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white text-red-600 animate-pulse">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            PENTING
                                        </span>
                                    @elseif($pengumuman->prioritas === 'sedang')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 text-yellow-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            INFO
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/80 text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            UMUM
                                        </span>
                                    @endif
                                </div>
                                
                                {{-- Title --}}
                                <h3 class="text-xl sm:text-2xl md:text-4xl font-bold text-white mb-3 md:mb-4 line-clamp-2">
                                    {{ $pengumuman->judul }}
                                </h3>
                                
                                {{-- Description --}}
                                <p class="text-white/90 text-sm md:text-base mb-4 md:mb-6 line-clamp-2">
                                    {{ Str::limit(strip_tags($pengumuman->konten), 150) }}
                                </p>
                                
                                {{-- Meta Info & CTA --}}
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <div class="flex items-center gap-4 text-white/70 text-xs md:text-sm">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $pengumuman->tanggal_mulai->format('d M Y') }}
                                        </span>
                                        @if($pengumuman->lampiran)
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                Lampiran
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('pengumuman.show', $pengumuman->slug) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-white text-secondary font-semibold text-sm rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Decorative Icon --}}
                        <div class="absolute right-8 md:right-16 top-1/2 -translate-y-1/2 hidden lg:block opacity-20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
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
                    @foreach($pengumumanAktif as $index => $pengumuman)
                        <button 
                            @click="goToSlide({{ $index }})"
                            :class="currentSlide === {{ $index }} ? 'w-8 bg-white' : 'w-2 bg-white/50'"
                            class="h-2 rounded-full transition-all duration-300 hover:bg-white/80"
                            aria-label="Go to slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>

                {{-- Counter --}}
                <div class="absolute bottom-4 right-4 bg-white/10 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full z-10">
                    <span x-text="currentSlide + 1"></span> / {{ $pengumumanAktif->count() }}
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

{{-- 2. STATISTIK SECTION --}}
<section class="py-12 md:py-16 bg-gray-50">
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
                <p class="text-sm text-gray-500 mb-1">Laporan Terpublikasi</p>
                <p class="text-2xl font-bold text-gray-900">{{ $statistikKeuangan['jumlah_laporan'] ?? 0 }} Bulan</p>
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

{{-- 3. BERITA SECTION --}}
<section class="py-12 md:py-16 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">📰 Berita Terbaru</h2>
                <p class="text-gray-600">Kabar terkini dari BUMNag Madani</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn-ghost text-primary">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        
        @if($beritaTerbaru->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($beritaTerbaru as $berita)
                    <article class="bento-card group">
                        @if($berita->gambar)
                            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->tanggal_publikasi?->format('d M Y') }}
                        </div>
                        
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-2">
                            <a href="{{ route('berita.show', $berita->slug) }}">{{ $berita->judul }}</a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $berita->ringkasan }}</p>
                        
                        <a href="{{ route('berita.show', $berita->slug) }}" class="inline-flex items-center text-primary font-medium text-sm hover:underline">
                            Baca Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </article>
                @endforeach
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
<section class="py-12 md:py-16 bg-white">
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
<section class="py-12 md:py-16 bg-primary">
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
