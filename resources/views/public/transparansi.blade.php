@extends('layouts.public')

@section('title', 'Transparansi Keuangan')

@section('meta_description', 'Transparansi laporan keuangan BUMNag Madani Lubuk Malako. Lihat dan download laporan keuangan publik.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header with Gradient --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-8 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur rounded-full text-white/90 text-sm font-medium mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Akses Publik
            </div>
            <h1 class="text-2xl md:text-4xl font-bold text-white mb-3">Transparansi Keuangan</h1>
            <p class="text-white/80 max-w-2xl mx-auto text-sm md:text-base">
                Akses publik terhadap laporan keuangan BUMNag Madani Lubuk Malako untuk akuntabilitas dan transparansi pengelolaan dana.
            </p>
        </div>
    </div>
    
    {{-- Year Filter --}}
    <div class="flex justify-center mb-8">
        <div class="inline-flex items-center gap-1 bg-white rounded-xl shadow-sm border border-gray-200 p-1.5">
            @foreach($tahunTersedia as $tahun)
                <a href="{{ route('transparansi', ['tahun' => $tahun]) }}" 
                   class="px-5 py-2.5 text-sm font-semibold rounded-lg transition-all 
                          {{ $tahunFilter == $tahun ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $tahun }}
                </a>
            @endforeach
        </div>
    </div>
    
    {{-- Currency Note --}}
    <div class="flex justify-center mb-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Semua nilai dalam Rupiah (IDR)
        </span>
    </div>
    
    {{-- Summary Cards with Modern Design --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Pendapatan --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <p class="text-sm text-green-700 font-medium">Total Pendapatan</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-green-600">{{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Total Pengeluaran --}}
        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <p class="text-sm text-red-700 font-medium">Total Pengeluaran</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-red-600">{{ number_format($statistik['total_pengeluaran'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Laba/Rugi --}}
        <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-xl border border-primary/20 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-primary/20 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-sm text-primary font-medium">Laba/Rugi</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
            </p>
        </div>
        
        {{-- Total Transaksi --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-sm text-blue-700 font-medium">Total Transaksi</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-blue-600">{{ $statistik['jumlah_transaksi'] ?? 0 }}</p>
        </div>
    </div>
    
    {{-- Monthly Reports List - Modern Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-visible">
        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Laporan Bulanan</h2>
                    <p class="text-sm text-gray-500">Periode Tahun {{ $tahunFilter }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                {{-- Download Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Laporan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                         x-cloak
                         class="absolute right-0 bottom-full mb-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-[100] max-h-80 overflow-y-auto">
                        <div class="px-3 py-2 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">PDF</p>
                        </div>
                        <a href="{{ route('transparansi.download.tahunan', ['tahun' => $tahunFilter]) }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Tahun {{ $tahunFilter }}</p>
                                <p class="text-xs text-gray-500">Semua bulan di {{ $tahunFilter }}</p>
                            </div>
                        </a>
                        <a href="{{ route('transparansi.download.semua') }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Semua Data</p>
                                <p class="text-xs text-gray-500">Seluruh riwayat transaksi</p>
                            </div>
                        </a>
                        
                        <div class="px-3 py-2 border-t border-b border-gray-100 mt-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Excel</p>
                        </div>
                        <a href="{{ route('transparansi.excel.tahunan', ['tahun' => $tahunFilter]) }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Tahun {{ $tahunFilter }}</p>
                                <p class="text-xs text-gray-500">Semua bulan di {{ $tahunFilter }}</p>
                            </div>
                        </a>
                        <a href="{{ route('transparansi.excel.semua') }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Semua Data</p>
                                <p class="text-xs text-gray-500">Seluruh riwayat transaksi</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-medium rounded-md border border-amber-200">
                    <span class="font-bold">IDR</span>
                    <span class="text-amber-400">|</span>
                    <span>Rupiah</span>
                </span>
            </div>
        </div>
        
        @if(count($rekapBulanan) > 0)
            {{-- Desktop Table --}}
            <div class="hidden lg:block">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100">
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Transaksi</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Awal</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <span class="inline-flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Uang Masuk</span>
                            </th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <span class="inline-flex items-center gap-1"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Uang Keluar</span>
                            </th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Akhir</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($rekapBulanan as $rekap)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary font-bold text-sm">
                                            {{ str_pad($rekap['bulan'], 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">{{ $rekap['nama_bulan'] }}</span>
                                            <span class="text-gray-500">{{ $rekap['tahun'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-1 bg-gray-100 text-gray-700 font-semibold rounded-full text-sm">
                                        {{ $rekap['jumlah_transaksi'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right text-gray-600 font-medium">{{ number_format($rekap['saldo_awal'], 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        {{ number_format($rekap['total_masuk'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <span class="inline-flex items-center gap-1 text-red-600 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        {{ number_format($rekap['total_keluar'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <span class="font-bold text-lg {{ $rekap['selisih'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ number_format($rekap['saldo_akhir'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('statistik.detail', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('transparansi.download', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                           class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Download PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('transparansi.excel', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                           class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Download Excel">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gradient-to-r from-primary/5 to-primary/10 border-t-2 border-primary/20">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900">Total Tahun {{ $tahunFilter }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-1 bg-primary text-white font-bold rounded-full text-sm">
                                    {{ $statistik['jumlah_transaksi'] ?? 0 }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right text-gray-500">—</td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-bold text-green-600 text-lg">{{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-bold text-red-600 text-lg">{{ number_format($statistik['total_pengeluaran'] ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex flex-col items-end">
                                    <span class="font-bold text-xl {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs font-medium {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                        {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '✓ Surplus' : '✗ Defisit' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            {{-- Mobile Card View --}}
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($rekapBulanan as $rekap)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary font-bold text-sm">
                                    {{ str_pad($rekap['bulan'], 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $rekap['nama_bulan'] }}</span>
                                    <span class="text-gray-500">{{ $rekap['tahun'] }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                {{ $rekap['jumlah_transaksi'] }} trx
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="bg-green-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-green-600 mb-0.5">Masuk</p>
                                <p class="font-bold text-green-600 text-sm">{{ number_format($rekap['total_masuk'], 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-red-600 mb-0.5">Keluar</p>
                                <p class="font-bold text-red-600 text-sm">{{ number_format($rekap['total_keluar'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500">Saldo Akhir</p>
                                <p class="font-bold {{ $rekap['selisih'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                    {{ number_format($rekap['saldo_akhir'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex gap-1">
                                <a href="{{ route('statistik.detail', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                   class="p-2 text-blue-600 bg-blue-50 rounded-lg" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('transparansi.download', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                   class="p-2 text-red-600 bg-red-50 rounded-lg" title="PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('transparansi.excel', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                   class="p-2 text-green-600 bg-green-50 rounded-lg" title="Excel">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                {{-- Mobile Total --}}
                <div class="p-4 bg-gradient-to-r from-primary/5 to-primary/10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">Total {{ $tahunFilter }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-white/80 rounded-lg p-3 text-center">
                            <p class="text-xs text-green-600 mb-1">Masuk</p>
                            <p class="font-bold text-green-600">{{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white/80 rounded-lg p-3 text-center">
                            <p class="text-xs text-red-600 mb-1">Keluar</p>
                            <p class="font-bold text-red-600">{{ number_format($statistik['total_pengeluaran'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="bg-white/80 rounded-lg p-3 text-center">
                        <p class="text-sm text-gray-600 mb-1">Saldo Bersih</p>
                        <p class="font-bold text-xl {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                            {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-8">
                <x-empty-state 
                    title="Belum ada laporan"
                    :description="'Belum ada data transaksi keuangan untuk tahun ' . $tahunFilter"
                    icon="document"
                />
            </div>
        @endif
    </div>
    
    {{-- Info Box --}}
    <div class="mt-8 bg-gradient-to-r from-cream to-primary/5 rounded-xl border border-primary/20 p-5">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900 mb-1">Tentang Transparansi Keuangan</h4>
                <p class="text-sm text-gray-600">
                    Halaman ini menampilkan seluruh transaksi keuangan BUMNag Madani Lubuk Malako secara terbuka. 
                    Anda dapat melihat detail transaksi harian dan mengunduh laporan dalam format PDF untuk setiap periode.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
