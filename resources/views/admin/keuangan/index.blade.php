@extends('layouts.admin')

@section('title', 'Kelola Laporan Keuangan')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Laporan Keuangan</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-bumnag-gray">Kelola Laporan Keuangan</h1>
            <p class="text-gray-500">Tambah, edit, atau hapus laporan keuangan bulanan</p>
        </div>
        <a href="{{ route('admin.keuangan.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Laporan
        </a>
    </div>
    
    <div class="table-container overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-header">Periode</th>
                    <th class="table-header">Pendapatan</th>
                    <th class="table-header">Pengeluaran</th>
                    <th class="table-header">Laba/Rugi</th>
                    <th class="table-header">Status</th>
                    <th class="table-header text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp
                @forelse($laporan as $item)
                <tr class="hover:bg-gray-50">
                    <td class="table-cell font-medium">{{ $namaBulan[$item->bulan] }} {{ $item->tahun }}</td>
                    <td class="table-cell text-green-600">Rp {{ number_format($item->pendapatan, 0, ',', '.') }}</td>
                    <td class="table-cell text-red-600">Rp {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                    <td class="table-cell {{ ($item->pendapatan - $item->pengeluaran) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($item->pendapatan - $item->pengeluaran, 0, ',', '.') }}
                    </td>
                    <td class="table-cell">
                        @if($item->is_published)
                        <span class="badge badge-success">Publik</span>
                        @else
                        <span class="badge badge-warning">Draft</span>
                        @endif
                    </td>
                    <td class="table-cell text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.keuangan.edit', $item) }}" class="p-2 text-gray-500 hover:text-bumnag-olive hover:bg-bumnag-olive/10 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.keuangan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="table-cell text-center py-8 text-gray-500">
                        Belum ada laporan. <a href="{{ route('admin.keuangan.create') }}" class="text-bumnag-olive hover:underline">Tambah laporan pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($laporan->hasPages())
    <div class="flex justify-center">
        {{ $laporan->links() }}
    </div>
    @endif
</div>
@endsection
