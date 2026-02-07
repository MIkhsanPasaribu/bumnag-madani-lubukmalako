@extends('layouts.public')

@section('title', 'Statistik Keuangan ' . $tahunTerpilih)

@section('meta_description', 'Statistik dan analisis keuangan BUMNag Madani Lubuk Malako tahun ' . $tahunTerpilih . '. Grafik pendapatan, pengeluaran, dan laba rugi per unit usaha.')

@push('styles')
<style>
    .stat-badge { @apply inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold; }
    .chart-container { position: relative; width: 100%; }

    @media print {
        .no-print { display: none !important; }
        .print-break { page-break-before: always; }
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    {{-- Header with Gradient --}}
    <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 md:p-8 mb-8 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur rounded-full text-white/90 text-sm font-medium mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Laporan Analisis
            </div>
            <h1 class="text-2xl md:text-4xl font-bold text-white mb-3">Statistik Keuangan {{ $tahunTerpilih }}</h1>
            <p class="text-white/80 max-w-2xl mx-auto text-sm md:text-base">
                Analisis lengkap keuangan BUMNag Madani Lubuk Malako — pendapatan, pengeluaran, dan laba rugi per unit usaha.
            </p>
        </div>
    </div>

    {{-- Year Filter --}}
    <div class="flex justify-center mb-8 no-print">
        <div class="inline-flex items-center gap-1 bg-white rounded-xl shadow-sm border border-gray-200 p-1.5">
            @foreach($tahunTersedia as $thn)
                <a href="{{ route('statistik', ['tahun' => $thn]) }}"
                   class="px-5 py-2.5 text-sm font-semibold rounded-lg transition-all {{ $tahunTerpilih == $thn ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $thn }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ===== SECTION 1: Summary Cards ===== --}}
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
            <p class="text-xl lg:text-2xl font-bold text-green-600">Rp {{ number_format($statistik['total_pendapatan'], 0, ',', '.') }}</p>
            @if($growth['pendapatan'] != 0)
                <p class="text-xs mt-2 {{ $growth['pendapatan'] >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    {{ $growth['pendapatan'] >= 0 ? '+' : '' }}{{ number_format($growth['pendapatan'], 1) }}% dari {{ $tahunSebelumnya }}
                </p>
            @endif
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
            <p class="text-xl lg:text-2xl font-bold text-red-600">Rp {{ number_format($statistik['total_pengeluaran'], 0, ',', '.') }}</p>
            @if($growth['pengeluaran'] != 0)
                <p class="text-xs mt-2 {{ $growth['pengeluaran'] <= 0 ? 'text-green-600' : 'text-red-500' }}">
                    {{ $growth['pengeluaran'] >= 0 ? '+' : '' }}{{ number_format($growth['pengeluaran'], 1) }}% dari {{ $tahunSebelumnya }}
                </p>
            @endif
        </div>

        {{-- Laba / Rugi --}}
        <div class="bg-gradient-to-br {{ $statistik['total_laba_rugi'] >= 0 ? 'from-blue-50 to-indigo-50' : 'from-orange-50 to-amber-50' }} rounded-xl border {{ $statistik['total_laba_rugi'] >= 0 ? 'border-blue-100' : 'border-orange-100' }} p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 {{ $statistik['total_laba_rugi'] >= 0 ? 'bg-blue-100' : 'bg-orange-100' }} rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $statistik['total_laba_rugi'] >= 0 ? 'text-blue-600' : 'text-orange-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <p class="text-sm {{ $statistik['total_laba_rugi'] >= 0 ? 'text-blue-700' : 'text-orange-700' }} font-medium">Laba / Rugi</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold {{ $statistik['total_laba_rugi'] >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                Rp {{ number_format(abs($statistik['total_laba_rugi']), 0, ',', '.') }}
            </p>
        </div>

        {{-- Rasio Efisiensi --}}
        <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl border border-purple-100 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    </svg>
                </div>
                <p class="text-sm text-purple-700 font-medium">Rasio Efisiensi</p>
            </div>
            <p class="text-xl lg:text-2xl font-bold text-purple-600">{{ number_format($rasio['expense_ratio'], 1) }}%</p>
            <p class="text-xs text-gray-500 mt-1">Profit margin: {{ number_format($rasio['profit_margin'], 1) }}%</p>
        </div>
    </div>

    {{-- ===== SECTION 2: Monthly Chart ===== --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Grafik Keuangan Bulanan</h2>
                <p class="text-sm text-gray-500 mt-1">Tren pendapatan, pengeluaran, dan laba rugi per bulan</p>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#86ae5f]"></span> Pendapatan</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#b71e42]"></span> Pengeluaran</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#3b82f6]"></span> Laba/Rugi</span>
            </div>
        </div>
        <div class="chart-container" style="height: 350px;">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

    {{-- ===== SECTION 3: Unit Charts ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Pie Chart Pendapatan per Unit --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Pendapatan per Unit</h3>
            <p class="text-sm text-gray-500 mb-4">Proporsi pendapatan masing-masing unit usaha</p>
            <div class="chart-container" style="height: 280px;">
                <canvas id="chartPendapatanUnit"></canvas>
            </div>
        </div>

        {{-- Doughnut Pendapatan vs Pengeluaran --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Pendapatan vs Pengeluaran</h3>
            <p class="text-sm text-gray-500 mb-4">Perbandingan total pendapatan dan pengeluaran</p>
            <div class="chart-container" style="height: 280px;">
                <canvas id="chartProporsi"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 4: Rekap per Unit ===== --}}
    @foreach($rekapPerUnit as $unitItem)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $unitItem['unit']->nama }}</h2>
                <p class="text-sm text-gray-500 mt-1">Rekap bulanan — tahun {{ $tahunTerpilih }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="stat-badge bg-green-100 text-green-700">
                    Pendapatan: Rp {{ number_format($unitItem['statistik']['total_pendapatan'], 0, ',', '.') }}
                </span>
                <span class="stat-badge bg-red-100 text-red-700">
                    Pengeluaran: Rp {{ number_format($unitItem['statistik']['total_pengeluaran'], 0, ',', '.') }}
                </span>
                @php $labaUnit = $unitItem['statistik']['total_laba_rugi']; @endphp
                <span class="stat-badge {{ $labaUnit >= 0 ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                    Laba: Rp {{ number_format(abs($labaUnit), 0, ',', '.') }}
                </span>
            </div>
        </div>

        @if(count($unitItem['data']) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-600">Bulan</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pendapatan</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pengeluaran</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Laba / Rugi</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($unitItem['data'] as $row)
                    @php $laba = $row['total_pendapatan'] - $row['total_pengeluaran']; @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 font-medium text-gray-900">
                            {{ \App\Models\LaporanKeuangan::$namaBulan[$row['bulan']] ?? $row['bulan'] }}
                        </td>
                        <td class="py-3 px-4 text-right text-green-600 font-medium">
                            Rp {{ number_format($row['total_pendapatan'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right text-red-600 font-medium">
                            Rp {{ number_format($row['total_pengeluaran'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-semibold {{ $laba >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                            Rp {{ number_format(abs($laba), 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('statistik.detail', ['bulan' => $row['bulan'], 'tahun' => $tahunTerpilih]) }}"
                               class="inline-flex items-center gap-1 text-primary hover:text-primary-dark text-xs font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-300 bg-gray-50">
                        <td class="py-3 px-4 font-bold text-gray-900">Total</td>
                        <td class="py-3 px-4 text-right font-bold text-green-600">
                            Rp {{ number_format($unitItem['statistik']['total_pendapatan'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-bold text-red-600">
                            Rp {{ number_format($unitItem['statistik']['total_pengeluaran'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-bold {{ $labaUnit >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                            Rp {{ number_format(abs($labaUnit), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-gray-500 text-sm">Belum ada data untuk unit ini pada tahun {{ $tahunTerpilih }}</p>
        </div>
        @endif
    </div>
    @endforeach

    {{-- ===== SECTION 5: Rekap Gabungan Bulanan ===== --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-1">Rekap Gabungan Bulanan</h2>
        <p class="text-sm text-gray-500 mb-6">Rekap semua unit usaha per bulan — tahun {{ $tahunTerpilih }}</p>

        @if(count($rekapBulanan) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-600">Bulan</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pendapatan</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pengeluaran</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Laba / Rugi</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-600">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rekapBulanan as $row)
                    @php $laba = $row['total_pendapatan'] - $row['total_pengeluaran']; @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $row['nama_bulan'] }}</td>
                        <td class="py-3 px-4 text-right text-green-600 font-medium">
                            Rp {{ number_format($row['total_pendapatan'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right text-red-600 font-medium">
                            Rp {{ number_format($row['total_pengeluaran'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-semibold {{ $laba >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                            {{ $laba < 0 ? '-' : '' }}Rp {{ number_format(abs($laba), 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('statistik.detail', ['bulan' => $row['bulan'], 'tahun' => $tahunTerpilih]) }}"
                               class="inline-flex items-center gap-1 text-primary hover:text-primary-dark text-xs font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-300 bg-gray-50">
                        <td class="py-3 px-4 font-bold text-gray-900">Total Tahun {{ $tahunTerpilih }}</td>
                        <td class="py-3 px-4 text-right font-bold text-green-600">
                            Rp {{ number_format($statistik['total_pendapatan'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-bold text-red-600">
                            Rp {{ number_format($statistik['total_pengeluaran'], 0, ',', '.') }}
                        </td>
                        @php $totalLaba = $statistik['total_laba_rugi']; @endphp
                        <td class="py-3 px-4 text-right font-bold {{ $totalLaba >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                            {{ $totalLaba < 0 ? '-' : '' }}Rp {{ number_format(abs($totalLaba), 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="text-gray-500 text-sm">Belum ada data keuangan untuk tahun {{ $tahunTerpilih }}</p>
        </div>
        @endif
    </div>

    {{-- ===== SECTION 6: Proyeksi ===== --}}
    @if($statistik['jumlah_bulan'] > 0 && $statistik['jumlah_bulan'] < 12)
    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl border border-indigo-100 p-6 md:p-8 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Proyeksi Akhir Tahun</h2>
                <p class="text-sm text-gray-500">Berdasarkan rata-rata {{ $statistik['jumlah_bulan'] }} bulan terakhir</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-4 border border-indigo-100">
                <p class="text-sm text-gray-500 mb-1">Proyeksi Pendapatan</p>
                <p class="text-lg font-bold text-green-600">Rp {{ number_format($proyeksi['pendapatan_tahunan'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Avg/bulan: Rp {{ number_format($proyeksi['avg_monthly_income'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-indigo-100">
                <p class="text-sm text-gray-500 mb-1">Proyeksi Pengeluaran</p>
                <p class="text-lg font-bold text-red-600">Rp {{ number_format($proyeksi['pengeluaran_tahunan'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Avg/bulan: Rp {{ number_format($proyeksi['avg_monthly_expense'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-indigo-100">
                <p class="text-sm text-gray-500 mb-1">Proyeksi Laba</p>
                <p class="text-lg font-bold {{ $proyeksi['laba_proyeksi'] >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                    Rp {{ number_format(abs($proyeksi['laba_proyeksi']), 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Sisa {{ 12 - $statistik['jumlah_bulan'] }} bulan lagi</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Print Button --}}
    <div class="flex justify-center no-print">
        <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl text-sm font-semibold transition-colors shadow-lg shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Halaman
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartLabels = @json($chartData['labels']);
    const chartPendapatan = @json($chartData['pendapatan']);
    const chartPengeluaran = @json($chartData['pengeluaran']);
    const chartLabaRugi = @json($chartData['laba_rugi']);
    const unitChartData = @json($unitChartData);
    const proporsiData = @json($proporsiData);

    // ====== Chart 1: Monthly Bar/Line ======
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartPendapatan,
                    backgroundColor: 'rgba(134,174,95,0.7)',
                    borderColor: '#86ae5f',
                    borderWidth: 1,
                    borderRadius: 6,
                    order: 2,
                },
                {
                    label: 'Pengeluaran',
                    data: chartPengeluaran,
                    backgroundColor: 'rgba(183,30,66,0.7)',
                    borderColor: '#b71e42',
                    borderWidth: 1,
                    borderRadius: 6,
                    order: 2,
                },
                {
                    label: 'Laba/Rugi',
                    data: chartLabaRugi,
                    type: 'line',
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#3b82f6',
                    borderWidth: 2,
                    order: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(v)
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // ====== Chart 2: Pie - Pendapatan per Unit ======
    if (unitChartData.length > 0) {
        new Chart(document.getElementById('chartPendapatanUnit'), {
            type: 'pie',
            data: {
                labels: unitChartData.map(u => u.nama),
                datasets: [{
                    data: unitChartData.map(u => u.pendapatan),
                    backgroundColor: unitChartData.map(u => u.warna),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16 } },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                        }
                    }
                }
            }
        });
    }

    // ====== Chart 3: Doughnut - Pendapatan vs Pengeluaran ======
    new Chart(document.getElementById('chartProporsi'), {
        type: 'doughnut',
        data: {
            labels: proporsiData.labels,
            datasets: [{
                data: proporsiData.data,
                backgroundColor: proporsiData.colors,
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 16 } },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            }
        }
    });
});
</script>
@endpush
