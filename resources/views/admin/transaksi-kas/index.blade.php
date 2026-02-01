@extends('layouts.admin')

@section('title', 'Buku Kas Harian')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buku Kas Harian</h1>
            <p class="text-gray-600 mt-1">Transaksi Kas Plasma Lubuk Malako</p>
        </div>
        <div class="flex flex-wrap gap-2">
            {{-- Export Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.outside="open = false"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 rounded-lg transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition 
                     class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">PDF</p>
                    </div>
                    @if($bulanFilter)
                    <a href="{{ route('admin.transaksi-kas.export-pdf', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Bulan Ini</p>
                            <p class="text-xs text-gray-500">{{ \App\Models\TransaksiKas::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}</p>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('admin.transaksi-kas.export-pdf', ['tahun' => $tahunFilter]) }}" 
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
                    <a href="{{ route('admin.transaksi-kas.export-pdf') }}" 
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
                    @if($bulanFilter)
                    <a href="{{ route('admin.transaksi-kas.export-excel', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium">Bulan Ini</p>
                            <p class="text-xs text-gray-500">{{ \App\Models\TransaksiKas::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}</p>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('admin.transaksi-kas.export-excel', ['tahun' => $tahunFilter]) }}" 
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
                    <a href="{{ route('admin.transaksi-kas.export-excel') }}" 
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
            
            <a href="{{ route('admin.transaksi-kas.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-dark rounded-lg shadow-md shadow-primary/25 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Transaksi
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{-- Horizontal Filter Bar --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            {{-- Filter Controls --}}
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="text-sm font-medium">Filter:</span>
                </div>
                
                {{-- Year Pills --}}
                <div class="flex items-center gap-1.5">
                    @foreach($tahunTersedia as $tahun)
                        <a href="{{ route('admin.transaksi-kas.index', ['tahun' => $tahun]) }}" 
                           class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ $tahunFilter == $tahun && !$bulanFilter ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $tahun }}
                        </a>
                    @endforeach
                </div>
                
                {{-- Divider --}}
                @if(!empty($bulanTersedia))
                <div class="hidden lg:block w-px h-6 bg-gray-200"></div>
                
                {{-- Month Pills with horizontal scroll --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full lg:max-w-xl scrollbar-thin">
                    <a href="{{ route('admin.transaksi-kas.index', ['tahun' => $tahunFilter]) }}" 
                       class="flex-shrink-0 px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ !$bulanFilter ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    @foreach($bulanTersedia as $bln)
                        <a href="{{ route('admin.transaksi-kas.index', ['tahun' => $tahunFilter, 'bulan' => $bln]) }}" 
                           class="flex-shrink-0 px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ $bulanFilter == $bln ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ substr(\App\Models\TransaksiKas::$namaBulan[$bln] ?? $bln, 0, 3) }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
            
            {{-- Quick Actions --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.transaksi-kas.activity') }}" 
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Log
                </a>
                <a href="{{ route('admin.transaksi-kas.recalculate') }}" 
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-orange-600 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors"
                   onclick="return confirm('Hitung ulang semua saldo?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Recalculate
                </a>
            </div>
        </div>
    </div>

    {{-- Summary Cards Full Width --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        {{-- Period Info --}}
        <div class="col-span-2 lg:col-span-1 bg-gradient-to-br from-cream to-amber-50 rounded-xl border border-amber-200 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm text-amber-700 font-medium">Periode</p>
            </div>
            <p class="text-lg font-bold text-amber-800">
                @if($bulanFilter)
                    {{ \App\Models\TransaksiKas::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}
                @else
                    Tahun {{ $tahunFilter }}
                @endif
            </p>
            <p class="text-xs text-amber-600 mt-1">{{ $rekap['jumlah_transaksi'] ?? 0 }} transaksi</p>
        </div>
        
        {{-- Saldo Awal --}}
        <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-600 font-medium">Saldo Awal</p>
            </div>
            <p class="text-xl font-bold text-gray-700">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Uang Masuk --}}
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <p class="text-sm text-green-700 font-medium">Uang Masuk</p>
            </div>
            <p class="text-xl font-bold text-green-600">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Uang Keluar --}}
        <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <p class="text-sm text-red-700 font-medium">Uang Keluar</p>
            </div>
            <p class="text-xl font-bold text-red-600">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</p>
        </div>
        
        {{-- Saldo Akhir --}}
        <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-xl border border-primary/30 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm text-primary font-medium">Saldo Akhir</p>
            </div>
            <p class="text-xl font-bold text-primary">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Table Buku Kas --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        {{-- Table Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg shadow-primary/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-500">
                        @if($bulanFilter)
                            {{ \App\Models\TransaksiKas::$namaBulan[$bulanFilter] ?? '' }} {{ $tahunFilter }}
                        @else
                            Tahun {{ $tahunFilter }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center min-w-[2rem] px-3 py-1.5 bg-primary text-white font-bold rounded-full text-sm">
                    {{ $rekap['jumlah_transaksi'] ?? 0 }}
                </span>
                <span class="text-sm text-gray-500">transaksi</span>
            </div>
        </div>
        
        @if($transaksi->count() > 0)
            {{-- Desktop Table --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100">
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">No KW</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Tanggal</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Uraian</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Kategori</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">
                                <span class="inline-flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Masuk</span>
                            </th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">
                                <span class="inline-flex items-center gap-1"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Keluar</span>
                            </th>
                            <th class="px-4 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">Saldo</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($transaksi as $trx)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-4 py-3.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[1.75rem] px-2 py-0.5 bg-gray-100 text-gray-700 font-semibold rounded text-sm">
                                        {{ $trx->no_urut }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-center text-sm text-gray-600">{{ $trx->no_kwitansi ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-center text-sm text-gray-600">{{ $trx->tanggal_formatted }}</td>
                                <td class="px-4 py-3.5 text-sm">
                                    <div class="max-w-xs truncate text-gray-800" title="{{ $trx->uraian }}">
                                        {{ $trx->uraian }}
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-sm">
                                    @if($trx->kategori)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium" 
                                              style="background-color: {{ $trx->kategori->warna }}15; color: {{ $trx->kategori->warna }}; border: 1px solid {{ $trx->kategori->warna }}30">
                                            {{ $trx->kategori->nama }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    @if($trx->uang_masuk > 0)
                                        <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                            </svg>
                                            {{ number_format($trx->uang_masuk, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    @if($trx->uang_keluar > 0)
                                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                            </svg>
                                            {{ number_format($trx->uang_keluar, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <span class="font-bold text-lg text-primary">{{ number_format($trx->saldo, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.transaksi-kas.edit', $trx) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.transaksi-kas.destroy', $trx) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Mobile Card View --}}
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($transaksi as $trx)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center min-w-[1.75rem] px-2 py-0.5 bg-gray-100 text-gray-700 font-semibold rounded text-sm">
                                    {{ $trx->no_urut }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ Str::limit($trx->uraian, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $trx->tanggal_formatted }} • {{ $trx->no_kwitansi ?? '-' }}</p>
                                </div>
                            </div>
                            @if($trx->kategori)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" 
                                      style="background-color: {{ $trx->kategori->warna }}15; color: {{ $trx->kategori->warna }}">
                                    {{ $trx->kategori->nama }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div class="bg-green-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-green-600 mb-0.5">Masuk</p>
                                <p class="font-bold text-green-600 text-sm">
                                    {{ $trx->uang_masuk > 0 ? number_format($trx->uang_masuk, 0, ',', '.') : '-' }}
                                </p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-red-600 mb-0.5">Keluar</p>
                                <p class="font-bold text-red-600 text-sm">
                                    {{ $trx->uang_keluar > 0 ? number_format($trx->uang_keluar, 0, ',', '.') : '-' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500">Saldo</p>
                                <p class="font-bold text-primary">{{ number_format($trx->saldo, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-1">
                                <a href="{{ route('admin.transaksi-kas.edit', $trx) }}" 
                                   class="p-2 text-blue-600 bg-blue-50 rounded-lg" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.transaksi-kas.destroy', $trx) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 bg-red-50 rounded-lg" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Pagination --}}
            <div class="p-4 border-t border-gray-100">
                {{ $transaksi->links('components.pagination') }}
            </div>
        @else
            <div class="p-8">
                <x-empty-state 
                    title="Belum ada transaksi"
                    description="Mulai catat transaksi kas harian Anda."
                    icon="document"
                    :actionRoute="route('admin.transaksi-kas.create')"
                    actionText="Tambah Transaksi"
                />
            </div>
        @endif
    </div>
@endsection
