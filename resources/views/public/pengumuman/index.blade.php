@extends('layouts.public')

@section('title', 'Pengumuman')

@section('meta_description', 'Pengumuman dan informasi penting dari BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengumuman</h1>
        <p class="text-gray-600 text-lg">Informasi penting dari BUMNag Madani</p>
    </div>
    
    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        {{-- Priority Filter --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('pengumuman.index') }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('prioritas') ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'tinggi']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('prioritas') == 'tinggi' ? 'bg-secondary text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                Prioritas Tinggi
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'sedang']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('prioritas') == 'sedang' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                Prioritas Sedang
            </a>
            <a href="{{ route('pengumuman.index', ['prioritas' => 'rendah']) }}" 
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('prioritas') == 'rendah' ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                Prioritas Rendah
            </a>
        </div>
        
        {{-- Search --}}
        <form action="{{ route('pengumuman.index') }}" method="GET" class="relative w-full sm:w-64">
            <input type="text" 
                   name="cari" 
                   value="{{ request('cari') }}"
                   placeholder="Cari pengumuman..." 
                   class="form-input pl-10 pr-4 w-full text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if(request('prioritas'))
                <input type="hidden" name="prioritas" value="{{ request('prioritas') }}">
            @endif
        </form>
    </div>
    
    {{-- Announcements List --}}
    @if($pengumuman->count() > 0)
        <div class="space-y-4">
            @foreach($pengumuman as $item)
                <article class="bento-card flex flex-col md:flex-row gap-4 group">
                    {{-- Priority Badge --}}
                    <div class="flex-shrink-0">
                        <x-prioritas-badge :prioritas="$item->prioritas" />
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-primary transition-colors">
                            <a href="{{ route('pengumuman.show', $item->slug) }}">{{ $item->judul }}</a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ Str::limit(strip_tags($item->konten), 200) }}</p>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $item->tanggal_mulai->format('d M Y') }}
                                @if($item->tanggal_berakhir)
                                    - {{ $item->tanggal_berakhir->format('d M Y') }}
                                @endif
                            </span>
                            
                            @if($item->lampiran)
                                <span class="flex items-center gap-1 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Ada Lampiran
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Action --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('pengumuman.show', $item->slug) }}" class="btn-ghost text-primary text-sm">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="mt-8">
            {{ $pengumuman->links('components.pagination') }}
        </div>
    @else
        <x-empty-state 
            :title="request('cari') ? 'Tidak ada hasil' : 'Belum ada pengumuman'"
            :description="request('cari') ? 'Tidak ditemukan pengumuman yang sesuai dengan kata kunci \"' . request('cari') . '\"' : 'Pengumuman penting akan tampil di sini.'"
            icon="document"
        />
    @endif
</div>
@endsection
