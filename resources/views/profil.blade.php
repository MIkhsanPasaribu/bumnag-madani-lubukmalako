@extends('layouts.public')

@section('title', 'Profil BUMNag - BUMNag Madani Lubuk Malako')

@section('breadcrumb')
<nav class="breadcrumb">
    <a href="{{ route('beranda') }}">Beranda</a>
    <span class="breadcrumb-separator">/</span>
    <span class="current">Profil BUMNag</span>
</nav>
@endsection

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="bento-card-accent">
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-2xl p-3 flex items-center justify-center shrink-0 shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BUMNag" class="h-full w-auto object-contain">
            </div>
            <div class="text-center sm:text-left">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-1">{{ $profil?->nama_bumnag ?? 'BUMNag Madani Lubuk Malako' }}</h1>
                <p class="text-white/90 text-sm sm:text-base">Badan Usaha Milik Nagari</p>
                @if($profil?->tahun_berdiri)
                <p class="text-white/70 text-sm mt-2">Berdiri sejak {{ $profil->tahun_berdiri }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <div class="bento-card">
                <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-bumnag-olive shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Sejarah
                </h3>
                <div class="text-sm lg:text-base text-gray-600 leading-relaxed">
                    {!! nl2br(e($profil?->sejarah ?? 'BUMNag Madani Lubuk Malako didirikan dengan tujuan untuk memajukan perekonomian masyarakat nagari melalui pengelolaan usaha yang profesional dan berkelanjutan. Sebagai badan usaha milik nagari, BUMNag berkomitmen untuk memberikan kontribusi nyata bagi kesejahteraan masyarakat Lubuk Malako.')) !!}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div class="bento-card border-l-4 border-bumnag-olive">
                    <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-bumnag-olive shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Visi
                    </h3>
                    <p class="text-sm lg:text-base text-gray-600">
                        {{ $profil?->visi ?? 'Menjadi Badan Usaha Milik Nagari yang profesional, mandiri, dan berkontribusi nyata dalam meningkatkan kesejahteraan masyarakat Lubuk Malako.' }}
                    </p>
                </div>
                
                <div class="bento-card border-l-4 border-bumnag-red">
                    <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-bumnag-red shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Misi
                    </h3>
                    <div class="text-sm lg:text-base text-gray-600">
                        @if($profil?->misi)
                            {!! nl2br(e($profil->misi)) !!}
                        @else
                            <ul class="list-disc list-inside space-y-1">
                                <li>Mengelola usaha secara profesional dan transparan</li>
                                <li>Meningkatkan pendapatan asli nagari</li>
                                <li>Memberdayakan potensi ekonomi lokal</li>
                                <li>Memberikan pelayanan terbaik kepada masyarakat</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($profil?->struktur_organisasi)
            <div class="bento-card">
                <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-bumnag-olive shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Struktur Organisasi
                </h3>
                <div class="text-sm lg:text-base text-gray-600 leading-relaxed">
                    {!! nl2br(e($profil->struktur_organisasi)) !!}
                </div>
            </div>
            @endif
        </div>
        
        <div class="space-y-4 lg:space-y-6">
            <div class="bento-card">
                <h3 class="text-base lg:text-lg font-semibold text-bumnag-gray mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-bumnag-olive shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Kontak
                </h3>
                <div class="space-y-4">
                    @if($profil?->alamat)
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div class="min-w-0">
                            <p class="text-xs lg:text-sm font-medium text-gray-700">Alamat</p>
                            <p class="text-xs lg:text-sm text-gray-500">{{ $profil->alamat }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profil?->telepon)
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <p class="text-xs lg:text-sm font-medium text-gray-700">Telepon</p>
                            <p class="text-xs lg:text-sm text-gray-500">{{ $profil->telepon }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profil?->email)
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div class="min-w-0">
                            <p class="text-xs lg:text-sm font-medium text-gray-700">Email</p>
                            <p class="text-xs lg:text-sm text-gray-500 truncate">{{ $profil->email }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profil?->website)
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <div class="min-w-0">
                            <p class="text-xs lg:text-sm font-medium text-gray-700">Website</p>
                            <a href="{{ $profil->website }}" target="_blank" class="text-xs lg:text-sm text-bumnag-olive hover:underline truncate block">{{ $profil->website }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="bento-card-red">
                <h3 class="text-base lg:text-lg font-semibold mb-3">Transparansi Keuangan</h3>
                <p class="text-white/90 text-xs lg:text-sm mb-4">Lihat laporan keuangan BUMNag secara transparan dan akuntabel.</p>
                <a href="{{ route('keuangan.transparansi') }}" class="btn-white w-full justify-center">
                    <span>Lihat Laporan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
