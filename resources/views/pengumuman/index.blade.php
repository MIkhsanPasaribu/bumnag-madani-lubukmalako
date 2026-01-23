@extends('layouts.app')

@section('title', 'Pengumuman - BUMNag Madani Lubuk Malako')
@section('page-title', 'Pengumuman')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <div class="bento-card-red">
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div class="text-center sm:text-left">
                <h1 class="text-xl sm:text-2xl font-bold">Pengumuman</h1>
                <p class="text-white/80 text-sm sm:text-base">Informasi penting dari BUMNag Madani Lubuk Malako</p>
            </div>
        </div>
    </div>
    
    <div class="space-y-4">
        @forelse($pengumuman as $item)
        <div class="bento-card hover:shadow-lg transition-shadow">
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 sm:gap-4">
                <div class="shrink-0">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl flex items-center justify-center {{ $item->prioritas === 'tinggi' ? 'bg-red-100' : ($item->prioritas === 'sedang' ? 'bg-yellow-100' : 'bg-green-100') }}">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 {{ $item->prioritas === 'tinggi' ? 'text-red-600' : ($item->prioritas === 'sedang' ? 'text-yellow-600' : 'text-green-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
                        <h3 class="font-semibold text-sm lg:text-base text-bumnag-gray">{{ $item->judul }}</h3>
                        <span class="priority-badge shrink-0 self-start {{ $item->prioritas === 'tinggi' ? 'priority-tinggi' : ($item->prioritas === 'sedang' ? 'priority-sedang' : 'priority-rendah') }}">
                            {{ ucfirst($item->prioritas) }}
                        </span>
                    </div>
                    
                    <p class="text-xs lg:text-sm text-gray-600 mb-3 lg:mb-4">{{ $item->isi }}</p>
                    
                    <div class="flex flex-wrap items-center gap-3 lg:gap-4 text-xs lg:text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $item->tanggal_mulai->format('d M Y') }}
                            @if($item->tanggal_selesai)
                            - {{ $item->tanggal_selesai->format('d M Y') }}
                            @endif
                        </span>
                        
                        @if($item->lampiran)
                        <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="flex items-center gap-1 text-bumnag-olive hover:underline">
                            <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            Lampiran
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bento-card text-center py-12">
            <svg class="w-12 h-12 lg:w-16 lg:h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <h3 class="text-base lg:text-lg font-semibold text-gray-700 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-sm text-gray-500">Pengumuman akan ditampilkan setelah diterbitkan.</p>
        </div>
        @endforelse
    </div>
    
    @if($pengumuman->hasPages())
    <div class="flex justify-center">
        {{ $pengumuman->links() }}
    </div>
    @endif
</div>
@endsection
