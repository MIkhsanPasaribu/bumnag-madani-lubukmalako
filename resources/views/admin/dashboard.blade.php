@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-bumnag-gray">Dashboard</h1>
        <p class="text-gray-500">Selamat datang di panel admin BUMNag Madani</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card-admin">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-bumnag-gray">{{ $stats['berita'] }}</p>
                    <p class="text-sm text-gray-500">Total Berita</p>
                </div>
            </div>
        </div>
        
        <div class="card-admin">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-bumnag-gray">{{ $stats['pengumuman'] }}</p>
                    <p class="text-sm text-gray-500">Total Pengumuman</p>
                </div>
            </div>
        </div>
        
        <div class="card-admin">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-bumnag-gray">Rp {{ number_format($stats['total_pendapatan']/1000000, 0, ',', '.') }}jt</p>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                </div>
            </div>
        </div>
        
        <div class="card-admin">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-bumnag-gray">{{ $stats['laporan'] }}</p>
                    <p class="text-sm text-gray-500">Laporan Keuangan</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card-admin">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-bumnag-gray">Berita Terbaru</h2>
                <a href="{{ route('admin.berita.index') }}" class="text-sm text-bumnag-olive hover:underline">Lihat Semua</a>
            </div>
            
            @if($beritaTerbaru->count() > 0)
            <div class="space-y-3">
                @foreach($beritaTerbaru as $item)
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-bumnag-gray truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-gray-500">{{ $item->published_at?->format('d M Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm text-center py-8">Belum ada berita</p>
            @endif
        </div>
        
        <div class="card-admin">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-bumnag-gray">Pengumuman Aktif</h2>
                <a href="{{ route('admin.pengumuman.index') }}" class="text-sm text-bumnag-olive hover:underline">Lihat Semua</a>
            </div>
            
            @if($pengumumanTerbaru->count() > 0)
            <div class="space-y-3">
                @foreach($pengumumanTerbaru as $item)
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ $item->prioritas === 'tinggi' ? 'bg-red-100' : ($item->prioritas === 'sedang' ? 'bg-yellow-100' : 'bg-green-100') }}">
                        <svg class="w-5 h-5 {{ $item->prioritas === 'tinggi' ? 'text-red-600' : ($item->prioritas === 'sedang' ? 'text-yellow-600' : 'text-green-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-bumnag-gray truncate">{{ $item->judul }}</p>
                        <p class="text-xs text-gray-500">{{ $item->tanggal_mulai->format('d M Y') }}</p>
                    </div>
                    <span class="badge {{ $item->prioritas === 'tinggi' ? 'badge-danger' : ($item->prioritas === 'sedang' ? 'badge-warning' : 'badge-success') }}">
                        {{ ucfirst($item->prioritas) }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm text-center py-8">Belum ada pengumuman aktif</p>
            @endif
        </div>
    </div>
</div>
@endsection
