@extends('layouts.app')

@section('title', 'Statistik Laporan Keuangan - BUMNag Madani Lubuk Malako')
@section('page-title', 'Statistik Laporan Keuangan')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-bumnag-olive/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-bumnag-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan {{ date('Y') }}</p>
                    <p class="text-xl font-bold text-bumnag-gray">
                        Rp {{ number_format($laporanBulanan->sum('pendapatan'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-bumnag-red/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-bumnag-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pengeluaran {{ date('Y') }}</p>
                    <p class="text-xl font-bold text-bumnag-gray">
                        Rp {{ number_format($laporanBulanan->sum('pengeluaran'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Aset</p>
                    <p class="text-xl font-bold text-bumnag-gray">
                        Rp {{ number_format($totalAset, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bento-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Modal</p>
                    <p class="text-xl font-bold text-bumnag-gray">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-bumnag-gray mb-6">Perbandingan Tahunan</h3>
            <div class="h-72">
                <canvas id="chartTahunan"></canvas>
            </div>
        </div>
        
        <div class="bento-card">
            <h3 class="text-lg font-semibold text-bumnag-gray mb-6">Laba/Rugi Tahunan</h3>
            <div class="h-72">
                <canvas id="chartLabaRugi"></canvas>
            </div>
        </div>
    </div>
    
    <div class="bento-card">
        <h3 class="text-lg font-semibold text-bumnag-gray mb-6">Tren Bulanan {{ date('Y') }}</h3>
        <div class="h-80">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
    
    <div class="bento-card">
        <h3 class="text-lg font-semibold text-bumnag-gray mb-6">Ringkasan Per Tahun</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-600">Tahun</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pendapatan</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Pengeluaran</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-600">Laba/Rugi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanTahunan as $laporan)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $laporan->tahun }}</td>
                        <td class="py-3 px-4 text-right text-bumnag-olive font-medium">
                            Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right text-bumnag-red font-medium">
                            Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-right font-bold {{ $laporan->total_laba_rugi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($laporan->total_laba_rugi, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data laporan keuangan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tahunan = @json($laporanTahunan);
    const bulanan = @json($laporanBulanan);
    
    if (document.getElementById('chartTahunan') && tahunan.length > 0) {
        new Chart(document.getElementById('chartTahunan'), {
            type: 'bar',
            data: {
                labels: tahunan.map(d => d.tahun),
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: tahunan.map(d => d.total_pendapatan),
                        backgroundColor: '#A5A71C',
                        borderRadius: 8,
                    },
                    {
                        label: 'Pengeluaran',
                        data: tahunan.map(d => d.total_pengeluaran),
                        backgroundColor: '#8B1A1A',
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
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
    }
    
    if (document.getElementById('chartLabaRugi') && tahunan.length > 0) {
        new Chart(document.getElementById('chartLabaRugi'), {
            type: 'line',
            data: {
                labels: tahunan.map(d => d.tahun),
                datasets: [{
                    label: 'Laba/Rugi',
                    data: tahunan.map(d => d.total_laba_rugi),
                    borderColor: '#A5A71C',
                    backgroundColor: 'rgba(165, 167, 28, 0.1)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
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
    }
    
    if (document.getElementById('chartBulanan') && bulanan.length > 0) {
        new Chart(document.getElementById('chartBulanan'), {
            type: 'line',
            data: {
                labels: bulanan.map(d => d.bulan),
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: bulanan.map(d => d.pendapatan),
                        borderColor: '#A5A71C',
                        backgroundColor: 'rgba(165, 167, 28, 0.1)',
                        fill: false,
                        tension: 0.4,
                    },
                    {
                        label: 'Pengeluaran',
                        data: bulanan.map(d => d.pengeluaran),
                        borderColor: '#8B1A1A',
                        backgroundColor: 'rgba(139, 26, 26, 0.1)',
                        fill: false,
                        tension: 0.4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
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
    }
});
</script>
@endpush
@endsection
