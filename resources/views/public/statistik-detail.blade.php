@extends('layouts.public')

@section('title', 'Detail Buku Kas - ' . ($rekap['nama_bulan'] ?? '') . ' ' . $tahun)

@section('meta_description', 'Detail transaksi kas harian BUMNag Madani Lubuk Malako periode ' . ($rekap['nama_bulan'] ?? '') . ' ' . $tahun)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8">
        <a href="{{ route('statistik', ['tahun' => $tahun]) }}" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Buku Kas Harian</h1>
            <p class="text-gray-600">Periode: {{ $rekap['nama_bulan'] ?? '' }} {{ $tahun }}</p>
        </div>
        
        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-2">
            {{-- Print Button --}}
            <button onclick="window.print()" class="btn-outline" title="Cetak Halaman">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span class="hidden sm:inline">Print</span>
            </button>
            
            {{-- Share WhatsApp --}}
            <a href="https://wa.me/?text=Lihat%20laporan%20keuangan%20BUMNag%20Madani%20Lubuk%20Malako%20periode%20{{ $rekap['nama_bulan'] ?? '' }}%20{{ $tahun }}%20%0A{{ urlencode(url()->current()) }}" 
               target="_blank" class="btn-outline text-green-600 border-green-600 hover:bg-green-50" title="Share via WhatsApp">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.019-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span class="hidden sm:inline">Share</span>
            </a>
            
            {{-- Download Excel --}}
            <a href="{{ route('transparansi.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
               class="btn-outline text-green-700 border-green-700 hover:bg-green-50" title="Download Excel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="hidden sm:inline">Excel</span>
            </a>
            
            {{-- Download PDF --}}
            <a href="{{ route('transparansi.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
               class="btn-primary" title="Download PDF">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="hidden sm:inline">PDF</span>
            </a>
        </div>
    </div>
    
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bento-card text-center">
            <p class="text-sm text-gray-500 mb-1">Saldo Awal</p>
            <p class="text-lg font-bold text-gray-700">Rp {{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bento-card text-center">
            <p class="text-sm text-gray-500 mb-1">Total Uang Masuk</p>
            <p class="text-lg font-bold text-green-600">Rp {{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bento-card text-center">
            <p class="text-sm text-gray-500 mb-1">Total Uang Keluar</p>
            <p class="text-lg font-bold text-red-600">Rp {{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bento-card text-center">
            <p class="text-sm text-gray-500 mb-1">Saldo Akhir</p>
            <p class="text-lg font-bold text-primary">Rp {{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
    
    {{-- Table Buku Kas --}}
    <div class="bento-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Transaksi</h3>
            <span class="text-sm text-gray-500">{{ $rekap['jumlah_transaksi'] ?? 0 }} transaksi</span>
        </div>
        
        @if($transaksi->count() > 0)
            {{-- Scroll indicator for mobile --}}
            <div class="relative">
                <div class="overflow-x-auto scrollbar-thin" id="tableWrapper">
                    <table class="data-table w-full min-w-[800px]">
                        <thead>
                            <tr>
                                <th class="text-center w-16">NO URUT</th>
                                <th class="text-center w-24">NO KW</th>
                                <th class="text-center w-28">TANGGAL</th>
                                <th class="text-left">URAIAN</th>
                                <th class="text-left w-28">KATEGORI</th>
                                <th class="text-right w-32">UANG MASUK</th>
                                <th class="text-right w-32">UANG KELUAR</th>
                                <th class="text-right w-32">SALDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Saldo Awal Row --}}
                            <tr class="bg-gray-50 font-semibold">
                                <td class="text-center" colspan="5">SALDO AWAL BULAN</td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                                <td class="text-right">{{ number_format($rekap['saldo_awal'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            
                            @foreach($transaksi as $trx)
                                <tr class="hover:bg-gray-50">
                                    <td class="text-center font-medium">{{ $trx->no_urut }}</td>
                                    <td class="text-center text-sm">{{ $trx->no_kwitansi ?? '-' }}</td>
                                    <td class="text-center text-sm">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                    <td class="text-sm">{{ $trx->uraian }}</td>
                                    <td class="text-sm">
                                        @if($trx->kategori)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" 
                                                  style="background-color: {{ $trx->kategori->warna }}20; color: {{ $trx->kategori->warna }}">
                                                {{ $trx->kategori->nama }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="text-right {{ $trx->uang_masuk > 0 ? 'text-green-600 font-medium' : 'text-gray-400' }}">
                                        {{ $trx->uang_masuk > 0 ? number_format($trx->uang_masuk, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-right {{ $trx->uang_keluar > 0 ? 'text-red-600 font-medium' : 'text-gray-400' }}">
                                        {{ $trx->uang_keluar > 0 ? number_format($trx->uang_keluar, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-right font-bold text-primary">
                                        {{ number_format($trx->saldo, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            
                            {{-- Total Row --}}
                            <tr class="bg-gray-50 font-semibold">
                                <td class="text-center" colspan="5">TOTAL</td>
                                <td class="text-right text-green-600">{{ number_format($rekap['total_masuk'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right text-red-600">{{ number_format($rekap['total_keluar'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right text-primary">{{ number_format($rekap['saldo_akhir'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                {{-- Scroll Indicator (shows only on mobile when scrollable) --}}
                <div class="scroll-indicator absolute right-2 bottom-2 bg-gray-800/70 text-white text-xs px-2 py-1 rounded hidden sm:hidden" id="scrollIndicator">
                    → geser
                </div>
            </div>
        @else
            <x-empty-state 
                title="Tidak ada transaksi"
                description="Belum ada transaksi kas untuk periode ini."
                icon="document"
            />
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
