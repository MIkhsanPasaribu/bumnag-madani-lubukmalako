@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
{{-- Welcome Card --}}
<div class="bento-card bg-gradient-to-r from-primary to-primary-dark text-white mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-white/80">Panel administrasi BUMNag Madani Lubuk Malako</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Berita
            </a>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    {{-- Total Berita --}}
    <div class="bento-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Berita</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBerita }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $totalBeritaPublished }} dipublikasi</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
        </div>
    </div>
    
    {{-- Total Laporan Tahunan --}}
    <div class="bento-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Laporan Tahunan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalLaporanTahunan }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $totalLaporanPublished }} dipublikasi</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>
    
    {{-- Total Laporan Keuangan --}}
    <div class="bento-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Laporan Keuangan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalLaporanKeuangan }}</p>
                <p class="text-xs text-green-600 mt-1">Per unit/sub-unit</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>
    
    {{-- Laba/Rugi Tahun Ini --}}
    <div class="bento-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Laba/Rugi {{ $tahunIni }}</p>
                <p class="text-2xl font-bold {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}">
                    {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? '+' : '' }}Rp {{ number_format($statistikKeuangan['total_laba_rugi'] ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div class="w-12 h-12 {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'bg-primary/10' : 'bg-red-100' }} rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ ($statistikKeuangan['total_laba_rugi'] ?? 0) >= 0 ? 'text-primary' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Content Row --}}
<div class="grid lg:grid-cols-2 gap-6">
    {{-- Chart --}}
    <div class="bento-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Grafik Keuangan {{ $tahunIni }}</h3>
            <a href="{{ route('admin.laporan-keuangan.index') }}" class="text-sm text-primary hover:underline">Lihat Detail</a>
        </div>
        <div class="h-64">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
    
    {{-- Recent Berita --}}
    <div class="bento-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Berita Terbaru</h3>
            <a href="{{ route('admin.berita.index') }}" class="text-sm text-primary hover:underline">Lihat Semua</a>
        </div>
        
        @if($beritaTerbaru->count() > 0)
            <div class="space-y-3">
                @foreach($beritaTerbaru as $berita)
                    <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        @if($berita->gambar)
                            <img src="{{ $berita->gambar_url }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 line-clamp-1">{{ $berita->judul }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $berita->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge {{ $berita->status === 'published' ? 'badge-success' : 'badge-warning' }} text-xs">
                            {{ $berita->status === 'published' ? 'Publik' : 'Draft' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm text-center py-8">Belum ada berita</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    
    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData.pendapatan,
                    backgroundColor: 'rgba(134, 174, 95, 0.8)',
                    borderRadius: 4
                },
                {
                    label: 'Pengeluaran',
                    data: chartData.pengeluaran,
                    backgroundColor: 'rgba(183, 30, 66, 0.8)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(0) + ' Jt';
                            }
                            return value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
