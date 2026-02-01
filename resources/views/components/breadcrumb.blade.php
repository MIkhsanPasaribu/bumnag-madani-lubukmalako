{{-- Breadcrumb Component --}}
@php
    $segments = request()->segments();
    $breadcrumbs = [];
    $path = '';
    
    // Mapping untuk nama yang lebih user-friendly
    $nameMapping = [
        'admin' => 'Admin',
        'profil' => 'Profil BUMNag',
        'statistik' => 'Statistik Keuangan',
        'transparansi' => 'Transparansi',
        'berita' => 'Berita',
        'pengumuman' => 'Pengumuman',
        'keuangan' => 'Laporan Keuangan',
        'dashboard' => 'Dashboard',
        'create' => 'Tambah',
        'edit' => 'Edit',
    ];
@endphp

<nav class="flex items-center text-sm" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        {{-- Home --}}
        <li>
            <a href="{{ route('beranda') }}" class="text-gray-500 hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
        </li>
        
        @foreach($segments as $index => $segment)
            @php
                $path .= '/' . $segment;
                $isLast = $index === count($segments) - 1;
                $displayName = $nameMapping[$segment] ?? ucfirst(str_replace('-', ' ', $segment));
                
                // Skip numeric segments (usually IDs)
                if (is_numeric($segment)) continue;
            @endphp
            
            <li class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                
                @if($isLast)
                    <span class="text-primary font-medium">{{ $displayName }}</span>
                @else
                    <a href="{{ $path }}" class="text-gray-500 hover:text-primary transition-colors">
                        {{ $displayName }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
