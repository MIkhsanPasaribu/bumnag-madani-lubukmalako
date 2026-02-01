@extends('layouts.public')

@section('title', 'Statistik Keuangan')

@section('meta_description', 'Statistik dan grafik keuangan BUMNag Madani Lubuk Malako')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Statistik Keuangan</h1>
        <p class="text-gray-600 text-lg">Grafik dan analisis kinerja keuangan BUMNag Madani</p>
    </div>
    
    {{-- Year Filter --}}
    <div class="flex justify-center mb-8">
        <div class="inline-flex items-center gap-2 bg-white rounded-lg shadow-sm border border-gray-200 p-1">
            @foreach($tahunTersedia as $tahun)
                <a href="{{ route('statistik', ['tahun' => $tahun]) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                          {{ $tahunTerpilih == $tahun ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
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
    
    {{-- Summary Cards with Modern Bento Style --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        {{-- Total Pendapatan --}}
        <div class="stat-card-gradient green group">
            <div class="stat-icon bg-green-100 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Pendapatan</p>
                <p class="stat-value text-green-600">{{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                @if($growth['pendapatan'] != 0)
                    <div class="stat-change {{ $growth['pendapatan'] >= 0 ? 'positive' : 'negative' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($growth['pendapatan'] >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            @endif
                        </svg>
                        {{ number_format(abs($growth['pendapatan']), 1) }}% vs {{ $tahunSebelumnya }}
                    </div>
                @else
                    <div class="stat-change neutral">Tidak ada data sebelumnya</div>
                @endif
            </div>
        </div>
        
        {{-- Total Pengeluaran --}}
        <div class="stat-card-gradient red group">
            <div class="stat-icon bg-red-100 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Pengeluaran</p>
                <p class="stat-value text-red-600">{{ number_format($statistik['total_pengeluaran'] ?? 0, 0, ',', '.') }}</p>
                @if($growth['pengeluaran'] != 0)
                    <div class="stat-change {{ $growth['pengeluaran'] <= 0 ? 'positive' : 'negative' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($growth['pengeluaran'] >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            @endif
                        </svg>
                        {{ number_format(abs($growth['pengeluaran']), 1) }}% vs {{ $tahunSebelumnya }}
                    </div>
                @else
                    <div class="stat-change neutral">Tidak ada data sebelumnya</div>
                @endif
            </div>
        </div>
        
        {{-- Laba/Rugi --}}
        <div class="stat-card-gradient {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'primary' : 'red' }} group">
            <div class="stat-icon {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'bg-primary/10' : 'bg-red-100' }} group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Laba / Rugi</p>
                <p class="stat-value {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                    {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
                </p>
                <div class="stat-change {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'Untung' : 'Rugi' }} tahun ini
                </div>
            </div>
        </div>
        
        {{-- Jumlah Laporan --}}
        <div class="stat-card-gradient blue group">
            <div class="stat-icon bg-blue-100 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Data Tersedia</p>
                <p class="stat-value text-blue-600">{{ $statistik['jumlah_laporan'] ?? 0 }} <span class="text-lg font-medium">Bulan</span></p>
                <div class="stat-change neutral">
                    {{ $statistik['jumlah_transaksi'] ?? 0 }} total transaksi
                </div>
            </div>
        </div>
    </div>
    
    {{-- Charts Section --}}
    <div class="grid lg:grid-cols-2 gap-6 mb-10">
        {{-- Bar Chart --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Pendapatan vs Pengeluaran</h3>
            <div class="h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        
        {{-- Line Chart --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Laba/Rugi Bulanan</h3>
            <div class="h-80">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
    
    {{-- Rasio & Proyeksi Section --}}
    <div class="grid md:grid-cols-2 gap-6 mb-10">
        {{-- Rasio Keuangan --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Rasio Keuangan</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Expense Ratio</span>
                        <span class="text-sm font-medium {{ $rasio['expense_ratio'] <= 80 ? 'text-green-600' : ($rasio['expense_ratio'] <= 100 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ number_format($rasio['expense_ratio'], 1) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-secondary h-2 rounded-full transition-all duration-500" style="width: {{ min($rasio['expense_ratio'], 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Persentase pengeluaran terhadap pendapatan</p>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Profit Margin</span>
                        <span class="text-sm font-medium {{ $rasio['profit_margin'] >= 20 ? 'text-green-600' : ($rasio['profit_margin'] >= 0 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ number_format($rasio['profit_margin'], 1) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full transition-all duration-500" style="width: {{ max(0, min($rasio['profit_margin'], 100)) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Persentase laba terhadap pendapatan</p>
                </div>
            </div>
        </div>
        
        {{-- Proyeksi --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📈 Proyeksi Akhir Tahun</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="text-sm text-gray-600">Proyeksi Pendapatan</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($proyeksi['pendapatan_tahunan'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="text-sm text-gray-600">Proyeksi Pengeluaran</span>
                    <span class="font-bold text-red-600">Rp {{ number_format($proyeksi['pengeluaran_tahunan'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 {{ $proyeksi['laba_proyeksi'] >= 0 ? 'bg-primary/10' : 'bg-red-100' }} rounded-lg">
                    <span class="text-sm text-gray-600">Proyeksi Laba</span>
                    <span class="font-bold {{ $proyeksi['laba_proyeksi'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                        {{ $proyeksi['laba_proyeksi'] >= 0 ? '+' : '' }}Rp {{ number_format($proyeksi['laba_proyeksi'], 0, ',', '.') }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    * Berdasarkan rata-rata: Pendapatan Rp {{ number_format($proyeksi['avg_monthly_income'], 0, ',', '.') }}/bulan, 
                    Pengeluaran Rp {{ number_format($proyeksi['avg_monthly_expense'], 0, ',', '.') }}/bulan
                </p>
            </div>
        </div>
    </div>
    
    {{-- Additional Charts Section: Pie & Doughnut --}}
    <div class="grid lg:grid-cols-3 gap-6 mb-10">
        {{-- Doughnut Chart - Proporsi Pendapatan vs Pengeluaran --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Proporsi Masuk vs Keluar</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
            <div class="mt-4 text-center">
                <div class="flex justify-center gap-4 text-sm">
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-primary"></span>
                        <span>Pendapatan</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-secondary"></span>
                        <span>Pengeluaran</span>
                    </span>
                </div>
            </div>
        </div>
        
        {{-- Pie Chart - Kategori Pemasukan --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori Pemasukan</h3>
            @if(count($kategoriPemasukan) > 0)
                <div class="h-64 flex items-center justify-center">
                    <canvas id="pieChartMasuk"></canvas>
                </div>
            @else
                <div class="h-64 flex items-center justify-center text-gray-500">
                    <p>Belum ada data kategori</p>
                </div>
            @endif
        </div>
        
        {{-- Pie Chart - Kategori Pengeluaran --}}
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori Pengeluaran</h3>
            @if(count($kategoriPengeluaran) > 0)
                <div class="h-64 flex items-center justify-center">
                    <canvas id="pieChartKeluar"></canvas>
                </div>
            @else
                <div class="h-64 flex items-center justify-center text-gray-500">
                    <p>Belum ada data kategori</p>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Data Table - Modern Card Style --}}
    <div class="bento-card overflow-visible">
        {{-- Header with gradient --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Rekap Laporan Bulanan</h3>
                    <p class="text-sm text-gray-500">Periode Tahun {{ $tahunTerpilih }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 bg-primary/10 text-primary font-medium rounded-full text-sm">
                    {{ count($rekapBulanan) }} Bulan Tercatat
                </span>
                
                {{-- Download Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition 
                         class="absolute right-0 bottom-full mb-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-[100]">
                        <div class="px-3 py-2 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">PDF</p>
                        </div>
                        <a href="{{ route('transparansi.download.tahunan', ['tahun' => $tahunTerpilih]) }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Tahun {{ $tahunTerpilih }}</p>
                                <p class="text-xs text-gray-500">Semua bulan di {{ $tahunTerpilih }}</p>
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
                        <a href="{{ route('transparansi.excel.tahunan', ['tahun' => $tahunTerpilih]) }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-medium">Tahun {{ $tahunTerpilih }}</p>
                                <p class="text-xs text-gray-500">Semua bulan di {{ $tahunTerpilih }}</p>
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
            </div>
        </div>
        
        @if(count($rekapBulanan) > 0)
            {{-- Currency Note for Table --}}
            <div class="flex items-center justify-end mb-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-medium rounded-md border border-amber-200">
                    <span class="font-bold">IDR</span>
                    <span class="text-amber-500">|</span>
                    <span>Rupiah Indonesia</span>
                </span>
            </div>
            
            {{-- Desktop Table View --}}
            <div class="hidden lg:block overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Periode
                                </div>
                            </th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Transaksi</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Saldo Awal</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    Uang Masuk
                                </span>
                            </th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <span class="inline-flex items-center gap-1">
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    Uang Keluar
                                </span>
                            </th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Saldo Akhir</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rekapBulanan as $index => $rekap)
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
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded-full text-sm">
                                        {{ $rekap['jumlah_transaksi'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right text-gray-600 font-medium">
                                    {{ number_format($rekap['saldo_awal'], 0, ',', '.') }}
                                </td>
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
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('statistik.detail', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                       class="inline-flex items-center gap-1 px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg text-sm font-medium transition-all group-hover:shadow-md">
                                        <span>Detail</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
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
                                    <span class="font-bold text-gray-900 text-lg">Total Keseluruhan</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] px-3 py-1 bg-primary text-white font-bold rounded-full text-sm">
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
                                <div class="inline-flex flex-col items-end">
                                    <span class="font-bold text-xl {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-500' }}">
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
            <div class="lg:hidden space-y-4">
                @foreach($rekapBulanan as $rekap)
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                        {{-- Card Header --}}
                        <div class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary font-bold">
                                    {{ str_pad($rekap['bulan'], 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <span class="font-bold text-gray-900">{{ $rekap['nama_bulan'] }}</span>
                                    <span class="text-gray-500">{{ $rekap['tahun'] }}</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-semibold">
                                {{ $rekap['jumlah_transaksi'] }} transaksi
                            </span>
                        </div>
                        
                        {{-- Card Body --}}
                        <div class="p-4 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-green-50 rounded-lg p-3">
                                    <p class="text-xs text-green-600 mb-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                        Uang Masuk
                                    </p>
                                    <p class="font-bold text-green-600">{{ number_format($rekap['total_masuk'], 0, ',', '.') }}</p>
                                </div>
                                <div class="bg-red-50 rounded-lg p-3">
                                    <p class="text-xs text-red-600 mb-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                        Uang Keluar
                                    </p>
                                    <p class="font-bold text-red-600">{{ number_format($rekap['total_keluar'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Saldo Akhir</p>
                                    <p class="font-bold text-lg {{ $rekap['selisih'] >= 0 ? 'text-primary' : 'text-red-600' }}">
                                        {{ number_format($rekap['saldo_akhir'], 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('statistik.detail', ['bulan' => $rekap['bulan'], 'tahun' => $rekap['tahun']]) }}" 
                                   class="inline-flex items-center gap-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                                    <span>Lihat Detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                {{-- Mobile Total Card --}}
                <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl border-2 border-primary/20 overflow-hidden">
                    <div class="px-4 py-3 bg-primary/10 border-b border-primary/20">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="font-bold text-gray-900">Total Keseluruhan</span>
                            <span class="ml-auto px-2 py-0.5 bg-primary text-white text-xs font-bold rounded-full">
                                {{ $statistik['jumlah_transaksi'] ?? 0 }} transaksi
                            </span>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white/80 rounded-lg p-3">
                                <p class="text-xs text-green-600 mb-1">Total Masuk</p>
                                <p class="font-bold text-green-600">{{ number_format($statistik['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white/80 rounded-lg p-3">
                                <p class="text-xs text-red-600 mb-1">Total Keluar</p>
                                <p class="font-bold text-red-600">{{ number_format($statistik['total_pengeluaran'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="bg-white/80 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 mb-1">Saldo Bersih</p>
                            <p class="font-bold text-2xl {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                                {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}{{ number_format(abs($statistik['total_laba_rugi'] ?? 0), 0, ',', '.') }}
                            </p>
                            <span class="inline-block mt-1 text-xs font-medium {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ ($statistik['total_laba_rugi'] ?? 0) >= 0 ? '✓ Surplus Keuangan' : '✗ Defisit Keuangan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <x-empty-state 
                title="Tidak ada data"
                :description="'Belum ada transaksi untuk tahun ' . $tahunTerpilih"
                icon="document"
            />
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    
    // Bar Chart - Pendapatan vs Pengeluaran
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData.pendapatan,
                    backgroundColor: 'rgba(134, 174, 95, 0.8)',
                    borderColor: 'rgb(134, 174, 95)',
                    borderWidth: 1,
                    borderRadius: 4
                },
                {
                    label: 'Pengeluaran',
                    data: chartData.pengeluaran,
                    backgroundColor: 'rgba(183, 30, 66, 0.8)',
                    borderColor: 'rgb(183, 30, 66)',
                    borderWidth: 1,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
    
    // Line Chart - Laba/Rugi
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Laba/Rugi',
                data: chartData.laba_rugi,
                borderColor: 'rgb(134, 174, 95)',
                backgroundColor: 'rgba(134, 174, 95, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(134, 174, 95)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed.y;
                            const prefix = value >= 0 ? '+' : '';
                            return context.dataset.label + ': ' + prefix + 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
    
    // Doughnut Chart - Proporsi Pendapatan vs Pengeluaran
    const proporsiData = @json($proporsiData);
    const doughnutCtx = document.getElementById('doughnutChart');
    if (doughnutCtx) {
        new Chart(doughnutCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: proporsiData.labels,
                datasets: [{
                    data: proporsiData.data,
                    backgroundColor: proporsiData.colors,
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed) + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Pie Chart - Kategori Pemasukan
    const kategoriPemasukan = @json($kategoriPemasukan);
    const pieCtxMasuk = document.getElementById('pieChartMasuk');
    if (pieCtxMasuk && kategoriPemasukan.length > 0) {
        new Chart(pieCtxMasuk.getContext('2d'), {
            type: 'pie',
            data: {
                labels: kategoriPemasukan.map(k => k.nama),
                datasets: [{
                    data: kategoriPemasukan.map(k => k.total),
                    backgroundColor: kategoriPemasukan.map(k => k.warna),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: { size: 10 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed);
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Pie Chart - Kategori Pengeluaran
    const kategoriPengeluaran = @json($kategoriPengeluaran);
    const pieCtxKeluar = document.getElementById('pieChartKeluar');
    if (pieCtxKeluar && kategoriPengeluaran.length > 0) {
        new Chart(pieCtxKeluar.getContext('2d'), {
            type: 'pie',
            data: {
                labels: kategoriPengeluaran.map(k => k.nama),
                datasets: [{
                    data: kategoriPengeluaran.map(k => k.total),
                    backgroundColor: kategoriPengeluaran.map(k => k.warna),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: { size: 10 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed);
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
