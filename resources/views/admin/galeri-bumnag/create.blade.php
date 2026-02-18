@extends('layouts.admin')

@section('title', 'Tambah Foto Galeri')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.galeri-bumnag.index') }}" class="btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Foto Galeri</h1>
            <p class="text-sm text-gray-600 mt-1">Upload foto baru untuk galeri BUMNag Madani</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="bento-card">
        <form action="{{ route('admin.galeri-bumnag.store') }}" method="POST" enctype="multipart/form-data" x-data="{ 
            preview: null,
            isDragging: false,
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.preview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },
            handleDrop(event) {
                this.isDragging = false;
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    document.getElementById('foto').files = event.dataTransfer.files;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.preview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            }
        }">
            @csrf

            {{-- Upload Foto --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload Foto <span class="text-red-500">*</span>
                </label>
                
                <div 
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop"
                    :class="isDragging ? 'border-primary bg-primary/5' : 'border-gray-300'"
                    class="border-2 border-dashed rounded-xl p-8 text-center transition-colors cursor-pointer hover:border-primary hover:bg-gray-50"
                    onclick="document.getElementById('foto').click()"
                >
                    <input 
                        type="file" 
                        id="foto" 
                        name="foto" 
                        accept="image/jpeg,image/png,image/jpg" 
                        class="hidden"
                        @change="handleFileSelect"
                        required
                    >
                    
                    <div x-show="!preview">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-gray-600 font-medium mb-1">Drop file atau klik untuk upload</p>
                        <p class="text-sm text-gray-500">Format: JPG, JPEG, PNG • Maksimal 2MB</p>
                    </div>
                    
                    <div x-show="preview" class="relative">
                        <img :src="preview" class="max-h-64 mx-auto rounded-lg shadow-lg">
                        <button 
                            type="button" 
                            @click.stop="preview = null; document.getElementById('foto').value = ''"
                            class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                @error('foto')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul --}}
            <div class="mb-6" x-data="{ count: {{ mb_strlen(old('judul', '')) }} }">
                <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="judul" 
                    name="judul" 
                    value="{{ old('judul') }}"
                    placeholder="Misal: Tim BUMNag Madani 2026"
                    class="form-input @error('judul') border-red-500 @enderror"
                    maxlength="255"
                    x-on:input="count = $el.value.length"
                    required
                >
                <div class="flex justify-between items-center mt-1">
                    @error('judul')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 230 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/255'">0/255</p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6" x-data="{ count: {{ mb_strlen(old('deskripsi', '')) }} }">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="4"
                    placeholder="Tambahkan deskripsi detail tentang foto ini..."
                    class="form-input @error('deskripsi') border-red-500 @enderror"
                    maxlength="2000"
                    x-on:input="count = $el.value.length"
                >{{ old('deskripsi') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    @error('deskripsi')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <p class="text-xs ml-auto flex-shrink-0 transition-colors" :class="count >= 1800 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="count + '/2000'">0/2000</p>
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-4">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="status" 
                            value="aktif" 
                            {{ old('status', 'aktif') === 'aktif' ? 'checked' : '' }}
                            class="w-4 h-4 text-primary focus:ring-primary"
                        >
                        <span class="ml-2 text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="status" 
                            value="tidak_aktif" 
                            {{ old('status') === 'tidak_aktif' ? 'checked' : '' }}
                            class="w-4 h-4 text-primary focus:ring-primary"
                        >
                        <span class="ml-2 text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Foto
                </button>
                <a href="{{ route('admin.galeri-bumnag.index') }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
