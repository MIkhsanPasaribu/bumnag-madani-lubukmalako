@extends('layouts.public')

@section('title', 'Detail Buku Kas - ' . ($rekap['nama_bulan'] ?? '') . ' ' . $tahun)

@section('meta_description', 'Detail transaksi kas harian BUMNag Madani Lubuk Malako periode ' . ($rekap['nama_bulan'] ?? '') . ' ' . $tahun)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header with Gradient Background --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-8 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-start gap-4">
                    <a href="{{ route('statistik', ['tahun' => $tahun]) }}" 
                       class="flex-shrink-0 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <p class="text-white/80 text-sm mb-1">Buku Kas Harian</p>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $rekap['nama_bulan'] ?? '' }} {{ $tahun }}</h1>
                        <p class="text-white/70 text-sm mt-2">BUMNag Madani Lubuk Malako</p>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-2">
                    <button onclick="window.print()" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm" 
                            title="Cetak Halaman">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span class="hidden sm:inline">Print</span>
                    </button>
                    
                    <a href="https://wa.me/?text=Lihat%20laporan%20keuangan%20BUMNag%20Madani%20Lubuk%20Malako%20periode%20{{ $rekap['nama_bulan'] ?? '' }}%20{{ $tahun }}%20%0A{{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm" 
                       title="Share via WhatsApp">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.019-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="hidden sm:inline">Share</span>
                    </a>
                    
                    {{-- Download Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition-colors backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="hidden sm:inline">Excel</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('transparansi.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                <span class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Bulan Ini</p>
                                    <p class="text-xs text-gray-500">{{ $rekap['nama_bulan'] ?? '' }} {{ $tahun }}</p>
                                </div>
                            </a>
                            <a href="{{ route('transparansi.excel.tahunan', ['tahun' => $tahun]) }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                <span class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Tahun {{ $tahun }}</p>
                                    <p class="text-xs text-gray-500">Semua bulan</p>
                                </div>
                            </a>
                            <a href="{{ route('transparansi.excel.semua') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                <span class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Semua Data</p>
                                    <p class="text-xs text-gray-500">Seluruh riwayat</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    {{-- PDF Download Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-primary hover:bg-gray-100 rounded-lg text-sm font-semibold transition-colors shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="hidden sm:inline">PDF</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('transparansi.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <span class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Bulan Ini</p>
                                    <p class="text-xs text-gray-500">{{ $rekap['nama_bulan'] ?? '' }} {{ $tahun }}</p>
                                </div>
                            </a>
                            <a href="{{ route('transparansi.download.tahunan', ['tahun' => $tahun]) }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <span class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Tahun {{ $tahun }}</p>
                                    <p class="text-xs text-gray-500">Semua bulan</p>
                                </div>
                            </a>
                            <a href="{{ route('transparansi.download.semua') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <span class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-medium">Semua Data</p>
                                    <p class="text-xs text-gray-500">Seluruh riwayat</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Summary Cards with Modern Design --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Saldo Awal --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">Saldo Awal</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-gray-700">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Total Masuk --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <p class="text-sm text-green-700 font-medium">Total Masuk</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-green-600">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Total Keluar --}}
        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <p class="text-sm text-red-700 font-medium">Total Keluar</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-red-600">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Saldo Akhir --}}
        <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-xl border border-primary/20 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm text-primary font-medium">Saldo Akhir</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-primary">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
    
    {{-- Currency Note --}}
    <div class="flex justify-center mb-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 text-xs font-medium rounded-full border border-amber-200">
            <span class="font-bold">IDR</span>
            <span class="text-amber-400">|</span>
            <span>Semua nilai dalam Rupiah Indonesia</span>
        </span>
    </div>
    
    {{-- Table Buku Kas - Modern Design --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-500">Periode {{ $rekap['nama_bulan'] ?? '' }} {{ $tahun }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 bg-primary/10 text-primary text-sm font-semibold rounded-full">
                    {{ $rekap['jumlah_transaksi'] ?? 0 }} Transaksi
                </span>
            </div>
        </div>
        
        @if($transaksi->count() > 0)
            {{-- Desktop Table View --}}
            <div class="hidden lg:block">
                <div class="overflow-x-auto scrollbar-thin" id="tableWrapper">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100">
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">No KW</th>
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Tanggal</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Uraian</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Kategori</th>
                                <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Masuk
                                    </span>
                                </th>
                                <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        Keluar
                                    </span>
                                </th>
                                <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            {{-- Saldo Awal Row --}}
                            <tr class="bg-gradient-to-r from-blue-50/50 to-indigo-50/50">
                                <td colspan="5" class="px-4 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-blue-900">Saldo Awal Bulan</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-right text-gray-400">—</td>
                                <td class="px-4 py-3.5 text-right text-gray-400">—</td>
                                <td class="px-4 py-3.5 text-right font-bold text-blue-600 text-lg">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            
                            @foreach($transaksi as $index => $trx)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-100 group-hover:bg-primary/10 text-gray-600 group-hover:text-primary text-xs font-semibold rounded-lg transition-colors">
                                            {{ $trx->no_urut }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="text-sm text-gray-500 font-mono">{{ $trx->no_kwitansi ?? '—' }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="text-sm text-gray-700">{{ $trx->tanggal->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="text-sm text-gray-800">{{ $trx->uraian }}</span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        @if($trx->kategori)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium" 
                                                  style="background-color: {{ $trx->kategori->warna }}15; color: {{ $trx->kategori->warna }}; border: 1px solid {{ $trx->kategori->warna }}30;">
                                                {{ $trx->kategori->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        @if($trx->uang_masuk > 0)
                                            <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                </svg>
                                                {{ number_format($trx->uang_masuk, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        @if($trx->uang_keluar > 0)
                                            <span class="inline-flex items-center gap-1 text-red-600 font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                </svg>
                                                {{ number_format($trx->uang_keluar, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <span class="font-bold text-primary text-base">{{ number_format($trx->saldo, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gradient-to-r from-primary/5 to-primary/10 border-t-2 border-primary/20">
                                <td colspan="5" class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="font-bold text-gray-900 text-base">Total Keseluruhan</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="font-bold text-green-600 text-lg">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="font-bold text-red-600 text-lg">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="font-bold text-primary text-xl">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</span>
                                        <span class="text-xs text-green-600 font-medium">✓ Saldo Akhir</span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            {{-- Mobile Card View --}}
            <div class="lg:hidden divide-y divide-gray-100">
                {{-- Saldo Awal Card --}}
                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <span class="font-semibold text-blue-900 text-sm">Saldo Awal Bulan</span>
                        </div>
                        <span class="font-bold text-blue-600 text-lg">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                @foreach($transaksi as $trx)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 font-bold text-sm">
                                {{ $trx->no_urut }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 line-clamp-2">{{ $trx->uraian }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500">{{ $trx->tanggal->format('d/m/Y') }}</span>
                                            @if($trx->no_kwitansi)
                                                <span class="text-xs text-gray-400 font-mono">{{ $trx->no_kwitansi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($trx->kategori)
                                        <span class="flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" 
                                              style="background-color: {{ $trx->kategori->warna }}15; color: {{ $trx->kategori->warna }}">
                                            {{ $trx->kategori->nama }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    <div class="flex items-center gap-4">
                                        @if($trx->uang_masuk > 0)
                                            <div class="flex items-center gap-1 text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                </svg>
                                                <span class="text-sm font-semibold">{{ number_format($trx->uang_masuk, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        @if($trx->uang_keluar > 0)
                                            <div class="flex items-center gap-1 text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                </svg>
                                                <span class="text-sm font-semibold">{{ number_format($trx->uang_keluar, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400">Saldo</p>
                                        <p class="font-bold text-primary">{{ number_format($trx->saldo, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                {{-- Total Card --}}
                <div class="p-4 bg-gradient-to-r from-primary/5 to-primary/10">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">Total Keseluruhan</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-white/80 rounded-lg p-3 text-center">
                            <p class="text-xs text-green-600 mb-1">Total Masuk</p>
                            <p class="font-bold text-green-600">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white/80 rounded-lg p-3 text-center">
                            <p class="text-xs text-red-600 mb-1">Total Keluar</p>
                            <p class="font-bold text-red-600">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="bg-white/80 rounded-lg p-3 text-center">
                        <p class="text-sm text-gray-600 mb-1">Saldo Akhir</p>
                        <p class="font-bold text-2xl text-primary">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-8">
                <x-empty-state 
                    title="Tidak ada transaksi"
                    description="Belum ada transaksi kas untuk periode ini."
                    icon="document"
                />
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scroll indicator for mobile
    const tableWrapper = document.getElementById('tableWrapper');
    const scrollIndicator = document.getElementById('scrollIndicator');
    
    if (tableWrapper && scrollIndicator) {
        function checkScroll() {
            if (tableWrapper.scrollWidth > tableWrapper.clientWidth && tableWrapper.scrollLeft < 10) {
                scrollIndicator.classList.remove('hidden');
            } else {
                scrollIndicator.classList.add('hidden');
            }
        }
        
        checkScroll();
        tableWrapper.addEventListener('scroll', checkScroll);
        window.addEventListener('resize', checkScroll);
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        .btn-outline, .btn-primary, nav, footer, .scroll-indicator {
            display: none !important;
        }
        .bento-card {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }
    }
    
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endpush
