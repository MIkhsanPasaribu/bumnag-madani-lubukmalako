@extends('layouts.app')

@section('title', 'Transparansi Keuangan - BUMNag Madani Lubuk Malako')
@section('page-title', 'Transparansi Keuangan')

@section('content')
<div class="space-y-8">
    <div class="bento-card-accent">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Transparansi Keuangan</h1>
                <p class="text-white/80">Laporan keuangan BUMNag Madani Lubuk Malako yang dapat diakses oleh publik</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($laporanKeuangan as $laporan)
        <div class="bento-card hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-bumnag-olive/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-bumnag-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium bg-bumnag-olive/10 text-bumnag-olive px-2 py-1 rounded-full">
                    {{ $laporan->tahun }}
                </span>
            </div>
            
            <h3 class="font-semibold text-bumnag-gray mb-2">{{ $laporan->periode }}</h3>
            @if($laporan->bulan)
            <p class="text-sm text-gray-500 mb-4">{{ $laporan->bulan }} {{ $laporan->tahun }}</p>
            @endif
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Pendapatan</span>
                    <span class="font-medium text-bumnag-olive">Rp {{ number_format($laporan->pendapatan, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Pengeluaran</span>
                    <span class="font-medium text-bumnag-red">Rp {{ number_format($laporan->pengeluaran, 0, ',', '.') }}</span>
                </div>
                <div class="border-t pt-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Laba/Rugi</span>
                        <span class="font-bold {{ $laporan->laba_rugi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($laporan->laba_rugi, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if($laporan->keterangan)
            <p class="text-sm text-gray-500 mb-4">{{ Str::limit($laporan->keterangan, 100) }}</p>
            @endif
            
            @if($laporan->dokumen)
            <a href="{{ asset('storage/' . $laporan->dokumen) }}" target="_blank" class="btn-outline w-full text-sm py-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Unduh Dokumen
            </a>
            @endif
        </div>
        @empty
        <div class="col-span-full">
            <div class="bento-card text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-500">Laporan keuangan akan ditampilkan di sini setelah dipublikasikan.</p>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($laporanKeuangan->hasPages())
    <div class="flex justify-center">
        {{ $laporanKeuangan->links() }}
    </div>
    @endif
</div>
@endsection
