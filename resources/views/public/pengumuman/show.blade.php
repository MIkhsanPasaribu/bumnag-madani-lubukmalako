@extends('layouts.public')

@section('title', $pengumuman->judul)

@section('meta_description', Str::limit(strip_tags($pengumuman->konten), 160))

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <header class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            @if($pengumuman->prioritas === 'tinggi')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                    Prioritas {{ ucfirst($pengumuman->prioritas) }}
                </span>
            @elseif($pengumuman->prioritas === 'sedang')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">
                    Prioritas {{ ucfirst($pengumuman->prioritas) }}
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                    Prioritas {{ ucfirst($pengumuman->prioritas) }}
                </span>
            @endif
        </div>
        
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $pengumuman->judul }}</h1>
        
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Berlaku: {{ $pengumuman->tanggal_mulai->format('d F Y') }}
                @if($pengumuman->tanggal_berakhir)
                    - {{ $pengumuman->tanggal_berakhir->format('d F Y') }}
                @endif
            </span>
        </div>
    </header>
    
    {{-- Content --}}
    <div class="prose prose-lg prose-gray max-w-none mb-8">
        {!! nl2br(e($pengumuman->konten)) !!}
    </div>
    
    {{-- Attachment --}}
    @if($pengumuman->lampiran)
        <div class="bento-card bg-gray-50 mb-8">
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                Lampiran
            </h3>
            <a href="{{ $pengumuman->lampiran_url }}" 
               target="_blank" 
               class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Unduh Lampiran
            </a>
        </div>
    @endif
    
    {{-- Other Announcements --}}
    @if($pengumumanLain->count() > 0)
        <section class="border-t pt-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Pengumuman Lainnya</h2>
            <div class="space-y-4">
                @foreach($pengumumanLain as $item)
                    <article class="bento-card flex gap-4 group">
                        <div class="flex-shrink-0">
                            @if($item->prioritas === 'tinggi')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    {{ ucfirst($item->prioritas) }}
                                </span>
                            @elseif($item->prioritas === 'sedang')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    {{ ucfirst($item->prioritas) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    {{ ucfirst($item->prioritas) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 group-hover:text-primary transition-colors line-clamp-1">
                                <a href="{{ route('pengumuman.show', $item->slug) }}">{{ $item->judul }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $item->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
    
    {{-- Back Button --}}
    <div class="mt-10">
        <a href="{{ route('pengumuman.index') }}" class="btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Pengumuman
        </a>
    </div>
</article>
@endsection
