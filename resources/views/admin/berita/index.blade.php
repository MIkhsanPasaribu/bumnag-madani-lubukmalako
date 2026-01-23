@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span class="current">Berita</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-bumnag-gray">Kelola Berita</h1>
            <p class="text-gray-500">Tambah, edit, atau hapus berita</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Berita
        </a>
    </div>
    
    <div class="table-container overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="table-header">Judul</th>
                    <th class="table-header">Kategori</th>
                    <th class="table-header">Tanggal</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Views</th>
                    <th class="table-header text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($berita as $item)
                <tr class="hover:bg-gray-50">
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="" class="w-12 h-12 object-cover rounded-lg">
                            @else
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-bumnag-gray truncate max-w-xs">{{ $item->judul }}</p>
                                <p class="text-xs text-gray-500">{{ $item->penulis ?? 'Admin' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="table-cell">
                        <span class="badge badge-info">{{ $item->kategori ?? '-' }}</span>
                    </td>
                    <td class="table-cell">{{ $item->published_at?->format('d M Y') }}</td>
                    <td class="table-cell">
                        @if($item->is_published)
                        <span class="badge badge-success">Dipublikasi</span>
                        @else
                        <span class="badge badge-warning">Draft</span>
                        @endif
                    </td>
                    <td class="table-cell">{{ $item->views }}</td>
                    <td class="table-cell text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.berita.edit', $item) }}" class="p-2 text-gray-500 hover:text-bumnag-olive hover:bg-bumnag-olive/10 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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
                        Belum ada berita. <a href="{{ route('admin.berita.create') }}" class="text-bumnag-olive hover:underline">Tambah berita pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($berita->hasPages())
    <div class="flex justify-center">
        {{ $berita->links() }}
    </div>
    @endif
</div>
@endsection
