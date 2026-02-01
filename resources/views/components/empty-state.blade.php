{{-- Empty State Component --}}
@props([
    'title' => 'Tidak ada data',
    'description' => 'Belum ada data yang tersedia saat ini.',
    'icon' => 'document', // document, search, folder, users
    'action' => null,
    'actionText' => 'Tambah Data',
    'actionRoute' => null
])

@php
    $icons = [
        'document' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
        'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
    ];
    
    $iconPath = $icons[$icon] ?? $icons['document'];
@endphp

<div class="text-center py-12 px-4">
    {{-- Icon --}}
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $iconPath !!}
        </svg>
    </div>
    
    {{-- Title --}}
    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    
    {{-- Description --}}
    <p class="text-gray-500 max-w-md mx-auto mb-6">{{ $description }}</p>
    
    {{-- Action Button --}}
    @if($actionRoute)
        <a href="{{ $actionRoute }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ $actionText }}
        </a>
    @endif
    
    {{ $slot }}
</div>
