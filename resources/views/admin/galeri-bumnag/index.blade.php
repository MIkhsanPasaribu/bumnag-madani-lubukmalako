@extends('layouts.admin')

@section('title', 'Galeri BUMNag')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📸 Galeri BUMNag Madani Lubuk Malako</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola foto-foto BUMNag Madani</p>
        </div>
        <a href="{{ route('admin.galeri-bumnag.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Foto
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bento-card-flat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Foto</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAll }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bento-card-flat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bento-card-flat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Tidak Aktif</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $totalTidakAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.galeri-bumnag.index', ['archived' => '1']) }}" class="bento-card-flat hover:bg-orange-50 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Diarsipkan</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $totalArchived }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    {{-- Filters --}}
    <div class="bento-card-flat">
        <form method="GET" action="{{ route('admin.galeri-bumnag.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="🔍 Cari judul atau deskripsi..." class="form-input">
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="w-full md:w-40">
                <select name="archived" class="form-input">
                    <option value="">Foto Aktif</option>
                    <option value="1" {{ request('archived') === '1' ? 'selected' : '' }}>Arsip</option>
                </select>
            </div>
            <div class="w-full md:w-40">
                <select name="tahun" class="form-input">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    Filter
                </button>
                <a href="{{ route('admin.galeri-bumnag.index') }}" class="btn-outline">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Gallery Grid --}}
    @if($galeri->count() > 0)
        {{-- Alpine scope untuk preview modal --}}
        <div x-data="{
                previewItem: { foto_url: '', judul: '', deskripsi: '', tanggal: '', status: '' },
                openPreview(foto_url, judul, deskripsi, tanggal, status) {
                    this.previewItem = { foto_url, judul, deskripsi, tanggal, status };
                    $dispatch('open-modal-preview-galeri-admin');
                }
             }">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="galeri-grid">
                @foreach($galeri as $item)
                    <div class="bento-card group" data-id="{{ $item->id }}">
                        {{-- Image --}}
                        <div class="relative aspect-[4/3] overflow-hidden rounded-lg bg-gray-100 mb-4">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ $item->trashed() ? 'opacity-50' : '' }}" loading="lazy">

                            {{-- Archived badge --}}
                            @if($item->trashed())
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    Diarsipkan
                                </div>
                            @endif
                            
                            {{-- Overlay on Hover --}}
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                                {{-- Preview --}}
                                <button @click.stop="openPreview(
                                            '{{ addslashes($item->foto_url) }}',
                                            '{{ addslashes($item->judul) }}',
                                            '{{ addslashes($item->deskripsi ?? '') }}',
                                            '{{ $item->created_at->format('d M Y') }}',
                                            '{{ $item->status_label }}'
                                        )"
                                        class="bg-white text-primary p-2 rounded-lg hover:bg-primary hover:text-white transition" title="Preview">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                @if($item->trashed())
                                    {{-- Pulihkan --}}
                                    <form action="{{ route('admin.galeri-bumnag.restore', $item->id) }}" method="POST" class="inline" @click.stop>
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 transition" title="Pulihkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </form>
                                    {{-- Hapus Permanen --}}
                                    <button onclick="confirmAction({
                                        title: 'Hapus Foto Permanen',
                                        message: 'Yakin ingin menghapus foto ini secara permanen? File gambar juga akan dihapus. Aksi ini tidak dapat dibatalkan!',
                                        actionUrl: '{{ route('admin.galeri-bumnag.force-delete', $item->id) }}',
                                        method: 'DELETE',
                                        type: 'danger',
                                        confirmText: 'Hapus Permanen'
                                    })" class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition" title="Hapus Permanen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @else
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.galeri-bumnag.edit', $item->id) }}" class="bg-white text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    {{-- Toggle Status (fetch langsung, bukan form submit) --}}
                                    <button onclick="toggleStatus({{ $item->id }})" class="bg-white text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition" title="Ubah Status ({{ $item->status_label }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </button>
                                    {{-- Arsipkan --}}
                                    <button onclick="confirmAction({
                                        title: 'Arsipkan Foto',
                                        message: 'Yakin ingin mengarsipkan foto ini? Foto dapat dipulihkan dari arsip.',
                                        actionUrl: '{{ route('admin.galeri-bumnag.destroy', $item->id) }}',
                                        method: 'DELETE',
                                        type: 'archive',
                                        confirmText: 'Arsipkan'
                                    })" class="bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition" title="Arsipkan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </button>
                                    {{-- Hapus Permanen --}}
                                    <button onclick="confirmAction({
                                        title: 'Hapus Foto Permanen',
                                        message: 'Yakin ingin menghapus foto ini secara permanen? File gambar juga akan dihapus. Aksi ini tidak dapat dibatalkan!',
                                        actionUrl: '{{ route('admin.galeri-bumnag.force-delete', $item->id) }}',
                                        method: 'DELETE',
                                        type: 'danger',
                                        confirmText: 'Hapus Permanen'
                                    })" class="bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition" title="Hapus Permanen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            {{-- Drag Handle --}}
                            <div class="absolute top-2 left-2 bg-white/90 p-1.5 rounded cursor-move drag-handle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                </svg>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $item->judul }}</h3>
                            @if($item->deskripsi)
                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $item->deskripsi }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-xs px-2 py-1 rounded-full {{ $item->status_badge_class }}">
                                    {{ $item->status_label }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $galeri->links() }}
            </div>

            {{-- Preview Modal --}}
            <x-modal name="preview-galeri-admin" title="Preview Foto" maxWidth="2xl">
                <div class="-mx-6 -mt-4">
                    {{-- Gambar --}}
                    <div class="bg-gray-900 rounded-t-lg overflow-hidden">
                        <img :src="previewItem.foto_url" :alt="previewItem.judul"
                             class="w-full max-h-[55vh] object-contain mx-auto block">
                    </div>
                    {{-- Info --}}
                    <div class="px-6 py-4 space-y-2">
                        <h3 class="font-bold text-gray-900 text-lg" x-text="previewItem.judul"></h3>
                        <p class="text-gray-600 text-sm leading-relaxed" x-show="previewItem.deskripsi" x-text="previewItem.deskripsi"></p>
                        <div class="flex items-center gap-3 pt-1">
                            <span class="text-xs text-gray-400" x-text="previewItem.tanggal"></span>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                  :class="previewItem.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'"
                                  x-text="previewItem.status"></span>
                        </div>
                    </div>
                </div>
                <x-slot name="footer">
                    <button @click="$dispatch('close-modal-preview-galeri-admin')" class="btn-outline text-sm px-4 py-2">
                        Tutup
                    </button>
                </x-slot>
            </x-modal>
        </div>
    @else
        {{-- Empty State --}}
        <div class="bento-card text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Foto</h3>
            <p class="text-gray-600 mb-4">Mulai tambahkan foto untuk galeri BUMNag Madani.</p>
            <a href="{{ route('admin.galeri-bumnag.create') }}" class="btn-primary">
                Tambah Foto Pertama
            </a>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi --}}
<x-confirm-modal />

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Drag & Drop Reordering
    const grid = document.getElementById('galeri-grid');
    if (grid) {
        new Sortable(grid, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function(evt) {
                const order = Array.from(grid.children).map(el => el.dataset.id);
                
                fetch('{{ route('admin.galeri-bumnag.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success notification
                        console.log(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }

    // Toggle Status
    function toggleStatus(id) {
        fetch(`/admin/galeri-bumnag/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengubah status');
        });
    }
</script>
@endpush
@endsection
