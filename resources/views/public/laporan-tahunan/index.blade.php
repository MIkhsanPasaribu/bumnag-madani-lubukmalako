@extends('layouts.public')

@section('title', 'Laporan Tahunan - BUMNag Madani Lubuk Malako')
@section('meta_description', 'Lihat dan unduh laporan tahunan BUMNag Madani Lubuk Malako. Transparansi pengelolaan dan kinerja BUMNag.')

@section('content')
<div class="py-8 lg:py-12">
    <div class="container mx-auto px-4">
        {{-- Header Section --}}
        <div class="text-center mb-10">
            <nav class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('beranda') }}" class="hover:text-primary transition-colors">Beranda</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900 font-medium">Laporan Tahunan</span>
            </nav>
            
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Laporan Tahunan BUMNag</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Transparansi dan akuntabilitas pengelolaan Badan Usaha Milik Nagari Madani Lubuk Malako. 
                Unduh laporan tahunan untuk melihat kinerja dan pertanggungjawaban kami.
            </p>
        </div>

        {{-- Stats Cards --}}
        @if($laporanTahunan->count() > 0)
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="bento-card text-center">
                <div class="text-3xl font-bold text-primary">{{ $laporanTahunan->count() }}</div>
                <div class="text-sm text-gray-600 mt-1">Total Laporan</div>
            </div>
            <div class="bento-card text-center">
                <div class="text-3xl font-bold text-primary">{{ $laporanTahunan->first()->tahun ?? '-' }}</div>
                <div class="text-sm text-gray-600 mt-1">Tahun Terbaru</div>
            </div>
            <div class="bento-card text-center">
                <div class="text-3xl font-bold text-primary">{{ number_format($laporanTahunan->sum('download_count')) }}</div>
                <div class="text-sm text-gray-600 mt-1">Total Download</div>
            </div>
            <div class="bento-card text-center">
                <div class="text-3xl font-bold text-primary">{{ $laporanTahunan->min('tahun') ?? '-' }}</div>
                <div class="text-sm text-gray-600 mt-1">Sejak Tahun</div>
            </div>
        </div>
        @endif

        {{-- Laporan List --}}
        @if($laporanTahunan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($laporanTahunan as $laporan)
                <article class="bento-card hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-stretch gap-5">
                        {{-- Cover Image or Year Badge --}}
                        <div class="flex-shrink-0">
                            @if($laporan->cover_image)
                                <a href="{{ route('laporan-tahunan.show', $laporan->slug) }}" class="block">
                                    <img src="{{ $laporan->cover_image_url }}" 
                                         alt="Cover {{ $laporan->judul }}" 
                                         class="w-32 sm:w-36 aspect-[2/3] object-cover rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                </a>
                            @else
                                <a href="{{ route('laporan-tahunan.show', $laporan->slug) }}"
                                   class="block w-32 sm:w-36 aspect-[2/3] rounded-lg bg-gradient-to-br from-primary to-primary-dark text-white hover:shadow-md transition-shadow">
                                    <div class="w-full h-full flex flex-col items-center justify-center">
                                        <span class="text-xs uppercase tracking-wider opacity-80 mb-1">Laporan</span>
                                        <span class="text-4xl font-bold">{{ $laporan->tahun }}</span>
                                    </div>
                                </a>
                            @endif
                        </div>
                        
                        {{-- Content --}}
                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Laporan Tahunan</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $laporan->tahun }}</p>
                                <h2 class="text-base font-semibold text-gray-800 leading-snug mb-2">
                                    <a href="{{ route('laporan-tahunan.show', $laporan->slug) }}" class="hover:text-primary transition-colors">
                                        {{ $laporan->deskripsi ?: $laporan->judul }}
                                    </a>
                                </h2>
                            </div>
                            
                            @if($laporan->file_laporan)
                            <div class="mt-auto pt-3 border-t border-gray-100">
                                <a href="{{ route('laporan-tahunan.download', $laporan->slug) }}" 
                                   class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-primary transition-colors">
                                    <span class="truncate max-w-[200px]">{{ $laporan->file_original_name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            
            {{-- Pagination --}}
            @if($laporanTahunan->hasPages())
                <div class="mt-8">
                    {{ $laporanTahunan->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="bento-card text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-600">Laporan tahunan belum tersedia saat ini. Silakan kunjungi kembali nanti.</p>
            </div>
        @endif
    </div>
</div>
@endsection
